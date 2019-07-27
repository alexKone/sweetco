<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
	/**
	 * @Route("/order", name="order" )
	 */
	public function index( Request $request ) {
		dump($request);
		die();
	}
}
