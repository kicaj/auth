<?php
namespace Auth\Controller\Component;

use Cake\Utility\Hash;
use Authentication\Authenticator\UnauthenticatedException;
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
                'action' => 'login',
            ]);
        }

        if (!$this->getConfig('loginRedirect')) {
            if ($this->getController()->getRequest()->getParam('prefix') == 'admin') {
                $this->setConfig('loginRedirect', [
                    'action' => 'dashboard',
                ]);
            } else {
                $this->setConfig('loginRedirect', '/');
            }
        }

        if (!$this->getConfig('logoutRedirect')) {
            $this->setConfig('logoutRedirect', [
                'action' => 'login',
            ]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function startup()
    {
        if (isset($this->getController()->auth) && !empty($auth = $this->getController()->auth)) {
            if ($identify = parent::getIdentity()) {
                if (!empty($userGroups = Hash::extract($identify->getOriginalData(), 'user_groups.{n}.group'))) {
                    $action = $this->getController()->getRequest()->getParam('action');

                    if (array_key_exists('*', $auth) && in_array($action, $auth['*'])) {
                        return;
                    }

                    foreach ($userGroups as $userGroup) {
                        if (isset($auth[$userGroup]) && in_array($action, $auth[$userGroup])) {
                            return;
                        }
                    }

                    throw new UnauthenticatedException();
                }
            }
        } else {
            return;
        }
    }
}
