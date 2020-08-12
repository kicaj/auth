<?php echo $this->Form->create(); ?>
    <fieldset>
        <legend>
            <?php echo __('Login to your account'); ?>
        </legend>
        <?php
            echo $this->Flash->render();

            echo $this->Form->control('email', [
                'label' => __('Address e-mail'),
            ]);

            echo $this->Form->control('password', [
                'label' => __('Password'),
            ]);

            echo $this->Form->submit(__('Login'));
        ?>
    </fieldset>
<?php echo $this->Form->end(); ?>
<?php
    echo $this->Html->link(__('Forgotten password?'), [
        'action' => 'forgot',
    ]);
?>
