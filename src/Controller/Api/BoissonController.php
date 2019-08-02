<?php

namespace App\Controller\Api;

use App\Entity\Boisson;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/boissons")
 * Class BoissonController
 * @package App\Controller\Api
 */
class BoissonController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"boisson:read"})
	 * @Rest\Get("")
	 * @return Boisson[]|\App\Entity\Boisson[]|\App\Entity\Dessert[]|\App\Entity\Panini[]|object[]
	 */
	public function getBoissonsAction(  ) {
		$boissons = $this->getDoctrine()->getRepository(Boisson::class)->findAll();
		return $boissons;
	}

	/**
	 * @Rest\View(serializerGroups={"boisson:read"})
	 * @Rest\Get("/{id}")
	 * @param Request $request
	 *
	 * @return Boisson|object|JsonResponse|null
	 */
	public function getBoissonAction( Request $request ) {
		$boisson = $this->getDoctrine()
		              ->getRepository(Boisson::class)
		              ->find($request->get('id'));
		if (empty($boisson)) {
			return new JsonResponse(['message' => 'Boisson not found'], Response::HTTP_NOT_FOUND);
		}
		return $boisson;
	}
}
