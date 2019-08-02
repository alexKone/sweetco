<?php

namespace App\Controller\Api;

use App\Entity\Billing;
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
class BillingController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"billing:read"})
	 * @Rest\Get("")
	 */
	public function getBillingsAction(  ) {
		$billings = $this->getDoctrine()->getRepository(Billing::class)->findAll();
		return $billings;
	}

	/**
	 * @Rest\View(serializerGroups={"billing:read"})
	 * @Rest\Get("/{id}")
	 */
	public function getBillingAction( Request $request ) {
		$billing = $this->getDoctrine()->getRepository(Billing::class)->find($request->get('id'));
		if (empty($billing)) {
			return new JsonResponse(['message' => 'Billing not found'], Response::HTTP_NOT_FOUND);
		}
		return $billing;

	}

	/**
	 * @Rest\View(serializerGroups={"billing:post"})
	 * @Rest\Post("")
	 * @param Request $request
	 */
	public function postBillingsAction( Request $request ) {
		$billing = new Billing();
//		dump();
//		die();
		$salade = $this->getDoctrine()->getRepository(Salade::class)->find($request->get('salade'));
		dump($salade);
		die();

		$request->get('first_name');
		$request->get('last_name');
		$request->get('phone_number');
		$request->get('email');
		$request->get('paymentMethod');
		$request->get('createdAt');
		$request->get('totalPrice');
		$request->get('billingAddress');
		$request->get('billingCity');
		$request->get('billingZipcode');
		$request->get('deliveryMethod');
		$request->get('pickupHour');
		$request->get('formules');
		$request->get('boissons');
		$request->get('dessert');
		$request->get('bagels');
		$request->get('paninis');
	}
}
