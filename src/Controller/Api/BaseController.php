<?php

namespace App\Controller\Api;

use App\Entity\Base;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/bases")
 * Class BaseController
 * @package App\Controller\Api
 */
class BaseController extends AbstractFOSRestController
{
	/**
	 * @Rest\View(serializerGroups={"base:read"})
	 * @Rest\Get("")
	 */
	public function getBasesAction(  ) {
		$bases = $this->getDoctrine()->getRepository(Base::class)->findAll();
		return $bases;
	}

	/**
	 * @Rest\View(serializerGroups={"base:read"})
	 * @Rest\Get("/{id}")
	 */
	public function getBaseAction( Request $request ) {
		$base = $this->getDoctrine()->getRepository(Base::class)->find($request->get('id'));
		if (empty($base)) {
			return new JsonResponse(['message' => 'Base not found'], Response::HTTP_NOT_FOUND);
		}
		return $base;

	}
}
