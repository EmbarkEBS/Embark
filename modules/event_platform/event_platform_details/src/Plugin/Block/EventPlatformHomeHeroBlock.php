<?php

namespace Drupal\event_platform_details\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Routing\RedirectDestinationTrait;
use Drupal\Core\Url;
use Drupal\config_pages\Entity\ConfigPages;

/**
 * Provides an event platform homepage hero block.
 *
 * @Block(
 *   id = "event_platform_home_hero",
 *   admin_label = @Translation("Event Platform Homepage Hero"),
 *   category = @Translation("Event Platform")
 * )
 */
class EventPlatformHomeHeroBlock extends BlockBase implements BlockPluginInterface {
  use RedirectDestinationTrait;

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $details_page = 'event_details';

    // Add link to update info.
    $params = $this->getDestinationArray();
    $configPage = ConfigPages::config($details_page);
    if ($configPage) {
      $url = Url::fromRoute('entity.config_pages.edit_form', ['config_pages' => $details_page], ['query' => $params]);
      $cache_tag = 'config_pages:' . $configPage->id();
    }
    else {
      $url = Url::fromUri('internal:/admin/event-details', ['query' => $params]);
      $cache_tag = 'config_pages_list';
    }
    $build['edit_link'] = [
      '#type' => 'link',
      '#title' => $this->t('Edit Info'),
      '#url' => $url,
      '#options' => [
        'attributes' => ['class' => ['button']],
      ],
      '#access' => $url->access(\Drupal::currentUser()),
      '#cache' => [
        'tags' => [$cache_tag],
      ],
    ];

    if (!$configPage) {
      $build['edit_link']['#title'] = $this->t('Provide Event Info');
      return $build;
    }
    $org_name = $configPage->get('field_event_name')->value ?? NULL;
    $date_start = $configPage->get('field_dates')->value ?? NULL;
    $date_end = $configPage->get('field_dates')->end_value ?? NULL;
    $location = $configPage->get('field_event_location_short')->value ?? NULL;
    $description = $configPage->get('field_hompage_description_text')->value ?? NULL;
    $cta_url = $configPage->get('field_homepage_media_cta')->uri ?? NULL;
    $cta_title = $configPage->get('field_homepage_media_cta')->title ?? NULL;

    $url = $cta_url ? Url::fromUri($cta_url) : NULL;
    $block = [
      '#theme' => 'event_platform_home_hero_block',
      '#attributes' => [
        'class' => ['header_cta'],
        'id' => 'header-cta-block',
      ],
      '#org_name' => $org_name,
      '#date_start' => $date_start,
      '#date_end' => $date_end,
      '#location' => $location,
      '#description' => $description,
      '#cta_url' => $url,
      '#cta_title' => $cta_title,
      '#event_details' => $configPage,
      '#cache' => [
        'tags' => [$cache_tag],
      ],
    ];
    $build['event_platform_home_hero_cta'] = $block;
    return $build;
  }

}
