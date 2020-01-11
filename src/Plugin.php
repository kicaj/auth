<?php
namespace Auth;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Http\MiddlewareQueue;
use Psr\Http\Message\ServerRequestInterface;

class Plugin extends BasePlugin implements AuthenticationServiceProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new AuthenticationMiddleware($this));

        return $middlewareQueue;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
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
