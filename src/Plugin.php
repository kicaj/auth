<?php
namespace Auth;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
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
    public function middleware($middleware)
    {
        $middleware
            ->add(new AuthenticationMiddleware($this));

        return $middleware;
    }

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
        $service->loadIdentifier('Authentication.Password', [
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => Configure::read('Auth.userModel', 'Auth.Users'),
                'finder' => Configure::read('Auth.finder', 'auth'),
            ],
            'fields' => $fields,
        ]);

        // Load the authenticators, you want session first.
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
        ]);

        return $service;
    }
}
