<?php

namespace Drupal\gbifpublications\Controller;

use Drupal\Core\Url;
// Change following https://www.drupal.org/node/2457593
// See https://www.drupal.org/node/2549395 for deprecate methods information
// use Drupal\Component\Utility\SafeMarkup;
use Drupal\Component\Utility\Html;
// use Html instead SAfeMarkup
use Drupal\Core\Render\Element;

/**
 * Controller routines for GBIF Publications pages.
 */
class GBIFPublicationsController {

    /**
     * Create 1 files with GBIF data on $country
     * This callback is mapped to the path 'gbifpublications/generate/{country}'.
     * @param $country  the country code (two letter in uppercase)
     */
    public function generate($country) {

        // Get Default settings in gbifpublications.settings.yml
        $config = \Drupal::config('gbifpublications.settings');
        // Page title and source text.
        $page_title = $config->get('gbifpublications.page_title');

        //Path of the module
        $module_handler = \Drupal::service('module_handler');
        $module_path = $module_handler->getModule('gbifpublications')->getPath();

        //Get informations
        $curl_publications = curl_init();
        curl_setopt_array($curl_publications, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://www.gbif.org/api/resource/search?contentType=literature&countriesOfResearcher='.$country
        ]);

        if (!curl_exec($curl_publications)) {
            die('Error: "' . curl_error($curl_publications) . '" - Code: ' . curl_errno($curl_publications));
        } else {
            $publications_json = curl_exec($curl_publications);
            curl_close($curl_publications);
        }

        //Extract informations
        $publications_object = json_decode($publications_json);
        $publications = $publications_object->{"results"};

        //Save informations
        file_put_contents($module_path.'/data/'.$country.'-publications.json', json_encode($publications));

        /*  Data for the displaying of information  */

        $element['#country_code'] = Html::escape($country);
        $element['#title'] = Html::escape($page_title);

        // Theme function.
        $element['#theme'] = 'gbifpublicationsgenerate';

        return $element;
    }

    /**
     * Displaying the first 10 GBIF publications on one country
     * @param $country  the country code (two letter in uppercase)
     * @return mixed    html displaying the GBIF publications on one country
     */
    public function displaydefault($country) {
        // Get Default settings in gbifpublications.settings.yml
        $config = \Drupal::config('gbifpublications.settings');
        // Getting module parameters
        $page_title = $config->get('gbifpublications.page_title');

        //Path of the module
        $module_handler = \Drupal::service('module_handler');
        $module_path = $module_handler->getModule('gbifpublications')->getPath();

        //Initialing variables
        $publications_json = "";
        $element['#publications'] = array();

        //Gettings all of the publications
        $publications_json = file_get_contents($module_path . '/data/' . $country . '-publications.json');
        $publications_array = json_decode($publications_json, true);

        for($index = 0; $index < 10 && count($publications_array)>10; $index++){

            $publication = array();

            $authors = $publications_array[$index]['authors'];

            for($indexAuthor= 0 ; count($authors) > $indexAuthor ; $indexAuthor++){
                $publication['authors'][] = Html::escape("" . $authors[$indexAuthor]['lastName']." ".$authors[$indexAuthor]['firstName'][0]);
            }

            $publication['year']       = Html::escape("" . $publications_array[$index]['year']);
            $publication['website']    = Html::escape("" . $publications_array[$index]['websites'][0]);
            $publication['title']      = Html::escape("" . $publications_array[$index]['title']);
            $publication['source']     = Html::escape("" . $publications_array[$index]['source']);
            $publication['abstract']   = Html::escape("" . $publications_array[$index]['abstract']);

            $keywords = $publications_array[$index]['keywords'];

            for($indexKeyword = 0 ; count($keywords) > $indexKeyword ; $indexKeyword++){
                $publication['keywords'][] = Html::escape("" . $keywords[$indexKeyword]);
            }

            array_push($element['#publications'], $publication);
        }

        //  Data for the displaying of information
        $element['#previous'] = 0;
        $element['#next'] = (count($publications_array)>11)?Html::escape(11):0;
        $element['#country_code'] = Html::escape($country);
        $element['#title'] = Html::escape($page_title);

        // Theme function.
        $element['#theme'] = 'gbifpublicationsdisplay';

        return $element;
    }

    /**
     * Displaying 10 GBIF publications on one country
     * @param $country  the country code (two letter in uppercase)
     * @param $debut    the index from which we have to display 10 publications
     * @return mixed    html displaying the GBIF publications on one country
     */
    public function display($country, $debut) {
        // Get Default settings in gbifpublications.settings.yml
        $config = \Drupal::config('gbifpublications.settings');
        // Getting module parameters
        $page_title = $config->get('gbifpublications.page_title');

        //Path of the module
        $module_handler = \Drupal::service('module_handler');
        $module_path = $module_handler->getModule('gbifpublications')->getPath();

        //Initialing variables
        $publications_json = "";
        $element['#publications'] = array();

        //Gettings all of the publications
        $publications_json = file_get_contents($module_path . '/data/' . $country . '-publications.json');
        $publications_array = json_decode($publications_json, true);

        if(is_null($debut)){
            $debut = 0;
        }

        for($index = $debut; $index < $debut+10 && count($publications_array)>$debut+10; $index++){

            $publication = array();

            $authors = $publications_array[$index]['authors'];

            for($indexAuthor= 0 ; count($authors) > $indexAuthor ; $indexAuthor++){
                $publication['authors'][] = Html::escape("" . $authors[$indexAuthor]['lastName']." ".$authors[$indexAuthor]['firstName'][0]);
            }

            $publication['year']       = Html::escape("" . $publications_array[$index]['year']);
            $publication['website']    = Html::escape("" . $publications_array[$index]['websites'][0]);
            $publication['title']      = Html::escape("" . $publications_array[$index]['title']);
            $publication['source']     = Html::escape("" . $publications_array[$index]['source']);
            $publication['abstract']   = Html::escape("" . $publications_array[$index]['abstract']);

            $keywords = $publications_array[$index]['keywords'];

            for($indexKeyword = 0 ; count($keywords) > $indexKeyword ; $indexKeyword++){
                $publication['keywords'][] = Html::escape("" . $keywords[$indexKeyword]);
            }

            array_push($element['#publications'], $publication);
        }

        //  Data for the displaying of information
        $element['#previous'] = ($debut>10)?Html::escape($debut-11):0;
        $element['#next'] = (count($publications_array)>$debut+11)?Html::escape($debut+11):0;
        $element['#country_code'] = Html::escape($country);
        $element['#title'] = Html::escape($page_title);

        // Theme function.
        $element['#theme'] = 'gbifpublicationsdisplay';

        return $element;
    }
}