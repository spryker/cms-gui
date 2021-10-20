<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsGui\Communication\Controller;

use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Cms\Business\Exception\CannotActivatePageException;
use Spryker\Zed\Cms\Business\Exception\TemplateFileNotFoundException;
use Spryker\Zed\CmsGui\Communication\Form\Page\CmsPageFormType;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\CmsGui\Communication\CmsGuiCommunicationFactory getFactory()
 */
class EditPageController extends AbstractController
{
    /**
     * @var string
     */
    public const URL_PARAM_ID_CMS_PAGE = 'id-cms-page';

    /**
     * @var string
     */
    public const URL_PARAM_REDIRECT_URL = 'redirect-url';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_INVALID_DATA_PROVIDED = 'Invalid data provided.';

    /**
     * @var string
     */
    public const MESSAGE_TEMPLATE_SELECT_ERROR = 'Selected template doesn\'t exist anymore.';

    /**
     * @var string
     */
    public const MESSAGE_PAGE_UPDATE_SUCCESS = 'Page was updated successfully.';

    /**
     * @var string
     */
    public const MESSAGE_PAGE_ACTIVATION_SUCCESS = 'Page was activated successfully.';

    /**
     * @var string
     */
    public const MESSAGE_PAGE_DEACTIVATION_SUCCESS = 'Page was deactivated successfully.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $this->getFactory()
            ->getCmsFacade()
            ->syncTemplate(
                $this->getCmsFolderPath(),
            );

        $idCmsPage = $this->castId($request->query->get(static::URL_PARAM_ID_CMS_PAGE));

        $cmsPageFormTypeDataProvider = $this->getFactory()
            ->createCmsPageFormTypeDataProvider();

        $cmsPageTransfer = $cmsPageFormTypeDataProvider->getData($idCmsPage);

        if ($cmsPageTransfer === null) {
            $this->addErrorMessage("'Cms page with id %s doesn't exist'", ['%s' => $idCmsPage]);

            return $this->redirectResponse($this->getFactory()->getConfig()->getDefaultRedirectUrl());
        }

        $pageForm = $this->getFactory()
            ->createCmsPageForm($cmsPageFormTypeDataProvider, $idCmsPage, $cmsPageTransfer)
            ->handleRequest($request);

        if ($pageForm->isSubmitted()) {
            $isUpdated = $this->updateCmsPage($pageForm);

            if ($isUpdated) {
                $redirectUrl = $this->createEditPageUrl($idCmsPage);

                return $this->redirectResponse($redirectUrl);
            }
        }

        $availableLocales = $this->getFactory()
            ->getLocaleFacade()
            ->getLocaleCollection();

        $cmsVersion = $this->getFactory()
            ->getCmsFacade()
            ->findLatestCmsVersionByIdCmsPage($idCmsPage);

        $cmsPageTransfer = $this->getFactory()
            ->getCmsFacade()
            ->findCmsPageById($idCmsPage);

        $pageTabs = $this->getFactory()->createPageTabs();

        return [
            'pageTabs' => $pageTabs->createView(),
            'pageForm' => $pageForm->createView(),
            'availableLocales' => $availableLocales,
            'idCmsPage' => $idCmsPage,
            'cmsVersion' => $cmsVersion,
            'cmsPage' => $cmsPageTransfer,
            'isPageTemplateWithPlaceholders' => $this->isPageTemplateWithPlaceholders($idCmsPage),
            'publishForm' => $this->getFactory()->createPublishVersionPageForm()->createView(),
            'toggleActiveForm' => $this->getFactory()->createToggleActivateCmsPageForm()->createView(),
        ];
    }

    /**
     * @param int $idCmsPage
     *
     * @return bool
     */
    protected function isPageTemplateWithPlaceholders(int $idCmsPage): bool
    {
        $cmsGlossaryTransfer = $this->getFactory()->getCmsFacade()->findPageGlossaryAttributes($idCmsPage);

        if (!$cmsGlossaryTransfer) {
            return false;
        }

        return $cmsGlossaryTransfer->getGlossaryAttributes()->count() > 0;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $pageForm
     *
     * @return bool
     */
    protected function updateCmsPage($pageForm)
    {
        if ($pageForm->isSubmitted() && $pageForm->isValid()) {
            try {
                $this->getFactory()
                    ->getCmsFacade()
                    ->updatePage($pageForm->getData());

                $this->addSuccessMessage(static::MESSAGE_PAGE_UPDATE_SUCCESS);

                return true;
            } catch (TemplateFileNotFoundException $exception) {
                $error = $this->createTemplateErrorForm();
                $pageForm->get(CmsPageFormType::FIELD_FK_TEMPLATE)->addError($error);
            }
        }

        $this->addErrorMessage(static::ERROR_MESSAGE_INVALID_DATA_PROVIDED);

        return false;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activateAction(Request $request)
    {
        $idCmsPage = $this->castId($request->query->get(static::URL_PARAM_ID_CMS_PAGE));
        $redirectUrl = $request->get(static::URL_PARAM_REDIRECT_URL);

        $form = $this->getFactory()->createToggleActivateCmsPageForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid.');

            return $this->redirectResponseExternal($redirectUrl);
        }

        try {
            $this->getFactory()
                ->getCmsFacade()
                ->activatePage($idCmsPage);

            $this->addSuccessMessage(static::MESSAGE_PAGE_ACTIVATION_SUCCESS);
        } catch (CannotActivatePageException $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectResponse($redirectUrl);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deactivateAction(Request $request)
    {
        $idCmsPage = $this->castId($request->query->get(static::URL_PARAM_ID_CMS_PAGE));
        $redirectUrl = $request->get(static::URL_PARAM_REDIRECT_URL);

        $form = $this->getFactory()->createToggleActivateCmsPageForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid.');

            return $this->redirectResponseExternal($redirectUrl);
        }

        $this->getFactory()
            ->getCmsFacade()
            ->deactivatePage($idCmsPage);

        $this->addSuccessMessage(static::MESSAGE_PAGE_DEACTIVATION_SUCCESS);

        return $this->redirectResponse($redirectUrl);
    }

    /**
     * @param int $idCmsPage
     *
     * @return string
     */
    protected function createEditPageUrl($idCmsPage)
    {
        return Url::generate(
            '/cms-gui/edit-page/index',
            [static::URL_PARAM_ID_CMS_PAGE => $idCmsPage],
        )->build();
    }

    /**
     * @return \Symfony\Component\Form\FormError
     */
    protected function createTemplateErrorForm()
    {
        return new FormError(static::MESSAGE_TEMPLATE_SELECT_ERROR);
    }

    /**
     * @return string
     */
    protected function getCmsFolderPath(): string
    {
        return $this->getFactory()
            ->getConfig()
            ->getCmsFolderPath();
    }
}
