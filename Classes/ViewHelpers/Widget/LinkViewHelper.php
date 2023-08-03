<?php
declare(strict_types=1);
namespace Helhum\TyposcriptRendering\ViewHelpers\Widget;

/*
 * This file is part of the TypoScript Rendering TYPO3 extension.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read
 * LICENSE file that was distributed with this source code.
 *
 */

use Helhum\TyposcriptRendering\Uri\TyposcriptRenderingUri;
use Helhum\TyposcriptRendering\Uri\ViewHelperContext;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception as FluidViewHelperException;

class LinkViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Initialize arguments
     *
     * @return void
     *
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
        $this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
        $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
        $this->registerArgument('addQueryStringMethod', 'string', 'Method to be used for query string');
        $this->registerArgument('action', 'string', 'Target action');
        $this->registerArgument('arguments', 'array', 'Arguments', false, []);
        $this->registerArgument('section', 'string', 'The anchor to be added to the URI', false, '');
        $this->registerArgument('format', 'string', 'The requested format, e.g. ".html', false, '');

        $this->registerArgument('extensionName', 'string', 'Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used');
        $this->registerArgument('pluginName', 'string', 'Target plugin. If empty, the current plugin name is used');
        $this->registerArgument('contextRecord', 'string', 'The record that the rendering should depend upon. e.g. current (default: record is fetched from current Extbase plugin), tt_content:12 (tt_content record with uid 12), pages:15 (pages record with uid 15), \'currentPage\' record of current page', false, 'current');
        $this->registerArgument('argumentsToBeExcludedFromQueryString', 'array', 'arguments to be removed from the URI. Only active if $addQueryString = TRUE', false, []);
    }

    /**
     * Render the link.
     *
     * @return string The rendered link
     */
    public function render()
    {
        $arguments = $this->arguments;

        if (! $this->renderingContext instanceof RenderingContext) {
            throw new FluidViewHelperException(
                'Something went wrong; RenderingContext should be available in ViewHelper',
                1638341671
            );
        }

        $uri = (new TyposcriptRenderingUri())->withWidgetContext(
            new ViewHelperContext(
                $this->renderingContext->getRequest(),
                $arguments
            )
        );

        $this->tag->addAttribute('href', (string)$uri);
        $this->tag->setContent($this->renderChildren());

        return $this->tag->render();
    }
}
