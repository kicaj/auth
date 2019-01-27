<?php
namespace Auth\Controller\Component;

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
}
