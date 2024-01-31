<?php

namespace Drupal\custom_api\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Core\Entity\Field\FieldDefinition;


/**
 * Provides a custom REST resource.
 *
 * @RestResource(
 *   id = "custom_rest_api",
 *   label = @Translation("Custom REST Resource"),
 *   uri_paths = {
 *     "canonical" = "/api"
 *   }
 * )
 */
class CustomRestResource extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   */
  public function get() {

    $username = \Drupal::request()->query->get('username');

    $uid = user_load_by_name($username)->id();

      $filteredData = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('uid', $uid)
      ->execute();

      $filteredData1 = [];
      $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($filteredData);

      foreach ($nodes as $node) {
          $filteredNodeData = [];
          foreach ($node as $field_name => $field_value) {
            
              if (strpos($field_name, 'field_') === 0) {
                  $filteredNodeData[$field_name] = $field_value;
              }
          }
          $filteredData1[$node->id()] = $filteredNodeData;
      }

    return new ResourceResponse($filteredData1);
  }
}
