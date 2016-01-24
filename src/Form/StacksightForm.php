<?php

namespace Drupal\stacksight\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure logging settings for this site.
 */
class StacksightForm extends FormBase {

    public function getFormId() {
        return 'stacksight_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        if (defined('STACKSIGHT_APP_ID')) {
            $form['stacksight_app_id'] = array(
                '#type' => 'fieldset',
                '#title' => t('Stack ID')->render(),
                '#description' => defined('STACKSIGHT_APP_ID') ? STACKSIGHT_APP_ID : '<span class="pre-code-red">' . t("Not set")->render() . '</span>'
            );
        }

        $form['stacksight_token'] = array(
            '#type' => 'fieldset',
            '#title' => t('Access Token')->render(),
            '#description' => defined('STACKSIGHT_TOKEN') ? STACKSIGHT_TOKEN : '<span class="pre-code-red">' . t("Not set")->render() . '</span>'
        );

        $token = defined('STACKSIGHT_TOKEN') ? STACKSIGHT_TOKEN : t('YOUR_STACKSIGHT_TOKEN')->render();
//        if ($token) {
        $form['code'] = array(
            '#theme' => 'code_config',
            '#type' => 'markup',
            '#name' => 'IGOR KOZLOVSKY1',
            '#attributes' => array(
                'data' => array(
                    'token' => $token,
                    'module_path' => drupal_get_path('module', 'stacksight'),
                    'diagnostic' => $this->_diagnostic()
                )
            ),
        );
//        }
        $form['actions']['#type'] = 'actions';
        return $form;
    }

    private function _diagnostic(){
        $list = array();
        if (!defined('STACKSIGHT_TOKEN')) {
            $list[] = t("Token is not defined")->render();
        }

        if (!defined('STACKSIGHT_BOOTSTRAPED')) {
            $list[] = t("bootstrap-drupal.php is not included in settings.php")->render();
        }
        return $list;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
    }

}