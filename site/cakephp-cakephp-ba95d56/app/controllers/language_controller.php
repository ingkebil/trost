<?php 

/*

See following posts for more explanation:
http://book.cakephp.org/#!/view/1328/Translate
http://bakery.cakephp.org/articles/p0windah/2007/09/12/p28n-the-top-to-bottom-persistent-internationalization-tutorial
http://bakery.cakephp.org/articles/sky_l3ppard/2010/01/05/smoothtranslate-to-make-smooth-translations

 */

class LanguageController extends AppController {
    var $name = 'Language';
    var $uses = null;

    function change($lang) {
        # check if this is a valid language
        if (!in_array($lang, Configure::read('Languages.all'))) {
            $this->Session->setFlash(__('Whoops, not a valid language.', true));
            return $this->redirect($this->referer(), 301, true);
        }

        # change it application wide
        $this->params['lang'] = $lang;
        $this->Session->write('Languages.default', $this->params['lang']);
        Configure::write('Languages.default', $this->params['lang']);
        $this->redirect('/' . $lang . '/' . $this->referer());
        #$this->redirect($this->referer(), null, true);
    }

    function shunt() {
        # check if this is a valid language
        if (!in_array($this->params['lang'], Configure::read('Languages.all'))) {
            $this->Session->setFlash(__('Whoops, not a valid language.', true));
            return $this->redirect($this->referer(), 301, true);
        }

        # change it application wide
        $this->Session->write('Languages.default', $this->params['lang']);
        Configure::write('Languages.default', $this->params['lang']);

        $args = func_get_args();
        $this->redirect('/' . implode('/', $args));
    }
}
?> 
