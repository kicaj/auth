<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __d('admin', 'Actions'); ?></li>
        <li><?php echo $this->Html->link(__d('admin', 'List Users'), ['action' => 'index']); ?></li>
    </ul>
</nav>
<div class="authUsers form large-9 medium-8 columns content">
    <?php
        echo $this->Form->create($user, [
            'novalidate' => true,
        ]);
       ?>
    <fieldset>
        <legend><?php echo __d('admin', 'Add User'); ?></legend>
        <?php
        echo $this->Form->control('email');
        echo $this->Form->control('password');
        echo $this->Form->control('password_confirm');
        ?>
    </fieldset>
    <?php echo $this->Form->button(__d('admin', 'Submit')); ?>
    <?php echo $this->Form->end(); ?>
</div>
