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

namespace Nutshell\ContactElement\Content;

use Contao\Config;
use Contao\ContentElement;
use Contao\FilesModel;
use Contao\StringUtil;

class Contact extends ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_contact';

    /**
     * Generate the content element.
     */
    protected function compile(): void
    {
        // Clean the RTE output
        $this->text = StringUtil::toHtml5($this->text);

        // Add the static files URL to images
        if (TL_FILES_URL) {
            $path = Config::get('uploadPath').'/';

            $this->text = str_replace(' src="'.$path, ' src="'.TL_FILES_URL.$path, $this->text);
        }

        $this->Template->text = StringUtil::encodeEmail($this->text);
        $this->Template->addContactImage = false;

        // Add an image
        if ($this->addContactImage && $this->singleSRC) {
            $objModel = FilesModel::findByUuid($this->singleSRC);

            if (null !== $objModel && is_file(TL_ROOT.'/'.$objModel->path)) {
                $this->singleSRC = $objModel->path;
                $this->overwriteMeta = ($this->alt || $this->imageTitle || $this->caption);
                $this->addImageToTemplate($this->Template, $this->arrData, null, null, $objModel);
            }

            $this->Template->addContactImage = true;
        }

        // Encode contact email
        $this->Template->contactEmail = StringUtil::encodeEmail($this->contactEmail);

        // Add contact email link
        $this->Template->contactEmailLink = '&#109;&#97;&#105;&#108;&#116;&#111;&#58;'.StringUtil::encodeEmail($this->contactEmail);
    }
}
