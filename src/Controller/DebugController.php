<?php
namespace Drupal\stacksight\Controller;
use Drupal\Core\Controller\ControllerBase;

class DebugController extends ControllerBase
{
    public function debug()
    {
        if((defined('STACKSIGHT_DEBUG') && STACKSIGHT_DEBUG === true) && defined('STACKSIGHT_DEBUG_MODE') && STACKSIGHT_DEBUG_MODE === true) {
            return array('debug' => array(
                '#theme' => 'debug_page'
            ));
        } else{
            return array();
        }
    }
}