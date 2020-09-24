<?php

/**
 * @file
 * Contains \Drupal\mapplic_maps\Plugin\Block\MapplicMapsMap.
 */

namespace Drupal\mapplic_maps\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'mapplic_maps' block.
 *
 * @Block(
 *   id = "mapplic_maps_map_block",
 *   admin_label = @Translation("Mapplic Maps Map block"),
 *   category = @Translation("Mapplic Maps Map block")
 * )
 */
class MapplicMapsMap extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $config = \Drupal::config('mapplic_maps.settings');

    //to generate: maps/data/world.json
    $source = Url::fromRoute("mapplic_maps_map.json");
    kint($source);

    $mapplicMapsSettings = [
      'mapplic_maps' => [
        'action' => 'tooltip',
        //  path: /maps/data/{map}.json/{map_width}/{map_height}
        'source' => 'maps/data/1200/760/mapplic.json', // maps/data/world.json
        'height' => '760', // $config->get('mapplic_map_height')
        'width' => '1200', // $config->get('mapplic_map_width'),


        'animate' => $config->get('mapplic_animate'),
        'alphabetic' => false,
        'clearbutton' => true,
        'developer' => $config->get('mapplic_developer_mode'),
        'deeplinking' => true,
        'hovertip' => $config->get('mapplic_hovertip'),
        'fillcolor' => '#ff0000',
        'fullscreen' => $config->get('mapplic_fullscreen'),
        'hovertip' => true,
        'landmark' => true,
        'lightbox' => false,
        'locations' => $config->get('mapplic_locations'),
        'mapfill' => $config->get('mapplic_mapfill'),
        'mousewheel' => true,
        'maxscale' => $config->get('mapplic_max_scale'),
        'minimap' => true,
        'markers' => true,
        'selector' => '[id^=landmark] > *, svg > #items > *',
        'search' => $config->get('mapplic_search'),
        'sidebar' => $config->get('mapplic_sidebar'),
        'smartip' => true,
        #'thumbholder' => true,
        'zoombuttons' => $config->get('mapplic_zoombuttons'),
        'zoomoutclose' => true,
        'zoom' => $config->get('mapplic_zoom'),
      ],
    ];
    //kint($mapplicMapsSettings);

    return [
      '#theme' => '',
      '#type' => 'markup',
      '#markup' => '<div id="mapplic_maps"></div>',
      '#attached' => [
        'library' => [
          # internal library in module: 'your_module/library_name'
          'mapplic_maps/mapplic_maps'
        ],
        'drupalSettings' => $mapplicMapsSettings,
      ],
    ];
  }

}
