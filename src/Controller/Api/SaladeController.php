<?php

namespace App\Controller\Api;

use App\Entity\Base;
use App\Entity\Ingredient;
use App\Entity\Salade;
use App\Entity\Sauce;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
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
		$salade = new Salade();

		$base = $this->getDoctrine()
		             ->getRepository(Base::class)
		             ->find($request->get('base'));

		$sauce = $this->getDoctrine()
		             ->getRepository(Sauce::class)
		             ->find($request->get('sauce'));

		foreach ( $request->get('ingredients') as $item ) {
			$ingredient = $this->getDoctrine()
			                   ->getRepository(Ingredient::class)
			                   ->find($item);
			$salade->addIngredient($ingredient);
		}

		$salade->setBase($base);
		$salade->setSauce($sauce);

		$em = $this->getDoctrine()->getManager();
		$em->persist($salade);
		$em->flush();

		return $salade;
	}
}
