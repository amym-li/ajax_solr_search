<?php

namespace Drupal\ajax_solr_search\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class SolrSearchController.
 */
class SolrSearchController extends ControllerBase
{

  /**
   * Getsearchform.
   *
   * @return array
   *   Return Hello string.
   */
  public function getSearchForm()
  {

    $config = \Drupal::config('ajax_solr_search.ajaxsolrsearchconfig');

    $facets_htmls = '';
    foreach ($config->get("solr-facets-fields") as $f) {
      $facets_htmls .= '<div style="margin-top: 20px"><h2>' . $f['label'] . '</h2><div class="tagcloud" id="' . $f['fname'] . '"></div></div>';
    }


    $search_form = '<div id="wrap">
      <div class="right">
        <div id="result">
          <div id="navigation">
            <div id="pager-header"></div>
            <ul id="pager"></ul>
          </div>
          <!-- Current Selection -->
          <ul id="selection"></ul>
          <hr />
          <div id="docs" data-content=""></div>
        </div>
      </div>

      <div class="left">
        <h2>Search</h2>

        <div id="search">
          <input type="text" id="query" name="query" autocomplete="off" />
        </div>
        <span id="search_help">press ESC to close suggestions</span>
       ' . $facets_htmls . '
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>';

    //logging($config->get("solr-facets-fields"));
    //logging($config->get("solr-results-html"));
    return [
      '#type' => 'markup',
      '#markup' => $this->t($search_form),
      '#attached' => [
        'library' => [
          'ajax_solr_search/ajax_solr_search',
        ],
        'drupalSettings' => [
          'ajax_solr_search' => [
            'solr_url' => $config->get("solr-server-url"),
            'searchable_fields' => $config->get("solr-searchable-fields"),
            'facets_fields' => json_encode($config->get("solr-facets-fields")),
            'results_html' => json_encode($config->get("solr-results-html"))
          ]
        ]
      ],
    ];
  }

}
