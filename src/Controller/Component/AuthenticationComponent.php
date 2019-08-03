<?php
namespace Auth\Controller\Component;

use Cake\Utility\Hash;
use Authentication\Controller\Component\AuthenticationComponent as BaseAuthentication;

class AuthenticationComponent extends BaseAuthentication
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
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
    public function startup()
    {
        $action = $this->getController()->getRequest()->getParam('action');

        // Authorization of methods that exist
        if ($this->getController()->isAction($action)) {
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

                // Check permissions
                if (isset($this->getController()->auth) && !empty($auth = $this->getController()->auth)) {
                    if (array_key_exists('*', $auth) && in_array($action, $auth['*'])) {
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

                $this->getController()->Flash->auth(__d('auth', 'You do not have permission to view the content you’re looking for, so you have been redirected here.'));

                return $this->getController()->redirect('/');
            }

            $this->getController()->Flash->auth(__d('auth', 'Authentication is required.'));

            return $this->getController()->redirect($this->getConfig('loginAction'));
        }
    }
}
