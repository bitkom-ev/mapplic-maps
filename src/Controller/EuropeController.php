<?php

/**
 * @file
 * Contains \Drupal\mapplic_maps\Controller\EuropeController.
 */

namespace Drupal\mapplic_maps\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\image\Entity\ImageStyle;

/**
 * Europe controller for the mapplic maps module.
 */
class EuropeController extends ControllerBase {

    public function _mapplic_maps_europe_json() {
        //kint('Europe _mapplic_maps_germany_json called');
        $settings = [
            'mapwidth' => "600",
            'mapheight' => "800",
            'categories' => ['state'],
            'levels' => [],
        ];

        try {
            $config = \Drupal::config('mapplic_maps.settings');
            $settings['levels'][0]['id'] = 'europe';
            $settings['levels'][0]['title'] = 'Europa';
            $settings['levels'][0]['map'] = '/modules/contrib/mapplic_maps/libraries/mapplic_maps/html/maps/europe.svg';
            $settings['levels'][0]['minimap'] = '/modules/contrib/mapplic_maps/libraries/mapplic_maps/html/maps/europe-mini.jpg';
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
          Europa      = 558
          Welt        = 559
         */
        $query = \Drupal::entityQuery('node');
        $query->condition('type', 'mapplic_landmark')
                ->condition('status', 1)
                ->condition('landkarten', 558) // 558 = europa
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
                  $thumb = $description = NULL;
                  $thumb = $node->get('field_thumb_image')->getValue()[0]['target_id'];
                  if ($thumb != NULL) {
                  $file = File::load($thumb);
                  $uri = $file->getFileUri();
                  }
                  if ($uri != NULL) {
                  $thumb_url = ImageStyle::load('mapplic_thumb')->buildUrl($uri); //image_style_url("mapplic_thumb", $thumb['uri']);
                  }
                 * */
                if ($node->__isSet('body')) {
                    $description = $node->get('body')->getValue();
                    $about = $description[0]['summary'];
                    $description = $description[0]['value'];
                }
                $settings['levels'][0]['locations'][] = [
                    'id' => $node->get('field_mapplic_svg_id')->getValue()[0]['value'], //$wrapper->mapplic_svg_id->value(),
                    'title' => $node->getTitle(),
                    'description' => strip_tags($description, '<a><b><p><br><div><img>'),
                    'label' => strip_tags($about),
                    'pin' => $node->get('field_mapplic_pin')->getValue()[0]['value'] ?: 'hidden',
                    'fill' => $node->get('field_background_colour')->getValue()[0]['value'] ?: '',
                    //'thumbnail' => $thumb_url,
                    'link' => $node->get('field_link')->getValue()[0]['uri'],
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
