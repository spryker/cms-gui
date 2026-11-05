<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsGui\Stub;

use Spryker\Zed\CmsGui\Communication\Form\Glossary\CmsGlossaryTranslationFormType;

/**
 * Exposes the rich-text field type and options, with the Gui `RichTextEditorType` availability forced or,
 * with `null`, read from the real `class_exists()` check.
 */
class CmsGlossaryTranslationFormTypeRichTextFieldStub extends CmsGlossaryTranslationFormType
{
    public function __construct(protected ?bool $isGuiRichTextEditorTypeAvailableOverride)
    {
    }

    public function getFieldType(): string
    {
        return $this->getTranslationFieldType();
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    public function getFieldOptions(array $options): array
    {
        return $this->getTranslationFieldOptions($options);
    }

    protected function isGuiRichTextEditorTypeAvailable(): bool
    {
        return $this->isGuiRichTextEditorTypeAvailableOverride ?? parent::isGuiRichTextEditorTypeAvailable();
    }
}
