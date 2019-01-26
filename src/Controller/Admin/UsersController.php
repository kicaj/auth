<?php
namespace Auth\Controller\Admin;

use Cake\Event\Event;
use Cake\Utility\Text;
use Auth\Controller\AppController;
use Auth\Exception\UserNotFoundException;

class UsersController extends AppController
{

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['index', 'login', 'add', 'edit', 'delete', 'view']);
    }

    /**
     * Login User
     */
    public function login()
    {
        $user = $this->Authentication->getResult();

        // Regardless of POST or GET, redirect if User is logged in.
        if ($user->isValid()) {
            return $this->redirect($this->request->getQuery('redirect', [
                'controller' => 'Pages',
                'action' => 'display',
                'home',
            ]));
        }

        // Display error if User submitted and authentication failed.
        if ($this->request->is(['post']) && !$user->isValid()) {
            $this->Flash->error(__d('auth', 'Invalid username or password.'));
        }

        $this->set(compact('user'));
    }

    /**
     * Register User
     */
    public function register()
    {

    }

    /**
     * Forgotten password
     */
    public function forgot()
    {

    }

    /**
     * Users
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View User
     *
     * @param string|null $id User identifier.
     */
    public function view($id = null)
    {
        $user = $this->Users->find()->select([
            'Users.' . $this->Users->getPrimaryKey(),
            'Users.email',
            'Users.created',
            'Users.modified',
        ])->where([
            'Users.' . $this->Users->getPrimaryKey() => $id,
        ]);

        if (!$user->isEmpty()) {
            $user = $user->first();

            $this->set(compact('user'));
        } else {
            throw new UserNotFoundException(__d('auth', 'The user does not exist.'));
        }
    }

    /**
     * Add User
     */
    public function add()
    {
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $user->uuid = Text::uuid();

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__d('auth', 'The user has been saved.'));

                return $this->redirect([
                    'action' => 'index',
                ]);
            }

            $this->Flash->error(__d('auth', 'The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));
    }

    /**
     * Edit User
     *
     * @param string|null $id User identifier.
     */
    public function edit($id = null)
    {
        $user = $this->Users->find()->select([
            'Users.' . $this->Users->getPrimaryKey(),
            'Users.email',
        ])->where([
            'Users.' . $this->Users->getPrimaryKey() => $id,
        ]);

        if (!$user->isEmpty()) {
            $user = $user->first();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());

                if ($this->Users->save($user)) {
                    $this->Flash->success(__d('auth', 'The user has been saved.'));

                    return $this->redirect([
                        'action' => 'index',
                    ]);
                }

                $this->Flash->error(__d('auth', 'The user could not be saved. Please, try again.'));
            }

            $this->set(compact('user'));
        } else {
            throw new UserNotFoundException(__d('auth', 'The user does not exist.'));
        }
    }

    /**
     * Delete User
     *
     * @param string|null $id User identifier.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->find()->select([
            'Users.' . $this->Users->getPrimaryKey(),
        ])->where([
            'Users.' . $this->Users->getPrimaryKey() => $id,
        ]);

        if (!$user->isEmpty()) {
            $user = $user->first();

            if ($this->Users->delete($user)) {
                $this->Flash->success(__d('auth', 'The user has been deleted.'));
            } else {
                $this->Flash->error(__d('auth', 'The user could not be deleted. Please, try again.'));
            }

            return $this->redirect([
                'action' => 'index',
            ]);
        } else {
            throw new UserNotFoundException(__d('auth', 'The user does not exist.'));
        }
    }
}
