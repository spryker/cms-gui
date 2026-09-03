/**
 * Copyright (c) 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

'use strict';

var CmsGlossaryAutocomplete = require('./cms-glossary-autocomplete');
require('../../sass/main.scss');
require('../../img/cms-loader.gif');

/**
 * Legacy jQuery datepicker setup, including the manual min/max bookkeeping that keeps the two ends
 * of the validity range consistent.
 *
 * @deprecated Superseded by `DatePickerType` and the Gui DateTimePicker, which handle range linking
 *   declaratively. Kept only for installations running spryker/gui older than 5.4.0.
 */
function initLegacyValidityPickers(validFrom, validTo) {
    validFrom.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        numberOfMonths: 3,
        maxDate: validTo.val(),
        defaultData: 0,
        onClose: function (selectedDate) {
            validTo.datepicker('option', 'minDate', selectedDate);
        },
    });

    validTo.datepicker({
        defaultData: 0,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        numberOfMonths: 3,
        minDate: validFrom.val(),
        onClose: function (selectedDate) {
            validFrom.datepicker('option', 'maxDate', selectedDate);
        },
    });
}

$(document).ready(function () {
    var validFrom = $('#cms_page_validFrom');
    var validTo = $('#cms_page_validTo');

    // From spryker/gui 5.4.0 on, these fields are built with `DatePickerType`, which marks them
    // with `data-spryker-picker` and lets the Gui DateTimePicker initialize and range-link them.
    // Older Gui versions have no such type, so the legacy picker below is set up instead.
    if (!validFrom.is('[data-spryker-picker]')) {
        initLegacyValidityPickers(validFrom, validTo);
    }

    $("input[id$='translationKey']").each(function (index, element) {
        new CmsGlossaryAutocomplete({
            autocompleteElement: $(element),
        });
    });

    var originalText = $('#version-diff .has-original .original');
    originalText.each(function (index, element) {
        var targets = $('#version-diff .has-diff .original');
        if (typeof targets[index] !== 'undefined') {
            var targetsDiff = $('#version-diff .has-diff .diff');
            targets[index].innerText = element.innerText;

            if (element.innerText !== targetsDiff[index].innerText) {
                $(targetsDiff[index]).css('background-color', '#fbd6c4');
            }
        }
    });

    $('[name=cms_glossary]').on('submit', function () {
        var self = $(this);

        self.find('.html-editor').each(function (index, element) {
            var editor = $(element);
            if (editor.summernote('codeview.isActivated')) {
                editor.summernote('codeview.deactivate');
            }

            if (editor.summernote('isEmpty')) {
                editor.val(null);
            }
        });
    });
});
