<?php

namespace App\Controller\Api;

use App\Entity\Bagel;
use App\Entity\Base;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Salade;
use App\Entity\Sauce;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Prefix("/salades")
 */
class SaladeController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"salade:post"})
	 * @Rest\Post("")
	 */
	public function postSaladesAction( Request $request ) {
		$body = json_decode($request->getContent(), true);
		$formule = $this->getDoctrine()
		                ->getRepository(Formule::class)
		                ->find($body['formule']);

		$salade = new Salade();

		$base = $this->getDoctrine()
		             ->getRepository(Base::class)
		             ->find($body['salade']['base']);
		$sauce = $this->getDoctrine()
		              ->getRepository(Sauce::class)
		              ->find($body['salade']['sauce']);

		foreach ( $body['salade']['ingredients'] as $item ) {
			$ingredient = $this->getDoctrine()
			                   ->getRepository(Ingredient::class)
			                   ->find($item);
			$salade->addIngredient($ingredient);
		}

		$salade->setBase($base);
		$salade->setSauce($sauce);
		$salade->setFormule($formule);
//
		$em = $this->getDoctrine()->getManager();
		$em->persist($salade);
		$em->flush();

		return $salade;
//		return new JsonResponse(['message' => $body['formule']]);

	}
}
