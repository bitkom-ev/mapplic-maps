<?php
/**
 * @file
 * Contains \Drupal\mapplic_maps\Plugin\Block\MapplicMapsLaenderstartups.
 */

namespace Drupal\mapplic_maps\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\DrupalSettings;
use Drupal\Core\Url;

/**
 * Provides a 'mapplic_maps' block.
 *
 * @Block(
 *   id = "mapplic_maps_bundeslaender_block",
 *   admin_label = @Translation("Mapplic Maps Laender Startups block"),
 *   category = @Translation("Mapplic Maps Laender Startups block")
 * )
 */
class MapplicMapsLaenderstartups extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $config = \Drupal::config('mapplic_maps.settings');

    //to generate: /maps/data/laenderstartups
    //$source = Url::fromRoute("mapplic_maps_laenderstartups.json");

    $mapplicMapsSettings = [
      'mapplic_maps' => [
        'action' => 'tooltip',
        'source' => $base_url . "/maps/data/laenderstartups.json",
        'animate' => $config->get('mapplic_animate'),
        'alphabetic' => FALSE,
        'clearbutton' => TRUE,
        'developer' => $config->get('mapplic_developer_mode'), // true / false
        'deeplinking' => TRUE,
        'height' => $config->get('mapplic_map_height'),
        'width' => $config->get('mapplic_map_width'),
        'hovertip' => $config->get('mapplic_hovertip'),
        'fillcolor' => '#ff0000',
        'fullscreen' => $config->get('mapplic_fullscreen'),
        'hovertip' => TRUE,
        'landmark' => TRUE,
        'lightbox' => FALSE,
        'locations' => $config->get('mapplic_locations'),
        'mapfill' => FALSE, // $config->get('mapplic_mapfill'),
        'mousewheel' => TRUE,
        'minimap' => TRUE,
        'markers' => TRUE,
        'selector' => '[id^=landmark] > *, svg > #items > *',
        'search' => $config->get('mapplic_search'),
        'sidebar' => $config->get('mapplic_sidebar'),
        'smartip' => TRUE,
        //'thumbholder' => true,
        'zoombuttons' => $config->get('mapplic_zoombuttons'),
        'zoomoutclose' => TRUE,
        'zoom' => $config->get('mapplic_zoom'),
      ],
    ];
    //kint($mapplicMapsSettings);


    return [
      '#theme' => '',
      '#description' => t('German Countries for Startups Map'),
      '#type' => 'markup',
      '#markup' => '<div id="mapplic_maps"></div>',
      '#attached' => [
        'library' => [
          # internal library in module: 'your_module/library_name'
          'mapplic_maps/mapplic_maps',
        ],
        'drupalSettings' => $mapplicMapsSettings,
      ],
    ];
  }

}
