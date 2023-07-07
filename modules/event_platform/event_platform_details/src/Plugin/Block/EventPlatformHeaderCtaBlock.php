<?php

namespace Drupal\event_platform_details\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Url;
use Drupal\config_pages\Entity\ConfigPages;

/**
 * Provides an event platform header cta block.
 *
 * @Block(
 *   id = "event_platform_header_cta",
 *   admin_label = @Translation("Event Platform Header CTA"),
 *   category = @Translation("Event Platform")
 * )
 */
class EventPlatformHeaderCtaBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $configPage = ConfigPages::config('event_details');
    if ($configPage) {
      $cta_url = $configPage->get('field_header_cta')->uri ?? NULL;
      $cta_title = $configPage->get('field_header_cta')->title ?? NULL;
    }
    if (!$configPage || !$cta_url || !$cta_title) {
      return ['event_platform_header_cta' => [
        '#cache' => [
          'tags' => ['config_pages_list'],
        ],
      ]];
    }

    $url = Url::fromUri($cta_url);
    $block = [
      '#theme' => 'event_platform_header_cta_block',
      '#attributes' => [
        'class' => ['header_cta'],
        'id' => 'header-cta-block',
      ],
      '#url'  => $url,
      '#title'  => $cta_title,
      '#cache' => [
        'tags' => ['config_pages:' . $configPage->id()],
      ],
    ];
    $build['event_platform_header_cta'] = $block;
    return $build;
  }

}
