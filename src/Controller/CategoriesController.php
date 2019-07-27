<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
	/**
	 * @Route("/category/{slug}")
	 */
	public function listProducts( $slug, Request $request ) {
		$category = $this->getDoctrine()
		                 ->getRepository(Category::class)
		                 ->findOneBySlug($slug);
		return $this->render('pages/category/index.html.twig', [
			'category' => $category
		]);
	}

	/**
	 * @Route("/category/{slug}/{id}")
	 */
	public function detailProduct( $slug, $id, Request $request ) {
		$product = $this->getDoctrine()->getRepository(Product::class)->find($id);

		if ($request->getMethod() === 'POST') {
			$session = new Session(new NativeSessionStorage(), new AttributeBag());
			$item = [
				'name' => 'product',
				'id' => $id,
				'qty' => $request->request->get('qty'),
				'price' => $product->getPrice()
			];

			if (!empty($session->get('items'))) {
				$data = $session->get('items');
				array_push($data, $item);
				$session->set('items', $data);
			} else {
				$newArr = [];
				array_push($newArr, $item);
				$session->set('items', $newArr);
			}

			return $this->redirectToRoute('checkout');
		}

		return $this->render('pages/category/details.html.twig', [
			'product' => $product
		]);
	}
}
