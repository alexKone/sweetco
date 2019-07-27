<?php

namespace App\Controller;

use App\Entity\Base;
use App\Entity\Ingredient;
use App\Entity\Salade;
use App\Entity\Sauce;
use App\Service\ArrayHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CreateSaladeBase extends AbstractController
{
	public function __invoke(Request $request, Salade $salade) {
		$json = json_decode($request->getContent(), true);
		$em = $this->getDoctrine()->getManager();
		foreach ($json['ingredients'] as $item) {
			$ingredient_arr = explode('/', $item);
			$ingredient = $this->getDoctrine()
			                   ->getRepository(Ingredient::class)
			                   ->find($ingredient_arr[count($ingredient_arr) - 1]);
			$salade->addIngredient($ingredient);
		}
		$base_arr = explode('/', $json['base']);
		$base = $this->getDoctrine()
		             ->getRepository(Base::class)
		             ->find($base_arr[count($base_arr) - 1]);
		$sauce_arr = explode('/', $json['sauce']);
		$sauce = $this->getDoctrine()
		              ->getRepository(Sauce::class)
		              ->find($sauce_arr[count($sauce_arr) - 1]);
		$salade->setBase($base);
		$salade->setSauce($sauce);

		$em->flush();

		return $salade;
	}
//	public function __invoke(Request $request, Salade $data, ArrayHandler $handler){
//		$json = json_decode($request->getContent(), true);
////		$array_baseurl = explode("/", $json['base']);
////		dump($array_baseurl[count($array_baseurl) - 1]);
//
//
//		$em = $this->getDoctrine()->getManager();
//		$em->persist($data);
//
//		$base = $this
//			->getDoctrine()
//			->getRepository(Base::class)
//			->find($handler->getLastIndex($json, 'base'));
//
//		foreach ($json['ingredients'] as $ingredient) {
//			$ingr = $this
//				->getDoctrine()
//				->getRepository(Ingredient::class)
//				->find($handler->getLastIndex($ingredient));
//			dump($ingr);
//		}
//
//		die();
//
//		$data->setBase($base);
//
//		dump($data);
//		die();
//
//
//		$em->flush();
//
////		dump($base);
////		dump(count(explode("/", $json['base'])));
////		$baseUrl = explode("/", $json['base']);
////		dump($json['ingredients'], $base);
////		dump($baseUrl[count($baseUrl) - 1]);
////		dump(count(explode("/", $json['base'])) - 1);
////		die();
////		dump($handler->getLastIndex($json));
//		die();
//		return;
//	}
}
