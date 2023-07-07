<?php

namespace Drupal\rumbletalk_chat\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;

use \Drupal\Core\Url;

class ChatForm extends FormBase 
{
	public function buildForm
	(
		array $form, 
		FormStateInterface $form_state
	) {
		$isLogin = \Drupal::currentUser()->isAuthenticated();

		$currentUser = \Drupal::currentUser();
		$roles = $currentUser->getRoles();
		$rolesCounter = count($roles); // 1 = user || 2 = admin

		$database = \Drupal::database();
		$result = $database->select('chat_details', 'c')->fields('c', ['cid']);
		$row = $result->execute()->fetchAll();
		$rowCount = count($row);

		if ($isLogin == TRUE && $rolesCounter >= 2) {
			if
			(
				$form_state->has('page_num') 
				&& $form_state->get('page_num') == 2
			) {
				return self::chatPage($form, $form_state);
			}

			$form_state->set('page_num', 1);

				$form['title_settings'] = [
					'#type' => 'item',
					'#markup' => $this->t('<h1><b>RumbleTalk Group Chat Settings:</b></h1>'),
				];

				$database = \Drupal::database();
				$query = $database->select('chat_details', 'c')
				->condition('c.cid', 1, '=')
				->fields('c', ['cid', 'hashcode', 'height', 'width', 'members',  'forceLogin', 'user']);
		
				$result = $query->execute();
		
				while ($content = $result->fetchAssoc()) {
					$hashcode = $content['hashcode'];
					$prevHeight = $content['height'];
					$prevWidth = $content['width'];
					$prevMembers = $content['members'];
					$forceLogin = $content['forceLogin'];
				}

				$chatLink = 'https://www.rumbletalk.com/client/chat.php?' . $hashcode;

				$form['#attached']['library'][] = 'rumbletalk_chat/rumbletalk_lib';

				// Chat Box: whole container
				$form['chat_box_'] = [
					'#type' => "container",
					'#attributes' => ['style' => 'width: 350px; border: 1px solid #ddd; padding: 10px 25px; margin: 30px;'],
					'hashcode_container' => [ // hashcode_container
						'#type' => "container",
						'#attributes' => ['class' => ['container-inline'], 'style' => 'font-size: 1.2em;'],
						'hashcode' => [
							'#type' => 'textfield',
							'#title' => 'Hashcode',
							'#size' => 12,
							'#default_value' => $hashcode,
							'#required' => TRUE,
							'#wrapper_attributes' => [
								'id' => 'hashcode_container',
								'style' => 'font-size: 0.9em; width: 40%;',
							],
						],

						'open' => [
							'#type' => 'image_button',
							'#value' => $this->t(''),
							'#src' => 'modules/rumbletalk_chat/src/images/open-in-new.svg',
							'#attributes' => ['style' => 'margin-left: 82px;', 'target' => '_blank'],
							'#wrapper_attributes' => [
								'id' => 'hashcode_container',
							],
							'#submit' => ['::chatPage'],
						], 
					], 
					// end hashcode_container 
					'hashcode_desc' => [
						'#type' => 'item',
						'#markup' => $this->t('<p style="font-size: 0.8em; font-style: italic;">* Note: Your chat\'s hascode can be found on your RumbleTalk Administration panel.</p>
						<p style="font-size: 0.8em; font-style: italic;"> It is usually an 8-character code. (Ex. Hash: ********)</p>'),
					],
					'dimension' => [ // dimension
						'#type' => "container",
						'#attributes' => ['class' => ['container-inline'], 'style' => 'font-size: 1.2em;',],
						'height' => [
							'#type' => 'number',
							'#title' => 'Height',
							'#default_value' => $prevHeight,
							'#attributes' => [
								'id' => [
									'dimension',
								],
								'style' => 'width: 100px; font-size: 0.9em;',
							],
						],
						'width' => [
							'#type' => 'number',
							'#title' => 'Width',
							'#default_value' => $prevWidth,
							'#attributes' => [
								'id' => [
									'dimension',
								],
								'style' => 'width: 100px; font-size: 0.9em;',
							],
							'#wrapper_attributes' => [
								'style' => 'margin-left: 1em;',
							],
						],
					], // end dimension
					
					'checkbox_container' => [ // checkbox_container
						'#type' => "container",
						'#attributes' => ['class' => ['container-inline'], 'style' => 'font-size: 1.2em; margin-top: 1em;'],
						'members' => [
							'#type' => 'checkbox',
							'#title' => $this->t('Members Only'),
							'#default_value' => $prevMembers,
							'#wrapper_attributes' => [
								'style' => 'font-size: 1.2em; margin-right: 1em;',
							],
						],
						'forceLogin' => [
							'#type' => 'checkbox',
							'#title' => $this->t('Force Login'),
							'#default_value' => $forceLogin,
							'#wrapper_attributes' => [
								'style' => 'font-size: 1.2em;',
							],
						],
					], // end checkbox_container
		
					'member_desc' => [
						'#type' => 'item',
						'#markup' => $this->t('<p style="font-size: 0.8em; font-style: italic;">* This option is used to only allow members of your Drupal website to login the chat.</p>'),
					],
		
					'forceLogin_container' => [ // forceLogin_container
						'#type' => "container",
						'#attributes' => ['style' => 'font-size: 1.2em;'],
						
					], // end forceLogin_container
					'buttons_single' => [

						'save' => [
							'#type' => 'submit',
							'#value' => $this->t('Save'),
							'#attributes' => [
								'style' => 'font-size: 1em; margin-left: 0.5em; margin-right: 0.5em;',
							],
							'#submit' => ['::submitForm'],
							'#validate' => ['::validateForm'],
						],
						
						'delete' => [
							'#type' => 'submit',
							'#value' => $this->t('Delete'),
							'#attributes' => [
								'style' => 'font-size: 1em; margin-left: 0.5em; margin-right: 0.5em;',
							],
							'#submit' => ['::deleteChat'],
							'#limit_validation_errors' => [],
						],
						
						'admin_panel' => [
							'#title' => t('Admin Panel'),
							'#type' => 'link',
							'#url' => Url::fromUri('https://cp.rumbletalk.com/login'),
							'#attributes' => ['target' => '_blank', 'class'=> 'button js-form-submit form-submit', 'style' => 'position: absolute; margin-left: 5em;'],
						],
					],
				];

		} else {
			$form['restricted_container'] = [
				'#type' => "container",
				'#attributes' => ['class' => ['container-inline']],
				'restricted_area' => [
					'#type' => 'item',
					'#markup' => $this->t('
						<h1>RumbleTalk Group Chat: </h1>
						The RumbleTalk Group Chat Settings is accessed by Admins only.
					'),
				],
			];
		}
		return $form;
    	}

    	public function getFormId() 
    	{
        	return 'rumbletalk_chat_form';
    	}

    	public function validateForm
    	(
		array &$form, 
		FormStateInterface $form_state
	) {
        	$hashcode = $form_state->getValue('hashcode');
        	if (strlen($hashcode) < 8) {
          		$form_state->setErrorByName('hashcode', $this->t('The hashcode must be exactly 8 characters long.'));
        	} else if(strlen($hashcode) > 8) {
          		$form_state->setErrorByName('hashcode', $this->t('The hashcode must not exceed 8 characters long.'));
		}
	}

	public function submitForm
	(
		array &$form, 
		FormStateInterface $form_state
	) {
      		$hashcode = $form_state->getValue('hashcode');

      		$account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
      		$user = $account->get('name')->value;

      		// Sets the default height to 500 px.
      		if($form_state->getValue('height') <= 99) {
        		$height = 500;
      		} else {
        		$height = $form_state->getValue('height');
      		}

      		// Sets the default width to 750 px.
      		if($form_state->getValue('width') <= 99) {
        		$width = 750;
      		} else {
        		$width = $form_state->getValue('width');
      		}

      		$form_state
        		->set('chat_values', 
				[
          			'hashcode' => $form_state->getValue('hashcode'),
          			'height' => $height,
          			'width' => $width,
          			'members' => $form_state->getValue('members'),
					'forceLogin' => $form_state->getValue('forceLogin')
        		]
			);

      		$conn = Database::getConnection();
      		$conn->update('chat_details')->fields(
				array(
					'hashcode' => $form_state->getValue('hashcode'),
					'height' => $height,
					'width' => $width,
					'members' => $form_state->getValue('members'),
					'forceLogin' => $form_state->getValue('forceLogin'),
					'user' => $user
				)
      		)
      		->condition('cid', 1, '=')
      		->execute();

      		$this->messenger()->addMessage($this->t('Your chat with a hashcode of %hashcode has been saved.', ['%hashcode' => $hashcode]));
		
	}

	public function chatPage
	(
		array &$form, 
		FormStateInterface $form_state
	) {	
		$database = \Drupal::database();
		$query = $database->select('chat_details', 'c')
		->condition('c.cid', 1, '=')
		->fields('c', ['cid', 'hashcode', 'height', 'width', 'members', 'forceLogin', 'user']);

		$result = $query->execute();

		while ($content = $result->fetchAssoc()) {
			$hashcode = $content['hashcode'];
			$hashcode = $content['prev_hashcode'];
			$prevHeight = $content['height'];
			$prevWidth = $content['width'];
			$prevMembers = $content['members'];
		}
		if ($hashcode != null) {
			$form_state
			->set('chat_values', [
				'hashcode' => $hashcode,
				'height' => $prevHeight,
				'width' => $prevWidth,
				'members' => $prevMembers,
			])
			->set('page_num', 2)
			->setRebuild(TRUE);

			// Checks the Members Only
			if ($prevMembers == 1) {
				$account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
				$user = $account->get('name')->value;
				$picture = $account->get('user_picture')->entity->getFileUri();
				
				$form['members_script'] = [
					'#type' => 'item',
					'#title' => $this->t("<script>
					(function(g, v, w, d, s, a, b) {
					w['rumbleTalkMessageQueueName'] = g;
					w[g] = w[g] ||
					function() {
					(w[g].q = w[g].q || []).push(arguments)
					};
					a = d.createElement(s);
					b = d.getElementsByTagName(s)[0];
					a.async = 1;
					a.src = 'https://d1pfint8izqszg.cloudfront.net/api/' + v + '/sdk.js';
					b.parentNode.insertBefore(a, b);
					})('rtmq', 'v1.0.0', window, document, 'script'); 
				</script>" . "<script>rtmq('login',{hash: '". $hashcode . "', username: '". $user. "', image: '" . file_create_url($picture) . "', forceLogin: 'true'})</script>"
					),
				];
			} 

			$form['chat_area'] = [
			'#type' => 'item',
			'#title' => $this->t('<div style="height: ' . $prevHeight . 'px; width: ' . $prevWidth . 'px;"><div id="rt-'. md5($hashcode) . '"></div> <script src="https://rumbletalk.com/client/?' . $hashcode . '"></script></div>'),
			];

	 	} else {
            		$form['chat_area'] = [
				'#type' => 'item',
				'#title' => $this->t('<p>There is no chat available.</p>'),
            		];
        	}

		$form['actions']['submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Edit Chat Settings'),
			'#submit' => ['::backToForm'],
			'#limit_validation_errors' => [], 
		];

		return $form;
	}

	public function backToForm
	(
		array &$form,
		FormStateInterface $form_state
	) {	
		$account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
		$user = $account->get('name')->value;

		$conn = Database::getConnection();
		$conn->update('chat_details')->fields(
			array(
				'user' => $user,
			)
		)
		->condition('cid', 1, '=')
		->execute();

		$form_state
		->setValues($form_state->get('chat_values'))
		->set('page_num', 1)
		->setRebuild(TRUE);
	}

	public function addChat
	(
		array &$form,
		FormStateInterface $form_state
	) {
		$values = [
			[
				'hashcode' => '',
				'height' => 0,
				'width' => 0,
				'members' => 0,
				'forceLogin' => 0,
				'user' => '',
			],
		];
		
		$database = \Drupal::database();
		$query = $database->insert('chat_details')->fields(['hashcode', 'height', 'width', 'members', 'forceLogin', 'user']);
		foreach ($values as $details) {
			$query->values($details);
		}
		$query->execute();
	}

	public function reloadChat(array $form, FormStateInterface $form_state) {
		$response = new AjaxResponse();
		$currentURL = Url::fromRoute('<current>');
		$response->addCommand(new RedirectCommand($currentURL->toString()));
		return $response;
	}
	
	public function deleteChat
	(
		array &$form,
		FormStateInterface $form_state
	) {	
		$account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
		$user = $account->get('name')->value;

		$conn = Database::getConnection();
		$conn->update('chat_details')->fields(
			array(
				'hashcode' => '',
				'height' => 0,
				'width' => 0,
				'members' => 0,
				'forceLogin' => 0,
				'user' => $user,
			)
		)
		->condition('cid', 1, '=')
		->execute();

	}
}
