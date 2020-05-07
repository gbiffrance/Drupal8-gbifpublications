<?php

namespace Drupal\gbifpublications\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class GBIFPublicationsForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'gbifpublications_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Form constructor.
        $form = parent::buildForm($form, $form_state);
        // Default settings.
        $config = $this->config('gbifpublications.settings');

        // Page title field.
        $form['page_title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Titre de la page :'),
            '#default_value' => $config->get('gbifpublications.page_title'),
            '#description' => $this->t('Le titre donné à la page d\'affichage des publications.')
        );
        // Country Code field.
        $form['country_code'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Le code du pays :'),
            '#default_value' => $config->get('gbifpublications.country_code'),
            '#description' => $this->t('Les deux lettre majuscule constituant le code du pays.')
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config('gbifpublications.settings');
        $config->set('gbifpublications.country_code', $form_state->getValue('country_code'));
        $config->set('gbifpublications.page_title', $form_state->getValue('page_title'));
        $config->save();
        return parent::submitForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'gbifpublications.settings',
        ];
    }

}