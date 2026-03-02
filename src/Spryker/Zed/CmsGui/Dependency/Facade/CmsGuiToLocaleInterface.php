<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsGui\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface CmsGuiToLocaleInterface
{
    /**
     * @return array<\Generated\Shared\Transfer\LocaleTransfer>
     */
    public function getLocaleCollection(): array;

    public function getCurrentLocale(): LocaleTransfer;
}
