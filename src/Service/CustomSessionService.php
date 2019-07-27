<?php

namespace App\Service;

use App\Entity\Bagel;
use App\Entity\Boisson;
use App\Entity\Dessert;
use App\Entity\Panini;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class CustomSessionService
{
	private $em;
	public function __construct(EntityManagerInterface $em) {
		$this->em = $em;
	}

	public function addToSession( $data, $session_name, $name ) {
		$session = new Session(new NativeSessionStorage());
		$sessionArray = [];
		$result = [];

		if (array_key_exists('salade', $data)) {
			dump('salade', $data);
		}
		if (array_key_exists('bagel', $data)) {
			$bagel = $this->em->getRepository(Bagel::class)->find($data['bagel']);
			$sessionArray['bagel'] = $bagel;
		}
		if (array_key_exists('panini', $data)) {
			$panini = $this->em->getRepository(Panini::class)->find($data['panini']);
			$sessionArray['panini'] = $panini;
		}
		if (array_key_exists('boisson', $data)) {
			$boisson = $this->em->getRepository(Boisson::class)->find($data['boisson']);
			$sessionArray['boisson'] = $boisson;
		}
		if (array_key_exists('dessert', $data)) {
			$dessert = $this->em->getRepository(Dessert::class)->find($data['dessert']);
			$sessionArray['dessert'] = $dessert;
		}

		array_push($result, $sessionArray);

		if ($session->get($session_name) === null) {
			$session->set($session_name, $result);
		} else {
			$items = $session->get($session_name);
//			array_push($items, $result);
//			dump($session->get($session_name));
			dump($result, $items);
			die();
		}

	}

	private function getSession() {
		echo 'hello';
	}

}
