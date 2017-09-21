<?php

namespace Drupal\gnfac_advisory\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TestForm extends ConfigFormBase {

  public function getFormId() {
    return 'test_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('gnfac_advisory.settings');

    $form['default_count'] = [
      '#type' => 'number',
      '#title' => $this->t('Default count'),
      '#default_value' => $config->get('default_count'),
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('gnfac_advisory.settings');
    $config->set('default_count', $form_state->getValue('default_count'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

  protected function getEditableConfigNames() {
    return ['gnfac_advisory.settings'];
  }

}
