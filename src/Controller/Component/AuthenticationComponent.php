<?php
namespace Auth\Controller\Component;

use Cake\Utility\Hash;
use Authentication\Controller\Component\AuthenticationComponent as BaseAuthentication;

class AuthenticationComponent extends BaseAuthentication
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        if (!$this->getConfig('loginAction')) {
            $this->setConfig('loginAction', [
                'plugin' => 'Auth',
                'controller' => 'Users',
                'action' => 'login',
            ]);
        }

        if (!$this->getConfig('loginRedirect')) {
            if ($this->getController()->getRequest()->getParam('prefix') == 'admin') {
                $this->setConfig('loginRedirect', [
                    'plugin' => 'Auth',
                    'controller' => 'Users',
                    'action' => 'dashboard',
                ]);
            } else {
                $this->setConfig('loginRedirect', '/');
            }
        }

        if (!$this->getConfig('logoutRedirect')) {
            $this->setConfig('logoutRedirect', [
                'plugin' => 'Auth',
                'controller' => 'Users',
                'action' => 'login',
            ]);
        }

        $this->getController()->viewBuilder()->setHelpers([
            'Authentication.Identity',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function startup(): void
    {
        $controller = $this->getController();
        $action = $controller->getRequest()->getParam('action');
        $prefix = $controller->getRequest()->getParam('prefix');

        // Authorization of methods that exist
        if ($controller->isAction($action)) {
            // Get global auth list
            if (isset($controller->authGlobal) && !empty($authGlobal = $controller->authGlobal)) {
                if (!empty($prefix)) {
                    if (isset($authGlobal[$prefix])) {
                        $authGlobal = $authGlobal[$prefix];
                    } else {
                        $authGlobal = [];
                    }
                }

                if (isset($authGlobal[$controller->getName()]['unauthenticatedActions']) && in_array($action, $authGlobal[$controller->getName()]['unauthenticatedActions'])) {
                    $this->addUnauthenticatedActions([$action]);
                }
            }

            // Allow for unauthenticated actions
            if (in_array($action, $this->unauthenticatedActions)) {
                return;
            }

            if ($identity = parent::getIdentity()) {
                $userGroups = Hash::extract($identity->getOriginalData(), 'user_groups.{n}.group');

                // Allow for Administrator
                if (in_array('admin', $userGroups)) {
                    return;
                }

                $auth = [];

                if (isset($controller->auth)) {
                    $auth = $controller->auth;
                } elseif (isset($authGlobal[$controller->getName()])) {
                    $auth = $authGlobal[$controller->getName()];
                }

                // Check permissions
                if (!empty($auth)) {
                    if (array_key_exists('*', $auth) && (in_array($action, $auth['*']) || in_array('*', $auth['*']))) {
                        return;
                    }

                    foreach ($userGroups as $userGroup) {
                        if (isset($auth[$userGroup])) {
                            if (in_array('*', $auth[$userGroup])) {
                                return;
                            }

                            if (in_array($action, $auth[$userGroup])) {
                                return;
                            }
                        }
                    }
                }

                $controller->Flash->auth(__d('auth', 'You do not have permission to view the content you’re looking for, so you have been redirected here.'));

                $controller->redirect('/');
            }

            $controller->Flash->auth(__d('auth', 'Authentication is required.'));

            $controller->redirect(array_merge($this->getConfig('loginAction'), [
                '?' => [
                    'redirect' => urldecode($controller->getRequest()->getRequestTarget()),
                ],
            ]));
        }
    }
}
