<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $authUser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $authUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $authUser->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Auth Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="authUsers form large-9 medium-8 columns content">
    <?= $this->Form->create($authUser) ?>
    <fieldset>
        <legend><?= __('Edit Auth User') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('uuid');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
