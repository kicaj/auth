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

        if (!property_exists($this->getController(), 'Flash')) {
            $this->getController()->loadComponent('Flash');
        }

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

        if (!$this->getConfig('authError')) {
            $this->setConfig('authError', __d('auth', 'Access denied!'));
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

            // Allow for Superadministrator
            if (!empty($userGroups) && in_array('admin', $userGroups)) {
                return;
            }

            // Check permissions
            if (property_exists($this->getController(), 'auth') && !empty($auth = $this->getController()->auth)) {
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

        $this->getController()->Flash->error($this->getConfig('authError'));

        return $this->getController()->redirect($this->getConfig('loginRedirect'));
    }
}
