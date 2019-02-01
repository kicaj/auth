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
            ->to($user->email)
            ->setSubject(__d('auth', 'Forgotten password'))
            ->setEmailFormat('html')
            ->set(compact('user'));

        if ($this->getTemplate() == __FUNCTION__) {
            $this->setTemplate('Auth.forgot');
        }
    }
}
