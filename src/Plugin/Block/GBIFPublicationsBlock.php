<?php

namespace Drupal\gbifpublications\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a GBIF Publication block with which you can generate the file who will store the publications.
 *
 * @Block(
 *   id = "gbifpublications_block",
 *   admin_label = @Translation("GBIF Publication block"),
 * )
 */
class GBIFPublicationsBlock extends BlockBase implements BlockPluginInterface {

    /**
     * {@inheritdoc}
     */
    public function build() {
        // Return the form @ Form/GBIFPublicationsBlockForm.php.
        return \Drupal::formBuilder()->getForm('Drupal\gbifpublications\Form\GBIFPublicationsBlockForm');
    }

    /**
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account) {
        return AccessResult::allowedIfHasPermission($account, 'generate GBIF Publications');
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {

        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->setConfigurationValue('gbifpublications_block_settings', $form_state->getValue('gbifpublications_block_settings'));
    }

}