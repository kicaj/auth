<?php echo $this->Form->create(); ?>
    <fieldset>
        <legend>
            <?php echo __('Forgot password'); ?>
        </legend>
        <p>
            <?php echo __('After enter your e-mail address send form, then read received a message which include link to set a new password.'); ?>
        </p>
        <?php
            echo $this->Flash->render();

            echo $this->Form->control('email', [
                'label' => __('Address e-mail'),
            ]);

            echo $this->Form->submit(__('Send'));
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
