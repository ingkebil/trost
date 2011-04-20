<?php

class TrostsamplesController extends AppController {
    var $name = 'Trostsamples';


    function index() {
        pr($this->Trostsample->find('first'));
    }
}

?>
