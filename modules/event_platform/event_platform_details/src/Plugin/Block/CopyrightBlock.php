<?php

namespace Drupal\event_platform_details\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\config_pages\Entity\ConfigPages;

/**
 * Provides a copyright block.
 *
 * @Block(
 *   id = "event_platform_details_copyright",
 *   admin_label = @Translation("Copyright"),
 *   category = @Translation("Event Platform")
 * )
 */
class CopyrightBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $configPage = ConfigPages::config('event_details');
    if ($configPage) {
      $site_name = $configPage->get('field_event_name')->value ?? NULL;
      $cache_tag = 'config_pages:' . $configPage->id();
    }
    else {
      $site_name = NULL;
      $cache_tag = 'config_pages_list';
    }
    if (!$site_name) {
      $site_name = \Drupal::config('system.site')->get('name');
    }

    $block = [
      '#theme' => 'event_platform_copyright_block',
      '#attributes' => [
        'class' => ['copyright'],
        'id' => 'copyright-block',
      ],
      '#org_name'  => $site_name,
      '#year'  => date('Y'),
      '#cache' => [
        'tags' => [$cache_tag],
      ],
    ];
    $build['event_platform_details_copyright'] = $block;
    return $build;
  }

}
