<?php
namespace Auth;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;

class Plugin extends BasePlugin implements AuthenticationServiceProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function getAuthenticationService(ServerRequestInterface $request, ResponseInterface $response)
    {
        $service = new AuthenticationService();

        $fields = [
            'username' => 'email',
            'password' => 'password',
        ];

        // Load identifiers.
        $service->loadIdentifier('Authentication.Password', compact('fields'));

        // Load the authenticators, you want session first.
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => '/users/login',
        ]);

        return $service;
    }

    /**
     * {@inheritDoc}
     */
    public function middleware($middleware)
    {
        $middleware
            ->add(new AuthenticationMiddleware($this, [
                //'unauthenticatedRedirect' => '/',
                //'queryParam' => 'redirect',
            ]));

        return $middleware;
    }

    /**
     * {@inheritDoc}
     */
    public function console($commands)
    {
        return $commands;
    }

    /**
     * {@inheritDoc}
     */
    public function bootstrap(PluginApplicationInterface $app)
    {
        parent::bootstrap($app);
    }

    /**
     * {@inheritDoc}
     */
    public function routes($routes)
    {
        parent::routes($routes);
    }
}
