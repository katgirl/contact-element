<?php

declare(strict_types=1);

/*
 * Contact Element for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2021, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       http://github.com/nutshell-framework/contact-element
 */

/*
 * Palettes
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'addContactImage';

$GLOBALS['TL_DCA']['tl_content']['palettes']['contact'] =
    '{type_legend},type,headline;'
    .'{text_legend},contactName,contactPosition,contactEmail,contactPhone,contactDescription;'
    .'{image_legend},addContactImage;'
    .'{template_legend:hide},customTpl;'
    .'{protected_legend:hide},protected;'
    .'{expert_legend:hide},guests,cssID,space;'
    .'{invisible_legend:hide},invisible,start,stop';

/*
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['addContactImage'] = 'singleSRC,size,alt,imageTitle,caption';

/*
 * Fields
 */

// name
$GLOBALS['TL_DCA']['tl_content']['fields']['contactName'] = [
    'exclude' => true,
    'search' => true,
    'flag' => 1,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

// position
$GLOBALS['TL_DCA']['tl_content']['fields']['contactPosition'] = [
    'exclude' => true,
    'search' => true,
    'flag' => 1,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

// position
$GLOBALS['TL_DCA']['tl_content']['fields']['contactEmail'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'rgxp' => 'email',
        'decodeEntities' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['contactPhone'] = [
    'exclude' => true,
    'search' => true,
    'flag' => 1,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

// description
$GLOBALS['TL_DCA']['tl_content']['fields']['contactDescription'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => [
        'rte' => 'tinyMCE',
        'tl_class' => 'clr',
    ],
    'sql' => 'mediumtext NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['addContactImage'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['addContactImage'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
    ],
    'sql' => "char(1) NOT NULL default ''",
];
