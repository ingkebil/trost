<div id="editMessage" class="message">
<?php echo $message ?> 
<?php echo $this->Html->link($edit_message, array('controller' => $controller, 'action' => isset($action) ? $action : 'edit', $id)) ?>
</div>
