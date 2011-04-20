<?php
class PlantlinesController extends AppController {

	var $name = 'Plantlines';

    function index() {

        pr($this->Plantline->find('all'));
    }

}
?>
