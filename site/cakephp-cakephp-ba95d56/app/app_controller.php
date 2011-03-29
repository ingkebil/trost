<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {

    var $components = array('Session', 'RequestHandler');
    
    function beforeFilter() {        
        # if no language is set in the url, check the session, if no language is set in the session, default to German.

        if (!isset($this->params['lang'])) {
            if ($this->Session->check('Config.language')) {
                $this->params['lang'] = $this->Session->read('Config.language');
            }
            else {
                $this->params['lang'] = Configure::read('Languages.default');
            }
            if (!$this->RequestHandler->isAjax()) { # only redirect if this ain't AJAX so the POST info doesn't get lost
                $this->redirect('/' . $this->params['lang']. '/' . $this->params['url']['url']);
            }
        }
        
        # check if this is a valid language
        if (!in_array($this->params['lang'], Configure::read('Languages.all'))) {
            $this->Session->setFlash(__('Whoops, not a valid language.', true));
            return $this->redirect($this->referer(), 301, true);
        }

        $this->Session->write('Config.language', $this->params['lang']);
        Configure::write('Config.language', $this->params['lang']);
    } 

}
