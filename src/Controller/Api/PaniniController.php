<?php

namespace App\Controller\Api;

use App\Entity\Panini;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/paninis")
 * Class PaniniController
 * @package App\Controller\Api
 */
class PaniniController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"panini:read"})
	 * @Rest\Get("")
	 */
	public function getPaninisAction(  ) {
		$paninis = $this->getDoctrine()->getRepository(Panini::class)->findAll();
		return $paninis;
	}

	/**
	 * @Rest\View(serializerGroups={"panini:read"})
	 * @Rest\Get("/{id}")
	 * @param Request $request
	 *
	 * @return Panini|object|JsonResponse|null
	 */
	public function getPaniniAction( Request $request ) {
		$panini = $this->getDoctrine()->getRepository(Panini::class)->find($request->get('id'));
		if (empty($panini)) {
			return new JsonResponse(['message' => 'Panini not found'], Response::HTTP_NOT_FOUND);
		}
		return $panini;
	}
}
