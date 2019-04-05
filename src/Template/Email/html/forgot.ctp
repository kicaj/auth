<?php

echo $this->Html->link('New password', array(
    'action' => 'forgotActivation',
    $user->uuid,
    '_full' => true,
));

?>