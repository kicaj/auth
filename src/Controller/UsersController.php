<?php
namespace Auth\Controller;

use Cake\Event\EventInterface;
use Auth\Controller\Admin\UsersController as AppController;

class UsersController extends AppController
{

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(EventInterface $event)
    {
        $this->Authentication->allowUnauthenticated([
            'login',
            'forgot',
            'forgotActivation',
        ]);
    }
}
