<?php
namespace Auth\Controller;

use Cake\Event\Event;
use Auth\Controller\Admin\UsersController as AppController;

class UsersController extends AppController
{

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(Event $event)
    {
        $this->Authentication->allowUnauthenticated([
            'login',
            'forgot',
            'forgotActivation',
        ]);
    }
}
