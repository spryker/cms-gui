<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsGui\Communication\Form;

use Codeception\Test\Unit;
use Spryker\Zed\Gui\Communication\Form\Type\RichTextEditorType;
use SprykerTest\Zed\CmsGui\Stub\CmsGlossaryTranslationFormTypeRichTextFieldStub;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group CmsGui
 * @group Communication
 * @group Form
 * @group CmsGlossaryTranslationFormTypeTest
 * Add your own group annotations below this line
 */
class CmsGlossaryTranslationFormTypeTest extends Unit
{
    protected const array FIELD_OPTIONS = ['label' => 'Content', 'required' => false];

    public function testFieldUsesTheGuiRichTextEditorTypeWhenGuiProvidesIt(): void
    {
        // Act
        $fieldType = $this->createFormType(true)->getFieldType();

        // Assert
        $this->assertSame(RichTextEditorType::class, $fieldType);
    }

    public function testFieldOptionsConfigureTheRichTextEditorWhenGuiProvidesIt(): void
    {
        // Act
        $fieldOptions = $this->createFormType(true)->getFieldOptions(static::FIELD_OPTIONS);

        // Assert
        $this->assertSame(static::FIELD_OPTIONS + ['editor_config' => 'cms'], $fieldOptions);
    }

    public function testFieldFallsBackToTheSummernoteTextareaWithAnOlderGui(): void
    {
        // Arrange
        $formType = $this->createFormType(false);

        // Act
        $fieldType = $formType->getFieldType();
        $fieldOptions = $formType->getFieldOptions(static::FIELD_OPTIONS);

        // Assert
        $this->assertSame(TextareaType::class, $fieldType);
        $this->assertSame(static::FIELD_OPTIONS + ['attr' => ['class' => 'html-editor', 'data-editor-config' => 'cms']], $fieldOptions);
    }

    public function testFieldUsesTheGuiRichTextEditorTypeWithTheInstalledGui(): void
    {
        // Act
        $fieldType = $this->createFormType(null)->getFieldType();

        // Assert
        $this->assertSame(RichTextEditorType::class, $fieldType);
    }

    protected function createFormType(?bool $isGuiRichTextEditorTypeAvailable): CmsGlossaryTranslationFormTypeRichTextFieldStub
    {
        return new CmsGlossaryTranslationFormTypeRichTextFieldStub($isGuiRichTextEditorTypeAvailable);
    }
}
