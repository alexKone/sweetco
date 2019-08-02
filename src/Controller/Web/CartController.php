<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

	/**
	 * @Route("/cart", name="cart")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index( Request $request ) {
		$session = new Session(new NativeSessionStorage(), new AttributeBag());
		$total = 0;

		if ($request->query->get('method') === 'delete') {
			$session = new Session(new NativeSessionStorage());
			$items = $session->get('items');
			array_splice($items, $request->query->get('id'), 1);
//			dump($items, $request->query->get('id'));
//			die();
			$session->set('items', $items);
			return $this->redirectToRoute('cart');
//			dump($session->get('items')[$request->query->get('id')], $items);
//			die();

		}

		if (!empty($session->get('items')) || $session->get('items') !== null) {

			foreach ( $session->get('items') as $item ) {
				$total += $item['total_price'];
			}
//			dump($session->get('items'));
//			die();
		}
		return $this->render('pages/cart/index.html.twig', [
			'total_price' => $total
		]);
	}
}
