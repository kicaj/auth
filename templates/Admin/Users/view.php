<legend>
    <?php echo __d('auth', 'View user'); ?>
</legend>
<table>
    <tr>
        <td>ID</td>
        <td><?php echo $user->id; ?></td>
    </tr>
    <tr>
        <td><?php echo __d('auth', 'Address e-mail'); ?></td>
        <td><?php echo $user->email; ?></td>
    </tr>
    <tr>
        <td><?php echo __d('auth', 'Group'); ?></td>
        <td>
            <?php
                if (!empty($user_groups = $user->user_groups)) {
                    echo implode(', ', array_map(function ($user_group) {
                        return $user_group->name;
                    }, $user_groups));
                }
            ?>
        </td>
    </tr>
    <tr>
        <td><?php echo __d('auth', 'Status'); ?></td>
        <td><?php echo $user->status; ?></td>
    </tr>
    <tr>
        <td><?php echo __d('auth', 'Created'); ?></td>
        <td><?php echo $user->created; ?></td>
    </tr>
    <tr>
        <td><?php echo __d('auth', 'Modified'); ?></td>
        <td><?php echo $user->modified; ?></td>
    </tr>
</table>
