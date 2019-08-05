<?php

namespace App\Controller\Api;

use App\Entity\Bagel;
use App\Entity\Billing;
use App\Entity\Boisson;
use App\Entity\Dessert;
use App\Entity\Formule;
use App\Entity\FormuleContainer;
use App\Entity\Panini;
use App\Entity\Salade;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/billings")
 * Class BillingController
 * @package App\Controller\Api
 */
class BillingController extends AbstractFOSRestController {
	/**
	 * @Rest\View(serializerGroups={"billing:read"})
	 * @Rest\Get("")
	 */
	public function getBillingsAction() {
		$billings = $this->getDoctrine()->getRepository( Billing::class )->findAll();

		return $billings;
	}

	/**
	 * @Rest\View(serializerGroups={"billing:read"})
	 * @Rest\Get("/{id}")
	 */
	public function getBillingAction( Request $request ) {
		$billing = $this->getDoctrine()->getRepository( Billing::class )->find( $request->get( 'id' ) );
		if ( empty( $billing ) ) {
			return new JsonResponse( [ 'message' => 'Billing not found' ], Response::HTTP_NOT_FOUND );
		}

		return $billing;

	}

	/**
	 * @Rest\View(serializerGroups={"billing:post"})
	 * @Rest\Post("")
	 * @param Request $request
	 *
	 * @return Billing
	 */
	public function postBillingsAction( Request $request ) {
		$body = json_decode( $request->getContent(), true );
		$total_price = 0;

		$billing = new Billing();
		$billing->setFirstName( $body['infos']['first_name'] );
		$billing->setLastName( $body['infos']['last_name'] );
		$billing->setEmail( $body['infos']['email'] );

		$billing->setPhoneNumber( $body['infos']['phone_number'] );
		$billing->setPaymentMethod( 'stripe' );

		$billing->setPickupHour( $body['infos']['retrait'] );

		if ($body['infos']['take_mode'] === 'retrait') {
			$billing->setDeliveryMethod($body['infos']['take_mode']);
			$billing->setPickupHour($body['infos']['retrait']);
		} else {
			$billing->setBillingAddress($body['infos']['billing_address']);
			$billing->setBillingAddress($body['infos']['billing_city']);
		}


		if ( array_key_exists( 'products', $body ) && ! empty( $body['products'] ) ) {
			foreach ( $body['products'] as $product ) {
				if ( array_key_exists( 'bagel', $product ) ) {
					$bagel = $this->getDoctrine()->getRepository( Bagel::class )->find( $product['bagel'] );
					$billing->addBagel( $bagel );
					$total_price += $bagel->getPrice();
				}
				if ( array_key_exists( 'panini', $product ) ) {
					$panini = $this->getDoctrine()->getRepository( Panini::class )->find( $product['panini'] );
					$billing->addPanini( $panini );
					$total_price += $panini->getPrice();
				}
				if ( array_key_exists( 'boisson', $product ) ) {
					$boisson = $this->getDoctrine()->getRepository( Boisson::class )->find( $product['boisson'] );
					$billing->addBoisson( $boisson );
					 $total_price += $boisson->getPrice();
				}
				if ( array_key_exists( 'dessert', $product ) ) {
					$dessert = $this->getDoctrine()->getRepository( Dessert::class )->find( $product['dessert'] );
					$billing->addDessert( $dessert );
					$total_price += $dessert->getPrice();
				}
			}
		}
		if ( array_key_exists( 'formules', $body ) && ! empty( $body['formules'] ) ) {
			foreach ( $body['formules'] as $formule ) {
				$formuleContainer = $this->getDoctrine()->getRepository( FormuleContainer::class )->find( $formule['id'] );
				$billing->addFormuleContainer( $formuleContainer );
				$total_price += $formuleContainer->getPrice();
			}
		}

		$billing->setTotalPrice($total_price);

		$em = $this->getDoctrine()->getManager();
		$em->persist( $billing );
		$em->flush();

		return $billing;
	}
}
