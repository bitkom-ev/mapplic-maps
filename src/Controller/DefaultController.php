<?php

/**
 * @file
 * Contains \Drupal\mapplic_maps\Controller\DefaultController.
 */

namespace Drupal\mapplic_maps\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\image\Entity\ImageStyle;

/**
 * Default controller for the mapplic maps module.
 */
class DefaultController extends ControllerBase {

    public function _mapplic_maps_json() {
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
            $settings['levels'][0]['map'] = '/libraries/mapplic_maps/html/maps/deutschland.svg';
            $settings['levels'][0]['minimap'] = '/libraries/mapplic_maps/html/maps/deutschland-mini.svg';
            
        } catch (Exception $e) {
            watchdog('entity_metadata_wrapper', 'entity_metadata_wrapper error in %error_loc', [
                '%error_loc' => __FUNCTION__ . ' @ ' . __FILE__ . ' : ' . __LINE__
                    ], WATCHDOG_CRITICAL);
            return;
        }

        $nodes = [];
        /**
          taxonomy landkarten ::
         * on stage:
          Deutschland = 557
          Europa      = 558c
          Welt        = 559
         */
        $query = \Drupal::entityQuery('node');
        $query
                ->condition('type', 'mapplic_landmark')
                ->condition('status', 1)
                ->condition('field_mapplic_map_karte:taxonomy_term.name', 'Deutschland', '=') // Deutschland = 557 'value', 'Deutschland', '='
                ->sort('title', 'ASC');

        $result = $query->execute();
        if (isset($result) && !empty($result)) {
            $nodes = node_load_multiple($result);
        }

        foreach ($nodes as $node) {
            try {
                /**
                  $thumb = $description = NULL;
                  $thumb = $node->get('field_thumb_image')->getValue()[0]['target_id'];
                  $file = File::load($thumb);
                  $uri = $file->getFileUri();
                  if ($uri != NULL) {
                  $thumb_url = ImageStyle::load('mapplic_thumb')->buildUrl($uri);//image_style_url("mapplic_thumb", $thumb['uri']);
                  }
                 */
                if ($node->__isSet('body')) {
                    $description = $node->get('body')->getValue();
                    $about = $description[0]['summary'];
                    $description = $description[0]['value'];
                }

                if (isset($node->get('field_mapplic_map_id')->getValue()[0]['value'])) {
                    $id = $node->get('field_mapplic_map_id')->getValue()[0]['value'];
                }
                $settings['levels'][0]['locations'][] = [
                    'id' => $id,
                    'title' => $node->getTitle(),
                    'label' => strip_tags($about),
                    'description' => strip_tags($description, '<a><b><p><br><div><img>'),
                    //'thumbnail' => $thumb_url,
                    'pin' => "hidden",
                    'fill' => $node->get('field_background_colour')->getValue()[0]['value'],
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

        kint($settings);

        return new JsonResponse($settings);
    }

    public function _mapplic_svg($fid) {
        $headers = [
            'Content-Type' => 'image/svg+xml',
        ];

        try {
            $file = File::load($fid);

            $uri = $file->getFileUri();
            return new BinaryFileResponse($uri, 200, $headers);
        } catch (Exception $e) {
            watchdog('entity_metadata_wrapper', 'entity_metadata_wrapper error in %error_loc', [
                '%error_loc' => __FUNCTION__ . ' @ ' . __FILE__ . ' : ' . __LINE__
                    ], WATCHDOG_CRITICAL);
            return;
        }

        echo '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="315.777px" height="65.056px" viewBox="0 0 315.777 65.056" enable-background="new 0 0 315.777 65.056"
	 xml:space="preserve">
<text transform="matrix(1 0 0 1 28.8892 36.6665)" font-family="ArialMT" font-size="12">No SVG file set, please upload via the admin.</text>
</svg>
';
        exit;
    }

}
