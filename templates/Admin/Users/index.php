<?php
use Auth\Model\Entity\User;

/**
 * @var \App\View\AppView $this
 * @var \Auth\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<legend>
    <?php echo __d('auth', 'Users'); ?>
</legend>
<table>
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
            <th><?php echo $this->Paginator->sort('email', __d('auth', 'Address e-mail')); ?></th>
            <th><?php echo __d('auth', 'Group'); ?></th>
            <th><?php echo $this->Paginator->sort('status', __d('auth', 'Status')); ?></th>
            <th><?php echo $this->Paginator->sort('created', __d('auth', 'Created')); ?></th>
            <th><?php echo $this->Paginator->sort('modified', __d('auth', 'Last modified')); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <?php echo $user->id; ?>
                </td>
                <td>
                    <?php echo $user->email; ?>
                </td>
                <td>
                    <?php
                        if (!empty($user_groups = $user->user_groups)) {
                            echo implode(', ', array_map(function ($user_group) {
                                return $user_group->name;
                            }, $user_groups));
                        }
                    ?>
                </td>
                <td>
                    <?php echo User::getStatus($user->status); ?>
                </td>
                <td>
                    <?php echo $user->created; ?>
                </td>
                <td>
                    <?php echo $user->modified; ?>
                </td>
                <td>
                    <?php
                        echo $this->Html->link(__d('auth', 'View'), [
                            'controller' => 'Users',
                            'action' => 'view',
                            $user->id,
                        ]);

                        echo $this->Html->link(__d('auth', 'Edit'), [
                            'controller' => 'Users',
                            'action' => 'edit',
                            $user->id,
                        ]);

                        if ($this->Identity->get('id') != $user->id) {
                            echo $this->Form->postLink(__d('auth', 'Delete'), [
                                'controller' => 'Users',
                                'action' => 'delete',
                                $user->id,
                            ]);
                        }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
