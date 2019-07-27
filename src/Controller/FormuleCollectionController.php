<?php

namespace App\Controller;

use App\Entity\Formule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class FormuleCollectionController extends AbstractController
{
	public function __invoke() {

		$formules = $this->getDoctrine()
		     ->getRepository(Formule::class)
		     ->findAll();

		$json_formules = [];

		foreach ($formules as $formule) {
			$data = [
				'id' =>$formule->getId(),
				'name' => $formule->getName(),
				'description' => $formule->getDescription(),
				'short_description' =>$formule->getShortDescription(),
				'slug' => $formule->getSlug(),
				'has_bagel' => $formule->getHasBagel()
			];
			array_push($json_formules, $data);
		}
//		dump($json_formules);
//		die();
		return $this->json($formules);

//		return new JsonResponse($formule);
	}
}
