<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __d('auth', 'Actions'); ?></li>
        <li>
            <?php
                echo $this->Html->link(__d('auth', 'Edit User'), [
                    'action' => 'edit',
                    $user->id,
                ]);
            ?>
        </li>
        <li>
            <?php
                echo $this->Form->postLink(__d('auth', 'Delete User'), [
                    'action' => 'delete',
                    $user->id,
                ], [
                    'confirm' => __d('auth', 'Are you sure you want to delete # {0}?', $user->id),
                ]);
            ?>
        </li>
        <li>
            <?php
                echo $this->Html->link(__d('auth', 'List Users'), [
                    'action' => 'index',
                ]);
            ?>
        </li>
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
<div class="users view large-9 medium-8 columns content">
    <h3><?php echo $user->email; ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?php echo __d('auth', 'Id'); ?></th>
            <td><?php echo $user->id; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('auth', 'Email'); ?></th>
            <td><?php echo $user->email; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('auth', 'Created'); ?></th>
            <td><?php echo $user->created; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __d('auth', 'Modified'); ?></th>
            <td><?php echo $user->modified; ?></td>
        </tr>
    </table>
</div>
