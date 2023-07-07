<?php

namespace Drupal\rumbletalk_chat\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

use \Drupal\Core\Url;
use Drupal\Core\Link;

class DisplayChatForm extends FormBase 
{
	public function getFormId() 
	{
        return 'rumbletalk_display_form';
    }

    	public function buildForm(
		array $form, 
		FormStateInterface $form_state
	) {
		$currentUser = \Drupal::currentUser();
		$roles = $currentUser->getRoles();
		$rolesCounter = count($roles); // 1 = user || 2 = admin

		$host = Url::fromUri('internal:/')->setAbsolute()->toString();
		$host = $host . 'rumbletalkChat';

		$database = \Drupal::database();
		$query = $database->select('chat_details', 'c')
		->condition('c.cid', 1, '=')
		->fields('c', ['cid', 'hashcode', 'height', 'width', 'members', 'forceLogin', 'user']);

		$result = $query->execute();

		while ($content = $result->fetchAssoc()) {
			$hashcode = $content['hashcode'];
			$prevHeight = $content['height'];
			$prevWidth = $content['width'];
			$prevMembers = $content['members'];
			$forceLogin = $content['forceLogin'];
		}

		$isLogin = \Drupal::currentUser()->isAuthenticated();
		$isNonLogin = \Drupal::currentUser()->isAnonymous();

		if ($isLogin) {
			if ($hashcode != null) {
				$form_state
				->set('chat_values', [
					'hashcode' => $hashcode,
					'height' => $prevHeight,
					'width' => $prevWidth,
					'members' => $prevMembers,
					'forceLogin' => $forceLogin
				]);

				// Convert int to boolean for forceLogin
				if ($forceLogin == 0) {
					$forceLogin = 'false';
				} else {
					$forceLogin = 'true';
				}

				// Checks the Members Only
				if ($prevMembers == 1) {

					$account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
					$user = $account->get('name')->value;
					$pictureUri = $account->get('user_picture')->entity
						? $account->get('user_picture')->entity->getFileUri()
						: '';
					$pictureUrl = file_create_url($pictureUri);
				
					if ($pictureUri != '') {
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
								</script>" . 
								"<script>
									rtmq('login',
									{
										hash: '$hashcode', 
										username: '$user', 
										forceLogin: $forceLogin,
										image: '$pictureUrl'
									});
								</script>"
							),
						];
					} else {
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
								</script>" . 
								"<script>
									rtmq('login',
									{
										hash: '$hashcode', 
										username: '$user', 
										forceLogin: $forceLogin
									});
								</script>"
							),
						];
					}
				}

				$form['chat_area'] = [
					'#type' => 'item',
					'#title' => $this->t('<div style="height: ' . $prevHeight . 'px; width: ' . $prevWidth . 'px;"><div id="rt-'. md5($hashcode) . '"></div> <script src="https://rumbletalk.com/client/?' . $hashcode . '"></script></div>'),
				];

				if ($rolesCounter >= 2) {
					$form['chat_settings'] = [
						'#title' => t('Edit Chat Settings'),
							'#type' => 'link',
							'#url' => Url::fromUri($host),
							'#attributes' => ['target' => '_blank', 'class'=> 'button js-form-submit form-submit'],
					];
				}

			} else {

				if ($rolesCounter >= 2) { // For Admin use
					$form['intro_container'] = [
						'#type' => "container",
						'#attributes' => ['class' => ['container-inline']],
						'intro1' => [
							'#type' => 'item',
							'#markup' => $this->t('
								<h1>RumbleTalk Group Chat: </h1>
								No chat is added yet. <br/>
								<br/>
								If you are the admin, go to 
							'),
						],
						'settings_link' => [
							'#title' => t('settings'),
							'#type' => 'link',
							'#url' => Url::fromUri($host),
							'#attributes' => ['target' => '_blank', 'class'=> 'link'],
						],
						'intro2' => [
							'#type' => 'item',
							'#markup' => $this->t('
								<br/>
								to add your RumbleTalk Group chat.
							'),
						],
					];
				} else if ($rolesCounter == 1) {
					$form['chat_area'] = [
						'#type' => 'item',
						'#markup' => $this->t('
							<h1>RumbleTalk Group Chat: </h1>
							No chat is added yet. <br/>
							<br/>
							If you are the admin, go to settings<br/>
							to add your RumbleTalk Group Chat.
						'),
					];
				}

			}
		} else if ($isNonLogin == TRUE) {
        		$form['intro_container'] = [
				'#type' => "container",
				'#attributes' => ['class' => ['container-inline']],
				'intro1' => [
					'#type' => 'item',
					'#markup' => $this->t('
						<h1>RumbleTalk Group Chat: </h1>
						No chat is added yet. <br/>
						<br/>
						If you are the admin, go to settings<br/>
						to add your RumbleTalk Group Chat.
					'),
          			],
        		];
      		}
        	return $form;
    	}

	public function submitForm(
		array &$form, FormStateInterface $form_state
	) {
		// Nothing Here...
	}

}
