<?php

namespace Drupal\rumbletalk_chat\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Provides a 'RumbleTalk Group Chat' Block.
 *
 * @Block(
 *   id = "rumbltalk_block",
 *   admin_label = @Translation("RumbleTalk Group Chat"),
 *   category = @Translation("RumbleTalk"),
 * )
 */
class BlockChatForm extends BlockBase 
{
	/**
   	* {@inheritdoc}
   	*/
 	public function build() 
	{
		$form = \Drupal::formBuilder()->getForm('Drupal\rumbletalk_chat\Form\DisplayChatForm');
		return $form;
	}   
}
