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

        $this->Authentication->allowUnauthenticated(['login', 'forgot', 'register']);
    }

    /**
     * Login User
     */
    public function login()
    {
        $auth = $this->Authentication->getResult();

        if ($auth->isValid()) {
            return $this->redirect($this->request->getQuery('redirect', $this->Authentication->getConfig('loginRedirect')));
        }

        if ($this->request->is(['post']) && !$auth->isValid()) {
            $this->Flash->error(__d('auth', 'Invalid username or password.'));
        }

        $user = $this->Users;

        $this->set(compact('user'));
    }

    /**
     * Logout User
     */
    public function logout()
    {
        $auth = $this->Authentication->getResult();

        if ($auth->isValid()) {
            $this->Authentication->logout();

            $this->Flash->success(__d('auth', 'Successfully logged out.'));

            return $this->redirect($this->Authentication->getConfig('logoutRedirect'));
        } else {
            $this->redirect($this->referer());
        }
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
        $auth = $this->Authentication->getResult();

        if (!$auth->isValid()) {
            if ($this->request->is('post')) {
                $user = $this->Users->find()->select([
                    'Users.' . $this->Users->getPrimaryKey(),
                    'Users.email',
                    'Users.uuid',
                ])->where([
                    'Users.email' => $this->request->getData('email'),
                ])->first();

                if (!empty($user)) {
                    if (!$user->uuid) {
                        $user->uuid = Text::uuid();
                    }

                    $user = $this->Users->patchEntity($user, $this->request->getData());

                    if ($this->Users->save($user)) {
                        if (!$this->_sendEmail($user->email, __d('auth', 'Odzyskaj dostęp'), 'Auth.forgot', compact('user'))) {
                            $this->Flash->error(__d('auth', 'Wystapił problem z wysłaniem wiadomości.'));
                        }
                    } else {
                        $this->Flash->error(__d('auth', 'Wystapił problem z zapisem danych.'));
                    }
                } else {
                    $this->Flash->error(__d('auth', 'Podany adres e-mail nie został znaleziony.'));
                }

                $this->set(compact('user'));
            }
        } else {
            return $this->redirect('/');
        }
    }

    public function dashboard()
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
