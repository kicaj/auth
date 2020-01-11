<?php echo $this->Form->create(); ?>
    <fieldset>
        <legend>
            <?php echo __('Forgot password'); ?>
        </legend>
        <p>
            <?php echo __('Set new password for your account.'); ?>
        </p>
        <?php
            echo $this->Flash->render();

            echo $this->Form->control('password', [
                'type' => 'password',
                'label' => __('New password'),
            ]);

            echo $this->Form->control('password_confirm', [
                'type' => 'password',
                'label' => __('Confirm password'),
            ]);

            echo $this->Form->submit(__('Save'));
        ?>
    </fieldset>
<?php echo $this->Form->end(); ?>
<div>
    <?php echo __('I did not forget!'); ?>
    <?php
        echo $this->Html->link(__('Sign in'), [
            'plugin' => 'Auth',
            'controller' => 'users',
            'action' => 'login',
        ]);
    ?>.
</div>
