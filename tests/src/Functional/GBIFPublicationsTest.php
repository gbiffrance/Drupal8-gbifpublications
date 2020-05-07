<?php

namespace Drupal\Tests\gbifpublications\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests for the GBIF Publications module.
 *
 * @group gbifpublications
 */
class GBIFPublicationsTests extends BrowserTestBase {

    /**
     * Modules to install.
     *
     * @var array
     */
    protected static $modules = array('gbifpublications');

    /**
     * A simple user.
     *
     * @var \Drupal\user\Entity\User
     */
    private $user;

    /**
     * Perform initial setup tasks that run before every test method.
     */
    public function setUp() {
        parent::setUp();
        $this->user = $this->drupalCreateUser(array(
            'administer site configuration',
            'generate GBIF Publications',
        ));
    }

    /**
     * Tests that the GBIF Stats page can be reached.
     */
    public function testGBIFStatsPageExists() {
        // Login.
        $this->drupalLogin($this->user);

        // Generator test:
        $this->drupalGet('gbifpublications/generate/FR');
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * Tests the config form.
     */
    public function testConfigForm() {
        // Login.
        $this->drupalLogin($this->user);

        // Access config page.
        $this->drupalGet('admin/config/development/gbifpublications');
        $this->assertSession()->statusCodeEquals(200);
        // Test the form elements exist and have defaults.
        $config = $this->config('gbifpublications.settings');
        $this->assertSession()->fieldValueEquals(
            'page_title',
            $config->get('gbifpublications.page_title'),
        );
        $this->assertSession()->fieldValueEquals(
            'country_code',
            $config->get('gbifpublications.country_code'),
        );

        // Test form submission.
        $this->drupalPostForm(NULL, array(
            'page_title' => 'Test GBIF Publications',
            'country_code' => 'Test phrase 1 \nTest phrase 2 \nTest phrase 3 \n',
        ), t('Save configuration'));
        $this->assertSession()->pageTextContains('The configuration options have been saved.');

        // Test the new values are there.
        $this->drupalGet('admin/config/development/gbifpublications');
        $this->assertSession()->statusCodeEquals(200);
        $this->assertSession()->fieldValueEquals(
            'page_title',
            'Test GBIF Stats',
        );
        $this->assertSession()->fieldValueEquals(
            'country_code',
            'Test phrase 1 \nTest phrase 2 \nTest phrase 3 \n',
        );
    }

}