<?php
namespace Auth\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{

    /**
     * Forgotten password send link to generate new password
     *
     * @param mixed $user User data
     */
    public function forgot($user)
    {
        $this
            ->setTo($user->email)
            ->setSubject(__d('auth', 'Forgotten password'))
            ->setEmailFormat('html')
            ->setViewVars(compact('user'));

        if ($this->viewBuilder()->getTemplate() == __FUNCTION__) {
            $this->viewBuilder()->setTemplate('Auth.forgot');
        }
    }
}
