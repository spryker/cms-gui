<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsGui\Dependency\Facade;

use Generated\Shared\Transfer\CmsGlossaryTransfer;
use Generated\Shared\Transfer\CmsPageAttributesTransfer;
use Generated\Shared\Transfer\CmsPageTransfer;
use Generated\Shared\Transfer\CmsVersionDataTransfer;
use Generated\Shared\Transfer\CmsVersionTransfer;

class CmsGuiToCmsBridge implements CmsGuiToCmsInterface
{
    /**
     * @var \Spryker\Zed\Cms\Business\CmsFacadeInterface
     */
    protected $cmsFacade;

    /**
     * @param \Spryker\Zed\Cms\Business\CmsFacadeInterface $cmsFacade
     */
    public function __construct($cmsFacade)
    {
        $this->cmsFacade = $cmsFacade;
    }

    public function hasPagePlaceholderMapping(int $idPage, string $placeholder): bool
    {
        return $this->cmsFacade->hasPagePlaceholderMapping($idPage, $placeholder);
    }

    public function createPage(CmsPageTransfer $cmsPageTransfer): int
    {
        return $this->cmsFacade->createPage($cmsPageTransfer);
    }

    public function findPageGlossaryAttributes(int $idCmsPage): ?CmsGlossaryTransfer
    {
        return $this->cmsFacade->findPageGlossaryAttributes($idCmsPage);
    }

    public function saveCmsGlossary(CmsGlossaryTransfer $cmsGlossaryTransfer): CmsGlossaryTransfer
    {
        return $this->cmsFacade->saveCmsGlossary($cmsGlossaryTransfer);
    }

    public function findCmsPageById(int $idCmsPage): ?CmsPageTransfer
    {
        return $this->cmsFacade->findCmsPageById($idCmsPage);
    }

    public function updatePage(CmsPageTransfer $cmsPageTransfer): CmsPageTransfer
    {
        return $this->cmsFacade->updatePage($cmsPageTransfer);
    }

    public function activatePage(int $idCmsPage): void
    {
        $this->cmsFacade->activatePage($idCmsPage);
    }

    public function deactivatePage(int $idCmsPage): void
    {
        $this->cmsFacade->deactivatePage($idCmsPage);
    }

    public function getPageUrlPrefix(CmsPageAttributesTransfer $cmsPageAttributesTransfer): string
    {
        return $this->cmsFacade->getPageUrlPrefix($cmsPageAttributesTransfer);
    }

    public function buildPageUrl(CmsPageAttributesTransfer $cmsPageAttributesTransfer): string
    {
        return $this->cmsFacade->buildPageUrl($cmsPageAttributesTransfer);
    }

    public function publishWithVersion(int $idCmsPage, ?string $versionName = null): CmsVersionTransfer
    {
        return $this->cmsFacade->publishWithVersion($idCmsPage, $versionName);
    }

    public function rollback(int $idCmsPage, int $version): CmsVersionTransfer
    {
        return $this->cmsFacade->rollback($idCmsPage, $version);
    }

    public function revert(int $idCmsPage): void
    {
        $this->cmsFacade->revert($idCmsPage);
    }

    public function findLatestCmsVersionByIdCmsPage(int $idCmsPage): ?CmsVersionTransfer
    {
        return $this->cmsFacade->findLatestCmsVersionByIdCmsPage($idCmsPage);
    }

    /**
     * @param int $idCmsPage
     *
     * @return array<\Generated\Shared\Transfer\CmsVersionTransfer>
     */
    public function findAllCmsVersionByIdCmsPage(int $idCmsPage): array
    {
        return $this->cmsFacade->findAllCmsVersionByIdCmsPage($idCmsPage);
    }

    public function findCmsVersionByIdCmsPageAndVersion(int $idCmsPage, int $version): ?CmsVersionTransfer
    {
        return $this->cmsFacade->findCmsVersionByIdCmsPageAndVersion($idCmsPage, $version);
    }

    public function syncTemplate(string $cmsTemplateFolderPath): bool
    {
        return $this->cmsFacade->syncTemplate($cmsTemplateFolderPath);
    }

    public function getCmsVersionData(int $idCmsPage): CmsVersionDataTransfer
    {
        return $this->cmsFacade->getCmsVersionData($idCmsPage);
    }
}
