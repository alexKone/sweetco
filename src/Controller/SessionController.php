<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
	private $session;

	public function __construct() {
		$this->session = new Session(new NativeSessionStorage());
	}

	/**
	 * @Route("/api/currentSession", name="api_get_currentSession", methods={"GET"})
	 * @return JsonResponse
	 */
	public function getCurrentSession(  ) {
		return new JsonResponse( $this->session->all() );
	}

	/**
	 * @Route("/api/currentSession/{id}", name="api_get_item_session", methods={"GET"})
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function getItemSession( $id ) {
		return new JsonResponse($this->session->get('items')[$id]);
	}

	/**
	 * @Route("/api/currentSession/{id}", name="api_delete_item_session", methods={"DELETE"})
	 * @param $id
	 *
	 * @return mixed
	 */
	public function deleteItem( $id ) {
		$items = $this->session->get('items');
		unset($items[$id]);
		$this->session->set('items', $items);
		return new JsonResponse($items);
	}

	public function addProductInSession( $item ) {

	}
	public function addFormuleInSesion( $item ) {

	}
}
