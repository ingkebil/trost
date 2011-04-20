<?php
class StudiesController extends AppController {

	var $name = 'Studies';

    function index() {
        # TEST what is inside
        pr($this->Study->find('first'));
    }

}
?>
