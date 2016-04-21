<?php

namespace Drupal\ymca_alters\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    foreach ($collection as &$item) {
      /** @var Route $item */
      switch ($item->getPath()) {
        case '/node/{node}':
          $item->setDefault('_controller', 'Drupal\ymca_alters\Controller\NodeViewController::view');
          break;

        case '/sitemap':
          $item->setPath('/sitemap_navigation');
          break;
      }
    }

    // Set Location schedules views page to use admin theme.
    // view.[VIEW NAME].[DISPLAY NAME].
    if ($route = $collection->get('view.location_schedules.location_schedules_page')) {
      $route->setOption('_admin_route', TRUE);
    }

    // Replace page manager block edit form with our customization.
    if ($route = $collection->get('page_manager.variant_edit_block')) {
      $route->setDefault('_form', '\Drupal\ymca_alters\Form\YmcaVariantPluginEditBlockForm');
    }
  }

}
