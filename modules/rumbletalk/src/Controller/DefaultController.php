<?php

namespace Drupal\rumbletalk_chat\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\rumbletalk_chat\Form\ChatForm;

class DefaultController extends ControllerBase 
{
	public function display() 
	{
		$chatForm = \Drupal::formBuilder()->getForm('Drupal\rumbletalk_chat\Form\ChatForm');
		
		return $chatForm;
  	}

}
