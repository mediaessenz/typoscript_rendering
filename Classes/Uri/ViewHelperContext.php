<?php
declare(strict_types=1);
namespace Helhum\TyposcriptRendering\Uri;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class ViewHelperContext
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    public function __construct(RequestInterface $request, array $arguments, ConfigurationManager $configurationManager = null)
    {
        $this->request = $request;
        $this->arguments = $arguments;
        $this->configurationManager = $configurationManager;
    }

    /**
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getContentObject(): ContentObjectRenderer
    {
        $configurationManager = $this->configurationManager ?? GeneralUtility::makeInstance(ConfigurationManager::class);

        return $configurationManager->getContentObject() ?? GeneralUtility::makeInstance(ContentObjectRenderer::class);
    }
}
