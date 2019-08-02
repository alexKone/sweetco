<?php

namespace App\Controller\Api;

use App\Entity\Billing;
use App\Entity\Formule;
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
	 *
	 * @return Billing
	 */
	public function postBillingsAction( Request $request ) {
		$billing = new Billing();

		$body = json_decode($request->getContent(), true);


		$billing->setFirstName('Alexandre');
		$billing->setLastName('Kone');
		$billing->setPhoneNumber('0608361161');
		$billing->setEmail('admin@mail.com');
		$billing->setPaymentMethod('cart');
		$billing->setTotalPrice(23.58);
		$billing->setBillingAddress('4 residence des oiseaux');
		$billing->setBillingZipcode('91380');
		$billing->setBillingCity('Chilly-Mazarin');
		$billing->setDeliveryMethod('delivery');
		$billing->setPickupHour('12');

		foreach ($body['salades'] as $salade) {
			$saladeElt = $this->getDoctrine()->getRepository(Salade::class)->find($salade);
			$billing->addSalade($saladeElt);
		}

		$billing->addFormule($this->getDoctrine()->getRepository(Formule::class)->find(5));

//		switch ($body['product'])


		$em = $this->getDoctrine()->getManager();
		$em->persist($billing);
		$em->flush();

		return $billing;

//
//		dump($billing);
//		die();

	}
}
