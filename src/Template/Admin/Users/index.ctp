<div class="container">
    <?php echo $this->element('pagination'); ?>
    <div class="card mt-2 mb-2">
        <div class="table-responsive">
            <table class="table table-hover table-outline table-vcenter card-table">
                <thead>
                    <tr>
                        <th class="text-center w-1"><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
                        <th><?php echo $this->Paginator->sort('email', __d('auth', 'Address e-mail')); ?></th>
                        <th><?php echo __d('auth', 'Group'); ?></th>
                        <th class="text-center w-1"><?php echo $this->Paginator->sort('status', __d('auth', 'Status')); ?></th>
                        <th class="text-center"><?php echo $this->Paginator->sort('modified', __d('auth', 'Last modified')); ?></th>
                        <th class="text-center w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="text-center w-1">
                                <?php echo $user->id; ?>
                            </td>
                            <td>
                                <div>
                                    <?php echo $user->email; ?>
                                </div>
                                <div class="text-muted small">
                                    <?php echo __d('auth', 'Created at'); ?> <?php echo $user->created; ?>
                                </div>
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
                            <td class="text-center w-2">
                                <?php echo $user->status; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $user->modified; ?>
                            </td>
                            <td class="text-center w-1">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="icon">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                        <?php
                                            echo $this->Icon->link('edit-2 dropdown-icon', __d('auth', 'Edit'), [
                                                'controller' => 'Users',
                                                'action' => 'edit',
                                                $user->id,
                                            ], [
                                                'class' => 'dropdown-item',
                                            ]);

                                            if ($this->Identity->get('id') != $user->id) {
                                                echo $this->Icon->link('trash-2 dropdown-icon', __d('auth', 'Delete'), [
                                                    'controller' => 'Users',
                                                    'action' => 'delete',
                                                    $user->id,
                                                ], [
                                                    'class' => 'dropdown-item',
                                                ]);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo $this->element('pagination'); ?>
</div>
