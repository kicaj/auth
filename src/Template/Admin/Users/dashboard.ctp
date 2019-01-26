<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php echo __d('auth', 'Actions'); ?></li>
        <li>
            <?php
                echo $this->Html->link(__d('auth', 'List Users'), [
                    'action' => 'index',
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
    <h3><?php echo __d('auth', 'Dashboard'); ?></h3>
</div>
