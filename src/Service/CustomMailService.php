<?php

namespace App\Service;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Templating\EngineInterface;

class CustomMailService
{
	private $mailer;
	private $template;

	public function __construct( \Swift_Mailer $mailer, EngineInterface $template ) {
		$this->mailer = $mailer;
		$this->template = $template;
	}

	public function sendMail( $name) {
		$message = (new \Swift_Message('Hello Email'))
			->setFrom('send@example.com')
			->setTo('recipient@exemple.com')
			->setBody(
				$this->template->render('emails/registration.html.twig',[
					'name' => $name
				]), 'text/html', 'utf-8'
			);
		$this->mailer->send($message);
		return new RedirectResponse('/');
	}

}
