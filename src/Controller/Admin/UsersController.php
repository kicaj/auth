<?php
namespace Auth\Controller\Admin;

use Auth\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Text;

class UsersController extends AppController
{

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['index', 'add', 'edit', 'delete']);
    }

    /**
     * Login
     */
    public function login()
    {
        $result = $this->Authentication->getResult();

        // Regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Pages',
                'action' => 'display',
                'home',
            ]);

            return $this->redirect($redirect);
        }

        // Display error if user submitted and authentication failed
        if ($this->request->is(['post']) && !$result->isValid()) {
            $this->Flash->error(__d('auth', 'Invalid username or password.'));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User identifier.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set(compact('user'));
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
                $this->Flash->success(__d('admin', 'The user has been saved.'));

                return $this->redirect([
                    'action' => 'index',
                ]);
            }

            $this->Flash->error(__d('admin', 'The user could not be saved. Please, try again.'));
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
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__d('admin', 'The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__d('admin', 'The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));
    }

    /**
     * Delete User
     *
     * @param string|null $id User identifier.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__d('admin', 'The user has been deleted.'));
        } else {
            $this->Flash->error(__d('admin', 'The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
