<?php 
class LangController extends AppController {
    var $name = 'Lang';
    var $uses = null;

    function change($lang) {
        $this->Session->write('Config.language', $lang);
        $this->redirect($this->referer(), null, true);
    }
}
?> 
