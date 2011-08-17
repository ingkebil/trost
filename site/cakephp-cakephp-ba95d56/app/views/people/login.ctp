<?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('Person');
    echo $this->Form->input('name');
    echo $this->Form->input('password');
    echo $this->Form->end('Login');
?>
