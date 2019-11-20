<?php echo $this->Form->create(); ?>
    <fieldset>
        <legend>
            <?php echo __d('auth', 'Forgot password'); ?>
        </legend>>
        <p>
            <?php echo __d('auth', 'Set new password for your account.'); ?>
        </p>
        <?php
            echo $this->Flash->render();

            echo $this->Form->control('password', [
                'type' => 'password',
                'label' => __d('auth', 'New password'),
            ]);

            echo $this->Form->control('password_confirm', [
                'type' => 'password',
                'label' => __d('auth', 'Confirm password'),
            ]);

            echo $this->Form->submit(__d('auth', 'Save'));
        ?>
    </fieldset>
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
