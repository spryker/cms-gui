<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsGui\Communication\Form\Page;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @method \Spryker\Zed\CmsGui\Communication\CmsGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CmsGui\CmsGuiConfig getConfig()
 */
class CmsPageMetaAttributesFormType extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_META_TITLE = 'metaTitle';

    /**
     * @var string
     */
    public const FIELD_META_KEYWORDS = 'metaKeywords';

    /**
     * @var string
     */
    public const FIELD_META_DESCRIPTION = 'metaDescription';

    /**
     * @var string
     */
    public const FIELD_LOCALE_NAME = 'localeName';

    /**
     * @var string
     */
    public const FIELD_ID_CMS_PAGE_LOCALIZED_ATTRIBUTES = 'idCmsPageLocalizedAttributes';

    /**
     * @var int
     */
    protected const MAX_LENGTH_META_TITLE = 255;

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addMetaTitleField($builder)
            ->addIdCmsLocalizedAttributes($builder)
            ->addMetaKeywordsField($builder)
            ->addMetaDescriptionField($builder)
            ->addFieldLocalName($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMetaTitleField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_META_TITLE, TextType::class, [
            'label' => 'Meta Title',
            'required' => false,
            'constraints' => [
                new Length([
                    'max' => static::MAX_LENGTH_META_TITLE,
                ]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMetaKeywordsField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_META_KEYWORDS, TextType::class, [
            'label' => 'Meta Keywords',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMetaDescriptionField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_META_DESCRIPTION, TextType::class, [
            'label' => 'Meta Description',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFieldLocalName(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LOCALE_NAME, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdCmsLocalizedAttributes(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_CMS_PAGE_LOCALIZED_ATTRIBUTES, HiddenType::class);

        return $this;
    }
}
