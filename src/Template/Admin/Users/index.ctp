<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __d('admin', 'Actions'); ?></li>
        <li><?php echo $this->Html->link(__d('admin', 'New User'), ['action' => 'add']); ?></li>
    </ul>
</nav>
<div class="authUsers index large-9 medium-8 columns content">
    <h3><?php echo __d('admin', 'Users'); ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?php echo $this->Paginator->sort('id'); ?></th>
                <th scope="col"><?php echo $this->Paginator->sort('email'); ?></th>
                <th scope="col"><?php echo $this->Paginator->sort('created'); ?></th>
                <th scope="col"><?php echo $this->Paginator->sort('modified'); ?></th>
                <th scope="col" class="actions"><?php echo __d('admin', 'Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $this->Number->format($user->id); ?></td>
                <td><?php echo h($user->email); ?></td>
                <td><?php echo h($user->created); ?></td>
                <td><?php echo h($user->modified); ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('admin', 'View'), ['action' => 'view', $user->id]); ?>
                    <?php echo $this->Html->link(__d('admin', 'Edit'), ['action' => 'edit', $user->id]); ?>
                    <?php echo $this->Form->postLink(__d('admin', 'Delete'), ['action' => 'delete', $user->id], ['confirm' => __d('admin', 'Are you sure you want to delete # {0}?', $user->id)]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?php echo $this->Paginator->first('<< ' . __d('admin', 'first')); ?>
            <?php echo $this->Paginator->prev('< ' . __d('admin', 'previous')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next(__d('admin', 'next') . ' >'); ?>
            <?php echo $this->Paginator->last(__d('admin', 'last') . ' >>'); ?>
        </ul>
        <p>
        <?php echo $this->Paginator->counter(['format' => __d('admin', 'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]); ?></p>
    </div>
</div>
