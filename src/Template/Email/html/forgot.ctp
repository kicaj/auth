<?php
    echo $this->Html->link(__d('admin', 'Set new password'), array(
        'controller' => 'Users',
        'action' => 'forgotActivation',
        $user->uuid,
        '_full' => true,
    ));
?>