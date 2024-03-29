<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsGui;

use Codeception\Actor;
use Spryker\Zed\CmsGui\CmsGuiDependencyProvider;
use Spryker\Zed\Store\Communication\Plugin\Form\StoreRelationToggleFormTypePlugin;

/**
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(\SprykerTest\Zed\CmsGui\PHPMD)
 */
class CmsGuiCommunicationTester extends Actor
{
    use _generated\CmsGuiCommunicationTesterActions;

    /**
     * @return void
     */
    public function registerCmsBlockStoreRelationFormTypePlugin(): void
    {
        $this->setDependency(CmsGuiDependencyProvider::PLUGIN_STORE_RELATION_FORM_TYPE, function () {
            return new StoreRelationToggleFormTypePlugin();
        });
    }
}
