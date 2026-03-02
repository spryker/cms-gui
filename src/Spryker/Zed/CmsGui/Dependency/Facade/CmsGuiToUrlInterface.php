<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsGui\Dependency\Facade;

use Generated\Shared\Transfer\UrlTransfer;

interface CmsGuiToUrlInterface
{
    public function hasUrlCaseInsensitive(UrlTransfer $urlTransfer): bool;

    public function findUrlCaseInsensitive(UrlTransfer $urlTransfer): ?UrlTransfer;
}
