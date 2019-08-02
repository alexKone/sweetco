<?php

namespace App\Controller\Api;

use App\Entity\Formule;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/formules")
 * Class FormuleController
 * @package App\Controller\Api
 */
class FormuleController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"formule:read"})
	 * @Rest\Get("")
	 */
	public function getFormulesAction(  ) {
		$formules = $this->getDoctrine()
		               ->getRepository(Formule::class)
		               ->findAll();
		return $formules;
	}

	/**
	 * @Rest\View(serializerGroups={"formule:read"})
	 * @Rest\Get("/{id}")
	 */
	public function getFormuleAction( Request $request ) {
		$formule = $this->getDoctrine()
		              ->getRepository(Formule::class)
		              ->find($request->get('id'));
		if (empty($formule)) {
			return new JsonResponse(['message' => 'Formule not found'], Response::HTTP_NOT_FOUND);
		}
		return $formule;

	}
}
