<?php

namespace Drupal\gbifpublications\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * GBIF Publications block form
 */
class GBIFPublicationsBlockForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'gbifpublications_block_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        // Defining the country code
        $form['country'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Country Code'),
            '#default_value' => 'FR',
            '#description' => $this->t('Write the two letters of the country code'),
        ];

        // Submit.
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Generate'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        $phrases = $form_state->getValue('code');
        if (!is_string($phrases)) {
            $form_state->setErrorByName('code', $this->t('Please use only letters.'));
        }

        if (strlen($phrases ) < 2 || strlen($phrases ) > 2) {
            $form_state->setErrorByName('code', $this->t('Country code are two letters only'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $form_state->setRedirect('gbifpublications.generate', [
            'code' => $form_state->getValue('code'),
        ]);
    }

}