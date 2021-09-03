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

use Nutshell\ContactElement\Content\Contact;

/*
 * EuF Hero ContentElement
 */
array_insert(
    $GLOBALS['TL_CTE']['media'],
    4,
    [
        'contact' => Contact::class,
    ]
);
