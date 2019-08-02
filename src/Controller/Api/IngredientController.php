<?php

namespace App\Controller\Api;

use App\Entity\Ingredient;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/ingredients")
 * Class IngredientController
 * @package App\Controller\Api
 */
class IngredientController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"ingredient:read"})
	 * @Rest\Get("")
	 */
	public function getIngredientsAction(  ) {
		$ingredients = $this->getDoctrine()->getRepository(Ingredient::class)->findAll();
		return $ingredients;
	}

	/**
	 * @Rest\View(serializerGroups={"sauce:read"})
	 * @Rest\Get("/{id}")
	 */
	public function getIngredientAction( Request $request ) {
		$ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($request->get('id'));
		if (empty($ingredient)) {
			return new JsonResponse(['message' => 'Ingredient not found'], Response::HTTP_NOT_FOUND);
		}
		return $ingredient;

	}
}
