<?php

namespace Drutiny\Acquia\Audit;

use Drutiny\Sandbox\Sandbox;
use Drutiny\Audit\AbstractAnalysis;
use Drutiny\Credential\Manager;
use Drutiny\Acquia\CloudApiDrushAdaptor;
use Drutiny\Acquia\CloudApiV2;

/**
 * Check to ensure Production Mode is enabled on Acquia Cloud.
 */
class EnvironmentAnalysis extends AbstractAnalysis {

  protected function requireCloudApiV2()
  {
    return Manager::load('acquia_api_v2');
  }

  /**
   * @inheritdoc
   */
  public function gather(Sandbox $sandbox) {

    $environment = CloudApiDrushAdaptor::getEnvironment($sandbox->getTarget());
    $app = CloudApiV2::get('applications/' . $environment['application']['uuid']);

    $sandbox->setParameter('environment', $environment);
    $sandbox->setParameter('app', $app);
  }

}
