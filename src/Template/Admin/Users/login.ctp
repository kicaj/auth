<div class="row">
    <div class="col col-login m-6 mx-auto">
        <?php
            echo $this->Form->create('', [
                'novalidate' => true,
                'class' => 'card',
            ]);
        ?>
            <div class="card-header">
                <?php echo __d('auth', 'Login to your account'); ?>
            </div>
            <div class="card-body">
                <?php echo $this->Flash->render(); ?>
                <?php
                    echo $this->Form->control('email', [
                        'label' => __d('auth', 'Address e-mail'),
                    ]);
                ?>
                <?php
                    echo $this->Html->link(__d('auth', 'Forgotten password?'), [
                        'action' => 'forgot',
                    ], [
                        'class' => 'float-right small',
                    ]);
                ?>
                <?php
                    echo $this->Form->control('password', [
                        'label' => __d('auth', 'Password'),
                    ]);
                ?>
                <div class="form-footer">
                    <?php
                        echo $this->Form->submit(__d('auth', 'Login'), [
                            'class' => 'btn btn-primary btn-block',
                        ]);
                    ?>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
