<?php

namespace App\Controller;

use App\Entity\Bagel;
use App\Entity\Base;
use App\Entity\Boisson;
use App\Entity\Category;
use App\Entity\Dessert;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Panini;
use App\Entity\Salade;
use App\Entity\Sauce;
use App\Entity\SubCategory;
use App\Service\CustomSessionService;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class FormulesController extends AbstractController {
	/**
	 * @Route("/formules/{id}", methods={"get"})
	 * @param Request $request
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function details( Request $request, $id ) {

		$formule     = $this->getDoctrine()
		                    ->getRepository( Formule::class )
		                    ->find( $id );
		$bases       = $this->getDoctrine()
		                    ->getRepository( Base::class )
		                    ->findAll();
		$ingredients = $this->getDoctrine()
		                    ->getRepository( Ingredient::class )
		                    ->findAll();
		$sauces      = $this->getDoctrine()
		                    ->getRepository( Sauce::class )
		                    ->findAll();

		return $this->render( 'pages/formules/details.html.twig', [
			'formule'     => $formule,
			'bases'       => $bases,
			'ingredients' => $ingredients,
			'sauces'      => $sauces,
			'bagels'      => $this->getDoctrine()->getRepository( Bagel::class )->findAll(),
			'paninis'     => $this->getDoctrine()->getRepository( Panini::class )->findAll(),
			'subCategory' => $this->getDoctrine()->getRepository( SubCategory::class )->findAll(),
			'boissons'    => $this->getDoctrine()->getRepository( Boisson::class )->findAll(),
			'desserts'    => $this->getDoctrine()->getRepository( Dessert::class )->findAll(),
		] );
	}


	/**
	 * @Route("/formules/{id}", methods={"post"})
	 * @param Request $request
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function addFormule( Request $request, $id, CustomSessionService $custom_session_service ) {
		$data         = $request->request->all();
		$formule      = $this->getDoctrine()->getRepository( Formule::class )->find( $id );
		$sessionArray = [
			'name'        => 'formule',
			'id'          => $formule->getId(),
			'title'       => $formule->getName(),
			'total_price' => $formule->getPrice(),
			'price'       => $formule->getPrice(),
			'quantity'    => intval( $data['quantity'] )
		];

		$datas = [];


		/**
		 * SALADE
		 */

		if ( array_key_exists( 'base', $data ) ) {

			$pattern  = '#^ingredient_[0-9]+$#i';
			$pattern2 = '#^opt_ingredient_[0-9]+$#i';


			$keys                 = array_keys( $data );
			$ingredientKeys       = [];
			$addonsIngredientKeys = [];
//		$base                 = $data['base'];
//		$sauce                = $data['sauce'];
			$ingredients       = [];
			$addonsBase        = null;
			$addonsIngredients = [];

			foreach ( $keys as $key ) {
				if ( preg_match( $pattern, $key ) ) {
					array_push( $ingredientKeys, $key );
				}
				if ( preg_match( $pattern2, $key ) ) {
					array_push( $addonsIngredientKeys, $key );
				}
			}

			if ( ! empty( $addonsIngredientKeys ) ) {
				foreach ( $addonsIngredientKeys as $addons_ingredient_key ) {
					array_push( $addonsIngredients, $this->getDoctrine()->getRepository( Ingredient::class )->find( $data[ $addons_ingredient_key ] ) );
				}
			}

			foreach ( $ingredientKeys as $ingredient_key ) {
				array_push( $ingredients, $data[ $ingredient_key ] );
			}
			$session = new Session( new NativeSessionStorage(), new AttributeBag() );
			$formule = $this->getDoctrine()->getRepository( Formule::class )->find( $id );

			$newSalade = new Salade();
			$newSalade->setBase( $this->getDoctrine()->getRepository( Base::class )->find( $data['base'] ) );
			$newSalade->setSauce( $this->getDoctrine()->getRepository( Sauce::class )->find( $data['sauce'] ) );

			$sessionArray['salade'] = $newSalade;
			$sessionArray['addons'] = [];


			if ( ! empty( $addonsIngredients ) ) {
				$sessionArray['addons']      += [ 'ingredients' => $addonsIngredients ];
				$sessionArray['total_price'] += 1.3;
			}


			foreach ( $ingredients as $ingredient ) {
				$newSalade->addIngredient( $this->getDoctrine()->getRepository( Ingredient::class )->find( $ingredient ) );
			}

			if ( $request->request->get( 'opt_base' ) ) {
				$optBase                     = $this->getDoctrine()->getRepository( Base::class )->find( $data['opt_base'] );
				$sessionArray['addons']      += [ 'base' => $optBase ];
				$sessionArray['total_price'] += 2.3;
			}

		}


//			$item['total_price'] = $item['price'] + $item['addons']['price'];
//
//			if (!empty($session->get('items'))) {
//				$data = $session->get('items');
//				array_push($data, $item);
//				$session->set('items', $data);
//			} else {
//				$newArr = [];
//				array_push($newArr, $item);
//				$session->set('items', $newArr);
//			}
//
//			return $this->redirectToRoute('checkout');
//		}


//		$custom_session_service->addToSession($data, 'items');


		if ( array_key_exists( 'bagel', $data ) ) {
			$bagel                 = $this->getDoctrine()->getRepository( Bagel::class )->find( $data['bagel'] );
			$sessionArray['bagel'] = $bagel;
		}
		if ( array_key_exists( 'panini', $data ) ) {
			$panini                 = $this->getDoctrine()->getRepository( Panini::class )->find( $data['panini'] );
			$sessionArray['panini'] = $panini;
		}
		if ( array_key_exists( 'boisson', $data ) ) {
			$boisson                 = $this->getDoctrine()->getRepository( Boisson::class )->find( $data['boisson'] );
			$sessionArray['boisson'] = $boisson;
		}
		if ( array_key_exists( 'dessert', $data ) ) {
			$dessert                 = $this->getDoctrine()->getRepository( Dessert::class )->find( $data['dessert'] );
			$sessionArray['dessert'] = $dessert;
		}


		$session = new Session( new NativeSessionStorage() );

		array_push( $datas, $sessionArray );

		if ( $session->get( 'items' ) === null ) {
			$session->set( 'items', $datas );
		} else {
			$result = $session->get( 'items' );
			array_push( $result, $sessionArray );
			$session->set( 'items', $result );
		}

		return $this->redirectToRoute( 'cart' );


	}
}
