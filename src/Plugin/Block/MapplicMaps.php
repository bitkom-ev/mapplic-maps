<?php

/**
 * @file
 * Contains \Drupal\mapplic_maps\Plugin\Block\MapplicMaps.
 */

namespace Drupal\mapplic_maps\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'mapplic_maps' block.
 *
 * @Block(
 *   id = "mapplic_maps_block",
 *   admin_label = @Translation("Mapplic Maps block"),
 *   category = @Translation("Mapplic Maps world block")
 * )
 */
class MapplicMaps extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        $config = \Drupal::config('mapplic_maps.settings');
        //print $config->get('mapplic_map_source');
        $mapplicMapsSettings = [
            'mapplic_maps' => [
                'source' => $config->get('mapplic_map_source'),
                'action' => 'tooltip',
                'animate' => $config->get('mapplic_animate'),
                'alphabetic' => false,
                'clearbutton' => true,
                'developer' => $config->get('mapplic_developer_mode'),
                'deeplinking' => true,
                'height' => $config->get('mapplic_map_height'),
                'hovertip' => $config->get('mapplic_hovertip'),
                'fillcolor' => 'ff0000',
                'fullscreen' => $config->get('mapplic_fullscreen'),
                'hovertip' => true,
                'landmark' => false,
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
                'width' => $config->get('mapplic_map_width'),
                'thumbholder' => true,
                'zoombuttons' => $config->get('mapplic_zoombuttons'),
                'zoomoutclose' => true,
                'zoom' => $config->get('mapplic_zoom'),
            ],
        ];

        return [
            '#theme' => 'smartschool',
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
