<?php
namespace Auth\Controller\Admin;

use Cake\Event\EventInterface;
use Cake\Utility\Text;
use Cake\Mailer\MailerAwareTrait;
use Auth\Controller\AppController;
use Auth\Exception\UserNotFoundException;

class UsersController extends AppController
{

    use MailerAwareTrait;

    /**
     * Authorization.
     *
     * @var array
     */
    public $auth = [
        'admin' => [
            'index',
            'dashboard',
            'index',
            'add',
            'edit',
            'delete',
        ],
        '*' => [
            'logout',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
    }

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated([
            'login',
            'forgot',
            'forgotActivation',
        ]);
    }

    /**
     * Login User.
     */
    public function login()
    {
        $auth = $this->Authentication->getResult();

        if ($auth->isValid()) {
            return $this->redirect($this->request->getQuery('redirect', $this->Authentication->getConfig('loginRedirect')));
        }

        if ($this->request->is(['post']) && !$auth->isValid()) {
            $this->Flash->error(__d('auth', 'Invalid e-mail or password.'));
        }

        $user = $this->Users;

        $this->set(compact('user'));
    }

    /**
     * Logout User.
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
     * Forgotten password.
     */
    public function forgot()
    {
        $auth = $this->Authentication->getResult();

        if (!$auth->isValid()) {
            $user = $this->Users->newEmptyEntity();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->find()->select([
                    'Users.' . $this->Users->getPrimaryKey(),
                    'Users.email',
                    'Users.uuid',
                ])->where([
                    'Users.email' => $this->request->getData('email'),
                ]);

                if (!$user->isEmpty()) {
                    $user = $user->first();

                    if (!$user->uuid) {
                        $user->uuid = Text::uuid();
                    }

                    $user = $this->Users->patchEntity($user, $this->request->getData());

                    if ($this->Users->save($user)) {
                        $this->getMailer('Auth.User')->send('forgot', [$user]);

                        $this->Flash->success(__d('auth', 'The instruction has been sent.'));
                    } else {
                        $this->Flash->error(__d('auth', 'The form contains errors. Please, try again.'));
                    }
                } else {
                    $this->Flash->error(__d('auth', 'The e-mail address was not found.'));
                }
            }

            $this->set(compact('user'));
        } else {
            return $this->redirect($this->Authentication->getConfig('loginRedirect'));
        }
    }

    /**
     * Forgotten password activation.
     *
     * @param null|integer $uuid Unique hash.
     */
    public function forgotActivation($uuid = null)
    {
        $auth = $this->Authentication->getResult();

        if (!$auth->isValid()) {
            $user = $this->Users->find()->select([
                'Users.' . $this->Users->getPrimaryKey(),
            ])->where([
                'Users.uuid' => $uuid,
            ]);

            if (!$user->isEmpty()) {
                $user = $user->first();

                if ($this->request->is(['patch', 'post', 'put'])) {
                    $user = $this->Users->patchEntity($user, $this->request->getData(), [
                        'validate' => 'forgot',
                    ]);

                    $user->uuid = null;

                    if ($this->Users->save($user)) {
                        $this->Flash->success(__d('auth', 'New password has been saved. Please, try login now.'));

                        return $this->redirect($this->Authentication->getConfig('loginAction'));
                    } else {
                        $this->Flash->error(__d('auth', 'The form contains errors. Please, try again.'));
                    }
                }
            } else {
                $this->Flash->error(__d('auth', 'The link is expired or not active.'));

                return $this->redirect($this->Authentication->getConfig('loginAction'));
            }

            $this->set(compact('user'));
        } else {
            return $this->redirect($this->Authentication->getConfig('loginRedirect'));
        }
    }

    /**
     * Dashoboard.
     */
    public function dashboard()
    {

    }

    /**
     * Users.
     */
    public function index()
    {
        $users = $this->paginate($this->Users->find()->select([
            'Users.' . $this->Users->getPrimaryKey(),
            'Users.email',
            'Users.status',
            'Users.created',
            'Users.modified',
        ])->contain([
            'UserGroups' => function ($user_groups) {
                return $user_groups->select([
                    'UserGroups.name',
                ]);
            },
        ]), [
            'order' => [
                'Users.created' => 'DESC',
            ],
            'sortWhitelist' => [
                $this->Users->getPrimaryKey(),
                'email',
                'status',
                'created',
                'modified',
            ],
        ]);

        $this->set(compact('users'));
    }

    /**
     * View user.
     *
     * @param string|null $id User identifier.
     */
    public function view($id = null)
    {
        $user = $this->Users->find()->select([
            'Users.' . $this->Users->getPrimaryKey(),
            'Users.email',
            'Users.status',
            'Users.created',
            'Users.modified',
        ])->where([
            'Users.' . $this->Users->getPrimaryKey() => $id,
        ])->contain([
            'UserGroups' => function ($user_groups) {
                return $user_groups->select([
                    'UserGroups.name',
                ]);
            },
        ]);

        if (!$user->isEmpty()) {
            $user = $user->first();

            $this->set(compact('user'));
        } else {
            throw new UserNotFoundException();
        }
    }

    /**
     * Add user.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user->uuid = Text::uuid();

            $user = $this->Users->patchEntity($user, $this->request->getData(), [
                'associated' => [
                    'UserGroups',
                ],
            ]);

            if ($this->Users->save($user)) {
                $this->Flash->success(__d('auth', 'The user has been saved.'));

                return $this->redirect([
                    'action' => 'index',
                ]);
            }

            $this->Flash->error(__d('auth', 'The user could not be saved. Please, try again.'));
        }

        $userGroups = $this->Users->UserGroups->find('list');

        $this->set(compact('user', 'userGroups'));
    }

    /**
     * Edit user.
     *
     * @param string|null $id User identifier.
     */
    public function edit($id = null)
    {
        $user = $this->Users->find()->select([
            'Users.' . $this->Users->getPrimaryKey(),
            'Users.email',
            'Users.status',
        ])->where([
            'Users.' . $this->Users->getPrimaryKey() => $id,
        ])->contain([
            'UserGroups',
        ]);

        if (!$user->isEmpty()) {
            $user = $user->first();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData(), [
                    'associated' => [
                        'UserGroups',
                    ],
                ]);

                if ($this->Users->save($user)) {
                    $this->Flash->success(__d('auth', 'The user has been saved.'));

                    return $this->redirect([
                        'action' => 'index',
                    ]);
                }

                $this->Flash->error(__d('auth', 'The user could not be saved. Please, try again.'));
            }

            $userGroups = $this->Users->UserGroups->find('list');

            $this->set(compact('user', 'userGroups'));
        } else {
            throw new UserNotFoundException();
        }
    }

    /**
     * Delete user.
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
            'Users.' . $this->Users->getPrimaryKey() . ' !=' => $this->Authentication->getIdentityData('id'),
        ]);

        if (!$user->isEmpty()) {
            $user = $user->first();

            if ($this->Users->delete($user)) {
                $this->Flash->success(__d('auth', 'The user has been deleted.'));
            } else {
                $this->Flash->error(__d('auth', 'The user could not be deleted. Please, try again.'));
            }

            return $this->redirect($this->referer());
        } else {
            throw new UserNotFoundException(__d('auth', 'The user cannot be deleted.'));
        }
    }
}
