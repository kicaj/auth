<?php
echo $this->Html->link(__d('auth', 'Set new password'), array(
    'controller' => 'Users',
    'action' => 'forgotActivation',
    $user->uuid,
    '_full' => true,
));
