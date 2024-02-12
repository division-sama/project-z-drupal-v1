<?php
namespace Drupal\custom_controller\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides route responses for the Example module.
 */
class ExampleController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function myPage( Request $request ) {

    if ($request->isMethod('POST')) {
        // Get form data.
        $data = $request->request->all();
  
        // You can process or validate the data here.
  
        // Return JSON response.
        return new JsonResponse($data);
      }
      else {
        // Return the form or any other content.
        return [
          '#markup' => $this->t('Your form content goes here.'),
        ];
    }
  }

}