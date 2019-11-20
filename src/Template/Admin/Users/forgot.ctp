<?php echo $this->Form->create(); ?>
    <p>
        <?php echo __d('auth', 'Forgot password'); ?>
    </p>
    <p>
        <?php echo __d('auth', 'After enter your e-mail address send form, then read received a message which include link to set a new password.'); ?>
    </p>
    <?php
        echo $this->Flash->render();

        echo $this->Form->control('email', [
            'label' => __d('auth', 'Address e-mail'),
        ]);

        echo $this->Form->submit(__d('auth', 'Send'));
    ?>
<?php echo $this->Form->end(); ?>
<div>
    <?php echo __d('auth', 'I did not forget!'); ?>
    <?php
        echo $this->Html->link(__d('auth', 'Sign in'), [
            'plugin' => 'Auth',
            'controller' => 'users',
            'action' => 'login',
        ]);
    ?>.
</div>
