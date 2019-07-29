<?php

namespace App\Controller;

use App\Entity\Addons;
use App\Entity\Bagel;
use App\Entity\Base;
use App\Entity\Billing;
use App\Entity\Boisson;
use App\Entity\Dessert;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Panini;
use App\Entity\Salade;
use App\Entity\Sauce;
use App\Events;
use App\Service\CustomMailService;
use App\Service\PaymentGateway;
use Dompdf\Dompdf;
use Dompdf\Options;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
	/**
	 * @Route("/checkout", name="checkout")
	 * @param Session $session
	 * @param PaymentGateway $gateway
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index( Session $session, PaymentGateway $gateway ) {
//		dump($session->get('items'), $session->getId(), $session->all());

//		$items = $session->get('items');
//		dump($items);
//		die();

		$total_price = 0;
		\Stripe\Stripe::setApiKey('sk_test_hpOkRt0eanTpgDugo3ikLSGb00oLULJyLi');

		$items = [];

		foreach ( $session->get('items') as $item ) {
			$produit = [
				'name' => $item['title'],
				'amount' => $item['total_price']*100,
				'currency' => 'eur',
				'quantity' => 1,
			];
//			dump($item['name']);
//			$item['name'];
			array_push($items, $produit);
			$total_price += $item['total_price'];
		}

//		dump($items);
//		die();
//		dump($gateway->createStripeSession());
//		die();

		$intent = \Stripe\PaymentIntent::create([
			'amount' => $total_price * 10,
			'currency' => 'eur',
			'payment_method_types' => ['card']
		]);

//		$stripeSession = \Stripe\Checkout\Session::create([
//			'payment_method_types' => ['card'],
//			'line_items' => [$items],
//			'success_url' => 'http://localhost:5000/success',
//			'cancel_url' => 'http://localhost:5000/cancel',
//		]);

		return $this->render('pages/checkout/index.html.twig', [
			'total_price' => $total_price,
			'intent_client_secret' => $intent->client_secret,
			'cart_value' => $intent->amount
		]);
	}

	/**
	 * @Route("/validation", name="app_checkout_validation", methods={"POST"})
	 * @param Request $request
	 *
	 * @param EventDispatcherInterface $dispatcher
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function validateCheckout( Request $request, EventDispatcherInterface $dispatcher ) {
		$session = new Session(new NativeSessionStorage());
		$em = $this->getDoctrine()->getManager();


		$datas = $request->request->all();


//		$event = new GenericEvent($session->get('items'));
//		$dispatcher->dispatch(Events::CUSTOMER_NEW_ORDER, $event);

		$totalPrice = 0;

		$billing = new Billing();
		$billing->setFirstName($request->request->get('first_name'));
		$billing->setLastName($request->request->get('last_name'));
		$billing->setPhoneNumber($request->request->get('tel'));
		$billing->setEmail($request->request->get('email'));
		$billing->setPaymentMethod($request->request->get('payment_method'));

		// if delivery_method livraison
		if ($datas['delivery_method'] === 'livraison') {
			$billing->setBillingAddress($request->request->get('billing_address'));
			$billing->setBillingCity($request->request->get('billing_city'));
			$billing->setBillingZipcode($request->request->get('billing_zipcode'));
		} else {
			$billing->setPickupHour($request->request->get('hour_delivery'));
		}

		foreach ($session->get('items') as $item) {
			$totalPrice += $item['total_price'];
			if ($item['name'] === 'product') {
				switch ($item['title']) {
					case 'bagel':
						$bagel = $this->getDoctrine()->getRepository(Bagel::class)->find($item['bagel']->getId());
						$billing->addBagel($bagel);
						break;
					case 'panini':
						$panini = $this->getDoctrine()->getRepository(Panini::class)->find($item['panini']->getId());
						$billing->addPanini($panini);
						break;
					case 'boisson':
						$boisson = $this->getDoctrine()->getRepository(Boisson::class)->find($item['boisson']->getId());
						$billing->addBoisson($boisson);
						break;
					case 'dessert':
						$dessert = $this->getDoctrine()->getRepository(Dessert::class)->find($item['dessert']->getId());
						$billing->addDessert($dessert);
						break;
				}
			}
			if ($item['name'] === 'formule') {
				$formule = $this->getDoctrine()->getRepository(Formule::class)->find($item['id']);
				$salade = new Salade();
				$addons = new Addons();

				if (array_key_exists('addons', $item)) {
					if (array_key_exists('base', $item['addons'])) {
						$addons->addBasis($this->getDoctrine()->getRepository(Base::class)->find($item['addons']['base']->getId()));
					}
					if (array_key_exists('ingredients', $item['addons'])) {
						foreach ($item['addons']['ingredients'] as $ingredient) {
							$addons->addIngredient($this->getDoctrine()->getRepository(Ingredient::class)->find($ingredient->getId()));
						}
					}
				}

				if (array_key_exists('salade', $item)) {
					$salade->setSauce($this->getDoctrine()->getRepository(Sauce::class)->find($item['salade']->getSauce()->getId()));
					$salade->setBase($this->getDoctrine()->getRepository(Base::class)->find($item['salade']->getBase()->getId()));
//					$salade->setSauce($this->getDoctrine()->getRepository(Sauce::class)->find($item['salade']->getSauce()->getId()));
					foreach ($item['salade']->getIngredients() as $ingredient) {
						$salade->addIngredient($this->getDoctrine()->getRepository(Ingredient::class)->find($ingredient->getId()));
					}
					$salade->setAddons($addons);
				}


				$salade->setFormule($formule);

				$em->persist($salade);
				$em->persist($addons);

				$billing->addFormule($formule);
				$billing->addSalade($salade);

			}
		}
		$billing->setTotalPrice($totalPrice);

		$em->persist($billing);
		$em->flush();

		$session->set('billing', $billing);


		return $this->redirectToRoute('success_payment',[
			'billing' => $billing->getId()
		]);
	}

	/**
	 * @Route("/success", name="success_payment")
	 * @param Request $request
	 * @param EventDispatcherInterface $event_dispatcher
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function success( Request $request, EventDispatcherInterface $event_dispatcher ) {
		$session = new Session(new NativeSessionStorage());

		$event = new GenericEvent(['billing' => $session->get('billing'), 'session' => $session->get('items')]);
		$event_dispatcher->dispatch(Events::CUSTOMER_NEW_ORDER, $event);

		$session->remove('items');

		return $this->render('pages/checkout/success.html.twig', [
			'billing' => $this->getDoctrine()->getRepository(Billing::class)->find($request->query->get('billing'))
		]);
	}

	public function cancel( ) {

	}

}
