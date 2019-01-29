<?php

/**
 * @file
 * Contains \Drupal\mapplic_maps\Controller\GermanyController.
 */

namespace Drupal\mapplic_maps\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\image\Entity\ImageStyle;

/**
 * Germany controller for the mapplic maps module.
 */
class GermanyController extends ControllerBase {

    public function _mapplic_maps_germany_json() {
        $settings = [
            'mapwidth' => "600",
            'mapheight' => "800",
            'categories' => ['Deutschland'],
            'levels' => [],
        ];

        try {
            $config = \Drupal::config('mapplic_maps.settings');
            $settings['levels'][0]['id'] = 'deutschland';
            $settings['levels'][0]['title'] = 'Deutschland';
            $settings['levels'][0]['map'] = '/modules/contrib/mapplic_maps/libraries/mapplic_maps/html/maps/deutschland.svg';
            $settings['levels'][0]['minimap'] = '/modules/contrib/mapplic_maps/libraries/mapplic_maps/html/maps/deutschland-mini.jpg';
        } catch (Exception $e) {
            watchdog('entity_metadata_wrapper', 'entity_metadata_wrapper error in %error_loc', [
                '%error_loc' => __FUNCTION__ . ' @ ' . __FILE__ . ' : ' . __LINE__
                    ], WATCHDOG_CRITICAL);
            return;
        }

        $nodes = [];
        /**
          taxonomy landkarten ::
          Deutschland = 557
          Europa      = 558c
          Welt        = 559
         */
        $query = \Drupal::entityQuery('node');
        $query
                ->condition('type', 'mapplic_landmark')
                ->condition('status', 1)
                ->condition('field_mapplic_map_karte', 557) // Deutschland = 557 'value', 'Deutschland', '='
                ->sort('title', 'ASC');

        $result = $query->execute();
        if (isset($result) && !empty($result)) {
            $nodes = node_load_multiple($result);
        }
        if (empty($nodes)) {
            return;
        }

        foreach ($nodes as $node) {
            try {
                /**
                 * */
                  
                  $thumb = NULL; 
                  $uri = NULL;
                  $thumb = $node->get('field_thumb_image')->getValue()[0]['target_id'];
                  if ($thumb != NULL) {
                  $file = File::load($thumb);
                  $uri = $file->getFileUri();
                  }
                  $thumb_url = NULL;
                  if ($uri != NULL) {
                    $thumb_url = ImageStyle::load('mapplic_thumb')->buildUrl($uri); //image_style_url("mapplic_thumb", $thumb['uri']);
                  }
                
                  
                $description = NULL;
                $about = NULL;
                if ($node->__isSet('body')) {
                    $description = $node->get('body')->getValue();
                    if($description != NULL) {
                        $about = strip_tags($description[0]['summary']);
                    }
                    $description = strip_tags($description[0]['value'], '<a><b><p><br><div><img>');
                }
                /**
                 * optional fields check if:
                 */
                if(isset($node->get('field_mapplic_svg_id')->getValue()[0]['value'])) {
                    $id = $node->get('field_mapplic_svg_id')->getValue()[0]['value'];
                }
                if(isset($node->get('field_mapplic_map_id')->getValue()[0]['value'])) {
                    $id = $node->get('field_mapplic_map_id')->getValue()[0]['value'];
                }
                
                if(isset($node->get('field_link')->getValue()[0]['uri'])) {
                    $link = $node->get('field_link')->getValue()[0]['uri'];
                }
                
                
                $settings['levels'][0]['locations'][] = [
                    'id' => $id, //$wrapper->mapplic_svg_id->value(), $node->get('field_mapplic_svg_id')->getValue()[0]['value']
                    'title' => $node->getTitle(),
                    'description' => $description,
                    'label' => $about,
                    'pin' => $node->get('field_mapplic_pin')->getValue()[0]['value'] ?: 'hidden',
                    'fill' => $node->get('field_background_colour')->getValue()[0]['value'] ?: '',
                    'thumbnail' => $thumb_url,
                    'link' => $link, // $node->get('field_link')->getValue()[0]['uri'],
                    'zoom' => $node->get('field_zoom')->getValue()[0]['value'],
                    //'pin' => "hidden",
                    'x' => $node->get('field_mapplic_pos_x')->getValue()[0]['value'], //$wrapper->mapplic_pos_x->value(),
                    'y' => $node->get('field_mapplic_pos_y')->getValue()[0]['value'], //$wrapper->mapplic_pos_y->value(),
                ];
            } catch (Exception $e) {
                watchdog('entity_metadata_wrapper', 'entity_metadata_wrapper error in %error_loc', [
                    '%error_loc' => __FUNCTION__ . ' @ ' . __FILE__ . ' : ' . __LINE__
                        ], WATCHDOG_CRITICAL);
                return;
            }
        }

        rsort($settings['levels']);
        // Calling all modules implementing hook_mapplic_maps_settings_alter():
        \Drupal::moduleHandler()->alter('mapplic_maps_settings', $settings);

        return new JsonResponse($settings);
    }

}
