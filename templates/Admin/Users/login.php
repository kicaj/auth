<?php echo $this->Form->create(); ?>
    <fieldset>
        <legend>
            <?php echo __d('auth', 'Login to your account'); ?>
        </legend>
        <?php
            echo $this->Flash->render();

            echo $this->Form->control('email', [
                'label' => __d('auth', 'Address e-mail'),
            ]);

            echo $this->Form->control('password', [
                'label' => __d('auth', 'Password'),
            ]);

            echo $this->Form->submit(__d('auth', 'Login'));
        ?>
    </fieldset>
<?php echo $this->Form->end(); ?>
<?php
    echo $this->Html->link(__d('auth', 'Forgotten password?'), [
        'action' => 'forgot',
    ]);
?>
