<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

// Authentication
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Routing\Router;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
public function bootstrap(): void
{
    parent::bootstrap();

    if (PHP_SAPI !== 'cli') {
        FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
    }

    // Cargar plugins
    $this->addPlugin('Authentication');

    // ⚠️ DebugKit solo en local
    if (Configure::read('debug') && env('RAILWAY_ENVIRONMENT', 'production') !== 'production') {
        $this->addPlugin('DebugKit');
    }
}


    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthenticationMiddleware($this)) // 👈 Importante
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));

        return $middlewareQueue;
    }

    public function services(ContainerInterface $container): void
    {
    }

public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
{
    $service = new AuthenticationService();

    // Si no está autenticado, redirigir al login
    $service->setConfig([
        'unauthenticatedRedirect' => Router::url(['controller' => 'Users', 'action' => 'login']),
        'queryParam' => 'redirect',
    ]);

    // Identificador: email + password
    $service->loadIdentifier('Authentication.Password', [
        'fields' => [
            'username' => 'email',
            'password' => 'password',
        ],
    ]);

    // Autenticadores
    $service->loadAuthenticator('Authentication.Session');
    $service->loadAuthenticator('Authentication.Form', [
        'fields' => [
            'username' => 'email',
            'password' => 'password',
        ],
        'loginUrl' => Router::url(['controller' => 'Users', 'action' => 'login']),
    ]);

    return $service;
}

}