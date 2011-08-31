<?php

class BosController extends AppController {

    var $uses = array();

    function start() {
        $this->Session->write('BO.started', true);
    }

    function stop() {
        $this->Session->write('BO.started', false);
    }

    function toggle() {
        $this->Session->write('BO.started', $this->Session->read('BO.started') ? false : true);
        $this->redirect('#', 204, true);
    }

}

?>
