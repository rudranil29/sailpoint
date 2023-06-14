<?php

namespace Drupal\sailpoint\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class MyConfigForm extends ConfigFormBase {

    public function getFormId()
    {
        return 'sailpoint_config_form';
    }

    protected function getEditableConfigNames()
    {
        return [
            'sailpoint.settings'
        ];
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('sailpoint.settings');

        $form['api_url'] = [
            '#type' => 'url',
            '#title' => 'Add github API url',
            '#default_value' => $config->get('api_url'),
            '#required' => TRUE,

        ];

        $form['api_token'] = [
            '#type' => 'textfield',
            '#title' => 'Put your github API token',
            '#default_value' => $config->get('api_token'),
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Submit form',
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->config('sailpoint.settings');
        $config->set('api_url', $form_state->getValue('api_url'));
        $config->set('api_token', $form_state->getValue('api_token'));
        $config->save();


        return parent::submitForm($form, $form_state);
    }
}
