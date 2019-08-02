<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Stripe\Error\Card;
use Symfony\Component\HttpFoundation\Request;

class ChargeController extends AbstractFOSRestController
{
	/**
	 * @Rest\View()
	 * @Rest\Post("/charge")
	 */
	public function postChargesAction( Request $request ) {
		\Stripe\Stripe::setApiKey('sk_test_hpOkRt0eanTpgDugo3ikLSGb00oLULJyLi');
		try {
			// Token is created using Checkout or Elements!
			// Get the payment token ID submitted by the form:
			$charge = \Stripe\Charge::create([
				"amount" => 2000,
				"currency" => "eur",
				"source" => $request->get("token_id"), // obtained with Stripe.js
				"description" => "Charge for jenny.rosen@example.com",
//				"customer" => $customer->id
			]);
			return $charge;

		} catch (Card $exception) {
			return $exception;
		}
	}
}
