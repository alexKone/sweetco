<?php

namespace App\Controller\Api;

use App\Entity\Bagel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/bagels")
 * Class BagelController
 * @package App\Controller\Api
 */
class BagelController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"bagel:read"})
	 * @Rest\Get("")
	 * @return Bagel[]|\App\Entity\Boisson[]|\App\Entity\Dessert[]|\App\Entity\Panini[]|object[]
	 */
	public function getBagelsAction(  ) {
		$bagels = $this->getDoctrine()->getRepository(Bagel::class)->findAll();
		return $bagels;
	}

	/**
	 * @Rest\View(serializerGroups={"bagel:read"})
	 * @Rest\Get("/{id}")
	 * @param Request $request
	 *
	 * @return Bagel|object|JsonResponse|null
	 */
	public function getBagelAction( Request $request ) {
		$bagel = $this->getDoctrine()
		              ->getRepository(Bagel::class)
		              ->find($request->get('id'));
		if (empty($bagel)) {
			return new JsonResponse(['message' => 'Bagel not found'], Response::HTTP_NOT_FOUND);
		}
		return $bagel;
	}
}
