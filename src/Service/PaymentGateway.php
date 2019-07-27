<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class PaymentGateway
{
	private $currency = "eur";

	public function createStripeSession(  ) {
		$session = new Session(new NativeSessionStorage());
		$session->get('items');
		$line_items = [];
		foreach ($session->get('items') as $item) {
			$product = [
				'name' => $item['title'],
				'amount' => $item['price']*10,
				'quantity' => 1,
				'currency' => $this->currency
			];
			array_push($line_items, $product);
		}

//		return $line_items;
		\Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");
		return \Stripe\Checkout\Session::create([
			"success_url" => "https://example.com/success",
			"cancel_url" => "https://example.com/cancel",
			"payment_method_types" => ["card"],
			"line_items" => $line_items,
			"locale" => "fr"
		]);
	}
}
