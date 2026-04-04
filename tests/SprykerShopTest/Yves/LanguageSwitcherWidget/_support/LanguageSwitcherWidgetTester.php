<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShopTest\Yves\LanguageSwitcherWidget;

use Codeception\Actor;
use Codeception\Stub;
use SprykerShop\Yves\LanguageSwitcherWidget\Dependency\Client\LanguageSwitcherWidgetToLocaleClientInterface;
use SprykerShop\Yves\LanguageSwitcherWidget\Dependency\Client\LanguageSwitcherWidgetToUrlStorageClientInterface;
use SprykerShop\Yves\LanguageSwitcherWidget\LanguageSwitcherWidgetDependencyProvider;
use SprykerShop\Yves\LanguageSwitcherWidget\Widget\LanguageSwitcherWidget;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

/**
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(\SprykerShopTest\Yves\LanguageSwitcherWidget\PHPMD)
 */
class LanguageSwitcherWidgetTester extends Actor
{
    use _generated\LanguageSwitcherWidgetTesterActions;

    /**
     * @var string
     */
    public const TEST_ROUTE = 'test_route';

    /**
     * @var string
     */
    public const TEST_ROUTE_WITH_PARAMS = 'test_route?param=10';

    /**
     * @var string
     */
    public const HOME_PATH = '/en/home';

    /**
     * @var string
     */
    public const TEST_QUERY_STRING = 'test=1';

    /**
     * @var string
     */
    public const TEST_QUERY_STRING_2 = 'param2=5';

    /**
     * @var string
     */
    public const ROOT_PATH = '/';

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    public Request $request;

    public function createRequestUri(string $pathInfo, ?string $queryString = null): string
    {
        if ($queryString) {
            return sprintf('%s?%s', $pathInfo, $queryString);
        }

        return $pathInfo;
    }

    public function setupContainer(): void
    {
        $container = $this->getContainer();
        $container->set('request_stack', new RequestStack());
        $container->get('request_stack')->push($this->request);

        $requestContext = new RequestContext();
        $routerMock = Stub::makeEmpty(RouterInterface::class, [
            'generate' => function ($route, $parameters = []) {
                return $route . http_build_query($parameters);
            },
            'getContext' => $requestContext,
        ]);
        $container->set('routers', $routerMock);

        $localeClientMock = Stub::makeEmpty(LanguageSwitcherWidgetToLocaleClientInterface::class, [
            'getLocales' => ['en' => 'en_US'],
            'getCurrentLanguage' => 'en',
        ]);
        $this->setDependency(LanguageSwitcherWidgetDependencyProvider::CLIENT_LOCALE, $localeClientMock);

        $urlStorageClientMock = Stub::makeEmpty(LanguageSwitcherWidgetToUrlStorageClientInterface::class, [
            'findUrlStorageTransferByUrl' => null,
        ]);
        $this->setDependency(LanguageSwitcherWidgetDependencyProvider::CLIENT_URL_STORAGE, $urlStorageClientMock);
    }

    public function setRequestAttributes(): void
    {
        $this->request = new Request();
        $this->request->attributes->set('_route', static::TEST_ROUTE);
        $this->request->attributes->set('_route_params', []);
    }

    public function createLanguageSwitcherWidget(string $pathInfo, ?string $queryString, string $requestUri): LanguageSwitcherWidget
    {
        $this->request->attributes->set('pathinfo', $pathInfo);

        return new LanguageSwitcherWidget($pathInfo, $queryString, $requestUri);
    }
}
