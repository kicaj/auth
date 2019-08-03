<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-icon alert-warning">
    <i class="fe fe-lock mr-2"></i>
    <?php echo $message; ?>
</div>
