<div class="row">
    <div class="col col-login m-6 mx-auto">
        <?php
            echo $this->Form->create($user, [
                'novalidate' => true,
                'class' => 'card',
            ]);
        ?>
            <div class="card-header">
                <?php echo __d('auth', 'Forgot password'); ?>
            </div>
            <div class="card-body">
                <?php echo $this->Flash->render(); ?>
                <p class="text-muted text-center">
                    <?php echo __d('auth', 'Set new password for your account.'); ?>
                </p>
                <?php
                    echo $this->Form->control('password', [
                        'label' => __d('auth', 'New password'),
                    ]);
                ?>
                <?php
                    echo $this->Form->control('password_confirm', [
                        'type' => 'password',
                        'label' => __d('auth', 'Confirm password'),
                    ]);
                ?>
                <div class="form-footer">
                    <?php
                        echo $this->Form->submit(__d('auth', 'Save'), [
                            'class' => 'btn btn-primary btn-block',
                        ]);
                    ?>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
        <div class="text-center text-muted small">
            <?php echo __d('auth', 'I did not forget!'); ?>
            <?php
                echo $this->Html->link(__d('auth', 'Sign in'), [
                    'plugin' => 'Auth',
                    'controller' => 'users',
                    'action' => 'login',
                ]);
            ?>.
        </div>
    </div>
</div>
