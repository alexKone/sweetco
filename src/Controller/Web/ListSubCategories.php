<?php

namespace App\Controller\Web;

use App\Entity\SubCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ListSubCategories extends AbstractController
{
	public function __invoke( SubCategory $data ) {
		dump($data);
		die();
//		return $data;
	}
}
