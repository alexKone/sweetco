<?php

namespace App\Controller\Api;

use App\Entity\Dessert;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/desserts")
 * Class DessertController
 * @package App\Controller\Api
 */
class DessertController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"dessert:read"})
	 * @Rest\Get("")
	 */
	public function getDessertsAction(  ) {
		$desserts = $this->getDoctrine()->getRepository(Dessert::class)->findAll();
		return $desserts;
	}

	/**
	 * @Rest\View(serializerGroups={"dessert:read"})
	 * @Rest\Get("/{id}")
	 * @param Request $request
	 *
	 * @return Dessert|object|JsonResponse|null
	 */
	public function getDessertAction( Request $request ) {
		$dessert = $this->getDoctrine()
		              ->getRepository(Dessert::class)
		              ->find($request->get('id'));
		if (empty($dessert)) {
			return new JsonResponse(['message' => 'Dessert not found'], Response::HTTP_NOT_FOUND);
		}
		return $dessert;
	}
}
