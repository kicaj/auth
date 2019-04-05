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
        }

        throw new UnauthenticatedException();
    }
}
