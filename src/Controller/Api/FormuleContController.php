<?php

namespace App\Controller\Api;

use App\Entity\Bagel;
use App\Entity\Base;
use App\Entity\Boisson;
use App\Entity\Bread;
use App\Entity\Dessert;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Panini;
use App\Entity\Salade;
use App\Entity\Sauce;
use App\Entity\Supplement;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FormuleContainer;

/**
 * @Rest\Prefix("/formule_container")
 */
class FormuleContController extends AbstractFOSRestController {
	/**
	 * @Rest\View(serializerGroups={"formule.container:post"})
	 * @Rest\Post("")
	 */
	public function postFormuleContainerAction( Request $request ) {
		$body = json_decode( $request->getContent(), true );

		$formuleContainer = new FormuleContainer();
		$supplement       = new Supplement();

		if ( array_key_exists( 'salade', $body ) && ! empty( $body['salade'] ) ) {
			if (array_key_exists('base', $body['salade']) && !empty($body['salade']['base'])) {
				$salade = new Salade();
				$salade->setBase( $this->getDoctrine()->getRepository( Base::class )->find( $body['salade']['base'] ) );
				$salade->setSauce( $this->getDoctrine()->getRepository( Sauce::class )->find( $body['salade']['sauce'] ) );

				foreach ( $body['salade']['ingredients'] as $ingredient ) {
					$salade->addIngredient( $this->getDoctrine()->getRepository( Ingredient::class )->find( $ingredient ) );
				}
			}
		}

		if ( array_key_exists( 'bagel', $body ) && ! empty( $body['bagel'] ) ) {
			$bagel = $this->getDoctrine()->getRepository( Bagel::class )->find( $body['bagel'] );
			$formuleContainer->setBagel( $bagel );
		}
		if ( array_key_exists( 'panini', $body ) && ! empty( $body['panini'] ) ) {
			$panini = $this->getDoctrine()->getRepository( Panini::class )->find( $body['panini'] );
			$formuleContainer->setPanini( $panini );
		}
		if ( array_key_exists( 'desserts', $body ) && ! empty( $body['desserts'] ) ) {
			foreach ( $body['desserts'] as $dessert ) {
				$formuleContainer->addDessert( $this->getDoctrine()->getRepository( Dessert::class )->find( $dessert ) );
			}
//			$panini = $this->getDoctrine()->getRepository(Panini::class)->find($body['panini']);
//			$formuleContainer->setPanini($panini);
		}

		if ( array_key_exists( 'supplement_base', $body ) && ! empty( $body['supplement_base'] ) ) {
			foreach ( $body['supplement_base'] as $item ) {
				$supplement->addBasis( $this->getDoctrine()->getRepository( Base::class )->find( $item ) );
			}
		}


		if ( array_key_exists( 'supplement_ingredient', $body ) && ! empty( $body['supplement_ingredient'] ) ) {
			foreach ( $body['supplement_ingredient'] as $item ) {
				$supplement->addIngredient( $this->getDoctrine()->getRepository( Ingredient::class )->find( $item ) );
			}
		}

		if ( array_key_exists( 'supplement_pain', $body ) && ! empty( $body['supplement_pain'] ) ) {
			foreach ( $body['supplement_pain'] as $item ) {
				$supplement->addBread( $this->getDoctrine()->getRepository( Bread::class )->find( $item ) );
			}
		}

		if ( array_key_exists( 'boisson', $body ) && ! empty( $body['boisson'] ) ) {
			$boisson = $this->getDoctrine()
			                ->getRepository( Boisson::class )
			                ->find( $body['boisson'] );

		}
		if ( array_key_exists( 'formule', $body ) && ! empty( $body['formule'] ) ) {
			$formule = $this->getDoctrine()
			                ->getRepository( Formule::class )
			                ->find( $body['formule'] );
		}

		$formuleContainer->setFormule( $formule );
		if (!empty($salade)) {
			$formuleContainer->setSalade( $salade );
		}
		if (!empty($boisson)) {
			$formuleContainer->setBoisson( $boisson );
		}
		if ( ! empty( $supplement ) ) {
			$formuleContainer->setSupplement( $supplement );
		}

		$formuleContainer->setPrice($body['total_price']);
		$em = $this->getDoctrine()->getManager();
		$em->persist( $formuleContainer );
		$em->flush();

		return $formuleContainer;
	}
}
