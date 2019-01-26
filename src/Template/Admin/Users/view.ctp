<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $authUser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __d('admin', 'Actions'); ?></li>
        <li><?php echo $this->Html->link(__d('admin', 'Edit Auth User'), ['action' => 'edit', $authUser->id]); ?> </li>
        <li><?php echo $this->Form->postLink(__d('admin', 'Delete Auth User'), ['action' => 'delete', $authUser->id], ['confirm' => __d('admin', 'Are you sure you want to delete # {0}?', $authUser->id)]); ?> </li>
        <li><?php echo $this->Html->link(__d('admin', 'List Auth Users'), ['action' => 'index']); ?> </li>
        <li><?php echo $this->Html->link(__d('admin', 'New Auth User'), ['action' => 'add']); ?> </li>
    </ul>
</nav>
<div class="authUsers view large-9 medium-8 columns content">
    <h3><?php echo h($authUser->id); ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?php echo __d('admin', 'Email'); ?></th>
            <td><?php echo h($authUser->email); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('admin', 'Password'); ?></th>
            <td><?php echo h($authUser->password); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('admin', 'Uuid'); ?></th>
            <td><?php echo h($authUser->uuid); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('admin', 'Id'); ?></th>
            <td><?php echo $this->Number->format($authUser->id); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('admin', 'Created'); ?></th>
            <td><?php echo h($authUser->created); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('admin', 'Modified'); ?></th>
            <td><?php echo h($authUser->modified); ?></td>
        </tr>
    </table>
</div>
