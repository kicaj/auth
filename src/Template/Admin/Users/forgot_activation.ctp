<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __d('auth', 'Actions'); ?></li>
        <li>
            <?php
                echo $this->Html->link(__d('auth', 'Login'), [
                    'action' => 'login',
                ]);
            ?>
        </li>
        <li>
            <?php
                echo $this->Form->postLink(__d('auth', 'Register'), [
                    'action' => 'register',
                ]);
            ?>
        </li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?php
        echo $this->Form->create($user, [
            'novalidate' => true,
        ]);
    ?>
        <fieldset>
            <legend><?php echo __d('auth', 'New password'); ?></legend>
            <?php
                echo $this->Form->control('password', [
                    'type' => 'password',
                ]);
                echo $this->Form->control('password_confirm', [
                    'type' => 'password',
                ]);
            ?>
        </fieldset>
        <?php echo $this->Form->button(__d('auth', 'Submit')); ?>
    <?php echo $this->Form->end(); ?>
</div>
