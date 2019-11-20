<?php echo $this->Form->create(); ?>
    <p>
        <?php echo __d('auth', 'Login to your account'); ?>
    </p>
    <?php
        echo $this->Flash->render();

        echo $this->Form->control('email', [
            'label' => __d('auth', 'Address e-mail'),
        ]);

        echo $this->Html->link(__d('auth', 'Forgotten password?'), [
            'action' => 'forgot',
        ]);

        echo $this->Form->control('password', [
            'label' => __d('auth', 'Password'),
        ]);

        echo $this->Form->submit(__d('auth', 'Login'));
    ?>
<?php echo $this->Form->end(); ?>
