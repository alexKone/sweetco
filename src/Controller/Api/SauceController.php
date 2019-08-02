<?php

namespace App\Controller\Api;

use App\Entity\Sauce;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/sauces")
 * Class SauceController
 * @package App\Controller\Api
 */
class SauceController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"sauce:read"})
	 * @Rest\Get("")
	 */
	public function getSaucesAction(  ) {
		$sauces = $this->getDoctrine()
		               ->getRepository(Sauce::class)
		               ->findAll();
		return $sauces;
	}

	/**
	 * @Rest\View(serializerGroups={"sauce:read"})
	 * @Rest\Get("/{id}")
	 */
	public function getSauceAction( Request $request ) {
		$sauce = $this->getDoctrine()
		              ->getRepository(Sauce::class)
		              ->find($request->get('id'));
		if (empty($sauce)) {
			return new JsonResponse(['message' => 'Sauce not found'], Response::HTTP_NOT_FOUND);
		}
		return $sauce;

	}
}
