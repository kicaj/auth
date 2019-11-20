<?php echo $this->Form->create($user); ?>
    <fieldset>
        <legend>
            <?php echo __d('auth', 'Edit user'); ?>
        </legend>
        <?php
            echo $this->Flash->render();

            echo $this->Form->control('email', [
                'label' => __d('auth', 'Address e-mail'),
            ]);

            echo $this->Form->control('password', [
                'type' => 'password',
                'label' => __d('auth', 'Password'),
            ]);

            echo $this->Form->control('password_confirm', [
                'type' => 'password',
                'label' => __d('auth', 'Confirm password'),
            ]);
        ?>
    </fieldset>
    <?php echo $this->Form->button(__d('auth', 'Save')); ?>
<?php echo $this->Form->end(); ?>
