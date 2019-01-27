<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __d('auth', 'Actions'); ?></li>
        <li>
            <?php
               echo $this->Html->link(__d('auth', 'New User'), [
                   'action' => 'add',
               ]);
            ?>
        </li>
        <li>
            <?php
                echo $this->Html->link(__d('auth', 'Logout'), [
                    'action' => 'logout',
                ]);
            ?>
        </li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?php echo __d('auth', 'Users'); ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?php echo $this->Paginator->sort('id'); ?></th>
                <th scope="col"><?php echo $this->Paginator->sort('email'); ?></th>
                <th scope="col"><?php echo $this->Paginator->sort('created'); ?></th>
                <th scope="col"><?php echo $this->Paginator->sort('modified'); ?></th>
                <th scope="col" class="actions"><?php echo __d('auth', 'Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->email; ?></td>
                <td><?php echo $user->created; ?></td>
                <td><?php echo $user->modified; ?></td>
                <td class="actions">
                    <?php
                        echo $this->Html->link(__d('auth', 'View'), [
                            'action' => 'view',
                            $user->id,
                        ]);
                    ?>
                    <?php
                        echo $this->Html->link(__d('auth', 'Edit'), [
                            'action' => 'edit',
                            $user->id,
                        ]);
                    ?>
                    <?php
                        echo $this->Form->postLink(__d('auth', 'Delete'), [
                            'action' => 'delete',
                            $user->id,
                        ], [
                            'confirm' => __d('auth', 'Are you sure you want to delete # {0}?', $user->id),
                        ]);
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?php echo $this->Paginator->first('<< ' . __d('auth', 'first')); ?>
            <?php echo $this->Paginator->prev('< ' . __d('auth', 'previous')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next(__d('auth', 'next') . ' >'); ?>
            <?php echo $this->Paginator->last(__d('auth', 'last') . ' >>'); ?>
        </ul>
        <p>
            <?php
                echo $this->Paginator->counter([
                    'format' => __d('auth', 'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total'),
                ]);
            ?>
        </p>
    </div>
</div>
