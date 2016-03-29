<?php

namespace Drupal\stacksight\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure logging settings for this site.
 */
class StacksightFeaturesForm extends ConfigFormBase {

    public function getFormId() {
        return 'stacksight_form_features';
    }

    protected function getEditableConfigNames() {
        return array(
            'stacksight.features'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('stacksight.features');

        $form = array();

        $description = (defined('stacksight_logs_text')) ? stacksight_logs_text : '';
        $form['stacksight_include_logs'] = array(
            '#type' => 'checkbox',
            '#title' => (defined('stacksight_logs_title')) ? stacksight_logs_title : t('Include Logs'),
            '#default_value' => $config->get('features.include_logs'),
            '#description' => t($description),
            '#required' => false
        );

        $description = (defined('stacksight_health_text')) ? stacksight_health_text : '';
        $form['stacksight_include_health'] = array(
            '#type' => 'checkbox',
            '#title' => (defined('stacksight_health_title')) ? stacksight_health_title : t('Include Health'),
            '#default_value' => ($conf = $config->get('features.include_health')) ? $conf : true,
            '#description' => t($description),
            '#required' => false
        );

        $description = (defined('stacksight_inventory_text')) ? stacksight_inventory_text : '';
        $form['stacksight_include_inventory'] = array(
            '#type' => 'checkbox',
            '#title' => (defined('stacksight_inventory_title')) ? stacksight_inventory_title : t('Include Inventory'),
            '#default_value' => ($conf = $config->get('features.include_inventory')) ? $conf : true,
            '#description' => t($description),
            '#required' => false
        );

        $description = (defined('stacksight_events_text')) ? stacksight_events_text : '';
        $form['stacksight_include_events'] = array(
            '#type' => 'checkbox',
            '#title' => (defined('stacksight_events_title')) ? stacksight_events_title : t('Include Events'),
            '#default_value' => ($conf = $config->get('features.include_events')) ? $conf : true,
            '#description' => t($description),
            '#required' => false
        );

        $description = (defined('stacksight_updates_text')) ? stacksight_updates_text : '';
        $form['stacksight_include_updates'] = array(
            '#type' => 'checkbox',
            '#title' => (defined('stacksight_updates_title')) ? stacksight_updates_title : t('Include Updates'),
            '#default_value' => ($conf = $config->get('features.include_updates')) ? $conf : true,
            '#description' => t($description),
            '#required' => false
        );
        
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
        $this->config('stacksight.features')
            ->set('features.include_logs', $form_state->getValue('stacksight_include_logs'))
            ->set('features.include_health', $form_state->getValue('stacksight_include_health'))
            ->set('features.include_inventory', $form_state->getValue('stacksight_include_inventory'))
            ->set('features.include_events', $form_state->getValue('stacksight_include_events'))
            ->set('features.include_updates', $form_state->getValue('stacksight_include_updates'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}