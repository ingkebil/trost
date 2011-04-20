<?php

class TrostplantsController extends AppController {
    var $name = 'Trostplants';


    function index() {
        pr($this->Trostplant->find('first'));
    }
}

?>
