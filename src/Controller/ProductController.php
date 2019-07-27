<?php

namespace App\Controller;

use App\Entity\Bagel;
use App\Entity\Boisson;
use App\Entity\Dessert;
use App\Entity\Panini;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
	/**
	 * @Route("/bagel/{slug}", name="app_bagel_detail")
	 * @param $slug
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getBagel( $slug ) {
		$bagel = $this->getDoctrine()->getRepository(Bagel::class)->findOneBy(['slug' => $slug]);
		return $this->render('pages/products/bagel.html.twig', [
			'bagel' => $bagel
		]);
	}

	/**
	 * @Route("/panini/{slug}", name="app_panini_detail")
	 * @param $slug
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getPanini( $slug ) {
		$panini = $this->getDoctrine()->getRepository(Panini::class)->findOneBy(['slug' => $slug]);
		return $this->render('pages/products/panini.html.twig', [
			'panini' => $panini
		]);
	}

	/**
	 * @Route("/panini/{slug}", name="app_boisson_detail")
	 * @param $slug
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getBoisson( $slug ) {
		$boisson = $this->getDoctrine()->getRepository(Boisson::class)->findOneBy(['slug' => $slug]);
		return $this->render('pages/products/boisson.html.twig', [
			'boisson' => $boisson
		]);
	}

	/**
	 * @Route("/panini/{slug}", name="app_dessert_detail")
	 * @param $slug
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getDessert( $slug ) {
		$dessert = $this->getDoctrine()->getRepository(Dessert::class)->findOneBy(['slug' => $slug]);
		return $this->render('pages/products/dessert.html.twig', [
			'dessert' => $dessert
		]);
	}

	/**
	 * @Route("/add-to-cart", name="app_add_to_cart")
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function addToCart( \Symfony\Component\HttpFoundation\Request $request ) {
		$session = new Session(new NativeSessionStorage());
		$items = null;
		if ($session->get('items') === null) {
			$items = [];
		} else {
			$items = $session->get('items');
		}
		$query = $request->query->all();
		$q = array_keys($query)[0];
		$product = [];
		switch ($q) {
			case 'bagel':
				$bagel = $this->getDoctrine()
				     ->getRepository(Bagel::class)
				     ->find($request->query->get('bagel'));
				$product['bagel'] = $bagel;
				$product['product_name'] = 'Bagel (' . $bagel->getName() . ')';
				$product['title'] = 'bagel';
				$product['total_price'] = $bagel->getPrice();
				$product['price'] = $bagel->getPrice();
				break;
			case 'panini':
				$panini = $this->getDoctrine()
				     ->getRepository(Panini::class)
				     ->find($request->query->get('panini'));
				$product['panini'] = $panini;
				$product['product_name'] = 'Panini (' . $panini->getName() . ')';
				$product['title'] = 'panini';
				$product['total_price'] = $panini->getPrice();
				$product['price'] = $panini->getPrice();
				break;
			case 'boisson':
				$boisson = $this->getDoctrine()
				     ->getRepository(Boisson::class)
				     ->find($request->query->get('boisson'));
				$product['boisson'] = $boisson;
				$product['product_name'] = 'Boisson (' . $boisson->getName() . ')';
				$product['title'] = 'boisson';
				$product['total_price'] = $boisson->getPrice();
				$product['price'] = $boisson->getPrice();
				break;
			case 'dessert':
				$dessert = $this->getDoctrine()
				     ->getRepository(Dessert::class)
				     ->find($request->query->get('dessert'));
				$product['dessert'] = $dessert;
				$product['product_name'] = 'Dessert (' . $dessert->getName() . ')';
				$product['title'] = 'dessert';
				$product['total_price'] = $dessert->getPrice();
				$product['price'] = $dessert->getPrice();
				break;
		}

		$item = array_merge(['name' => 'product'], $product);

		array_push($items, $item);

		$session->set('items', $items);

		return $this->redirectToRoute('cart');
	}
}
