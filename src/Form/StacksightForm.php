<?php

namespace Drupal\stacksight\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure logging settings for this site.
 */
class StacksightForm extends ConfigFormBase {

    public function getFormId() {
        return 'stacksight_form_settings';
    }

    protected function getEditableConfigNames() {
        return array(
            'stacksight.settings'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('stacksight.settings');

        $form['app_id'] = (defined('STACKSIGHT_SETTINGS_IN_DB') && STACKSIGHT_SETTINGS_IN_DB === true) ? array(
            '#type' => 'textfield',
            '#title' => t('STACK ID')->render(),
            '#default_value' => $config->get('main.app_id'),
            '#required' => false
        ):
            array(
                '#type' => 'fieldset',
                '#title' => t('STACK ID')->render(),
                '#description' => defined('STACKSIGHT_APP_ID') ? STACKSIGHT_APP_ID : '<span class="pre-code-green">'.t("Is calculated").'</span>'
            )
        ;

        $form['token'] = (defined('STACKSIGHT_SETTINGS_IN_DB') && STACKSIGHT_SETTINGS_IN_DB === true) ? array(
            '#type' => 'textfield',
            '#title' => t('Access Token')->render(),
            '#default_value' => $config->get('main.token'),
            '#required' => true
        ):
            array(
                '#type' => 'fieldset',
                '#title' => t('Access Token')->render(),
                '#description' => defined('STACKSIGHT_TOKEN') ? STACKSIGHT_TOKEN : '<span class="pre-code-red">' . t("Not set")->render() . '</span>'
            )
        ;

        $form['group'] = (defined('STACKSIGHT_SETTINGS_IN_DB') && STACKSIGHT_SETTINGS_IN_DB === true) ? array(
            '#type' => 'textfield',
            '#title' => t('Stacksight group')->render(),
            '#default_value' => $config->get('main.group'),
            '#required' => false,
        ):
            array(
                '#type' => 'fieldset',
                '#title' => t('Stacksight group')->render(),
                '#description' => defined('STACKSIGHT_APP_ID') ? STACKSIGHT_APP_ID : '<span class="pre-code-red">' . t("Not set")->render() . '</span>'
            )
        ;

        /*
        $token = defined('STACKSIGHT_TOKEN') ? STACKSIGHT_TOKEN : t('YOUR_STACKSIGHT_TOKEN')->render();
        if ($token) {
            $form['code'] = array(
                '#theme' => 'code_config',
                '#type' => 'markup',
                '#name' => 'instruction',
                '#attributes' => array(
                    'data' => array(
                        'token' => $token,
                        'module_path' => drupal_get_path('module', 'stacksight'),
                        'diagnostic' => $this->_diagnostic()
                    )
                ),
            );
        }
        */
        $form['actions']['#type'] = 'actions';
        return parent::buildForm($form, $form_state);
    }

    private function _diagnostic(){
        $list = array();
        if (!defined('STACKSIGHT_TOKEN')) {
            $list[] = t("Token is not defined")->render();
        }

        if (!defined('STACKSIGHT_BOOTSTRAPED')) {
            $list[] = t("bootstrap-drupal-8.php is not included in settings.php")->render();
        }
        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        if(defined('STACKSIGHT_SETTINGS_IN_DB') && STACKSIGHT_SETTINGS_IN_DB === true){
            $this->config('stacksight.settings')
                ->set('main.token', $form_state->getValue('token'))
                ->set('main.app_id', $form_state->getValue('app_id'))
                ->set('main.group', $form_state->getValue('group'))
                ->save();

            parent::submitForm($form, $form_state);
        }
    }
}