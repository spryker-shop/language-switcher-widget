<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\LanguageSwitcherWidget\Plugin\ShopUi;

use Spryker\Yves\Kernel\Widget\AbstractWidgetPlugin;
use SprykerShop\Yves\LanguageSwitcherWidget\Widget\LanguageSwitcherWidget;

/**
 * @deprecated Use {@link \SprykerShop\Yves\LanguageSwitcherWidget\Widget\LanguageSwitcherWidget} instead.
 */
class LanguageSwitcherWidgetPlugin extends AbstractWidgetPlugin
{
    /**
     * @var string
     */
    public const NAME = 'LanguageSwitcherWidgetPlugin';

    /**
     * {@inheritDoc}
     *
     * @param string $queryString
     */
    public function initialize(string $pathInfo, $queryString, string $requestUri): void
    {
        $widget = new LanguageSwitcherWidget($pathInfo, $queryString, $pathInfo);

        $this->parameters = $widget->getParameters();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public static function getName(): string
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public static function getTemplate(): string
    {
        return LanguageSwitcherWidget::getTemplate();
    }
}
