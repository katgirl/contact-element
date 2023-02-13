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
use Contao\Validator;
use Contao\System;

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

        // Add the static files URL to images
        if ($staticUrl = System::getContainer()->get('contao.assets.files_context')->getStaticUrl()) {
            $path = Config::get('uploadPath') . '/';
        }

        $this->Template->text = StringUtil::encodeEmail($this->text);
        $this->Template->addContactImage = false;

        // Add an image
        if ($this->addContactImage && $this->singleSRC) {
            $objModel = FilesModel::findByUuid($this->singleSRC);

            if ($objModel !== null && is_file(System::getContainer()->getParameter('kernel.project_dir') . '/' . $objModel->path)) {
                $this->singleSRC = $objModel->path;
                $this->overwriteMeta = ($this->alt || $this->imageTitle || $this->caption);

                $figure = System::getContainer()
                ->get('contao.image.studio')
                ->createFigureBuilder()
                ->from($objModel->path)
                ->setSize($this->heroSize)
                ->setMetadata($this->objModel->getOverwriteMetadata())
                ->enableLightbox((bool) $this->fullsize)
                ->buildIfResourceExists();

                if (null !== $figure)
                {
                    $figure->applyLegacyTemplateData($this->Template, $this->imagemargin, $this->floating);
                }
            }

            $this->Template->addContactImage = true;
        }

        // Encode contact email
        $this->Template->contactEmail = StringUtil::encodeEmail($this->contactEmail);

        // Add contact email link
        $this->Template->contactEmailLink = '&#109;&#97;&#105;&#108;&#116;&#111;&#58;'.StringUtil::encodeEmail($this->contactEmail);
    }
}
