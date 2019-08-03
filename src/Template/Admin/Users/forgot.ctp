<div class="row">
    <div class="col col-login m-6 mx-auto">
        <?php
            echo $this->Form->create('', [
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
                    <?php echo __d('auth', 'Enter your e-mail address and send.'); ?><br>
                    <?php echo __d('auth', 'Then receive a message with a link to set a new password.'); ?>
                </p>
                <?php
                    echo $this->Form->control('email', [
                        'label' => __d('auth', 'Address e-mail'),
                    ]);
                ?>
                <div class="form-footer">
                    <?php
                        echo $this->Form->submit(__d('auth', 'Send'), [
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
