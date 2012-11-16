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

    var $components = array(
        'Session', 
        'RequestHandler',
        'Auth' => array(
            'userModel' => 'Person',
            'fields'    => array(
                'username' => 'username',
                'password' => 'password',
            ),
            'loginAction' => array(
                'admin' => false,
                'controller' => 'people',
                'action' => 'login',
                'lang' => 'de-de',
            ),
#            'loginRedirect' => array(
#                'controller' => 'people',
#                'actions' => 'index',
#            ),
            'loginRedirect' => '/',
            'authorize' => 'controller',
#            'loginError' => __('The credentials provided are incorrect', true),
        )
    );

    var $helpers = array('Javascript', 'Form', 'Html', 'Ajax', 'Session');
    
    /**
     * Works together with the Auth component, when that component is set to Auth::authorize='controller'.
     */
    function isAuthorized() {
        # disable delete site wide after login
        if ($this->action == 'delete') return false;

        if ($this->Auth->user('role') == 'admin') {
            return true;
        }
        elseif (in_array($this->action, array('edit', 'add', 'delete'))) {
            return false;
        }
        return true;
    }

    function beforeFilter() {        
        $this->Auth->allow('display');
        $this->Auth->allow('download');
        $this->Auth->deny('delete'); # disable this action explicitely before login sitewide
        $admin = $this->Auth->user('role') == 'admin' ? true : false;
        $this->set(compact('admin'));

        # if no language is set in the url, check the session, if no language is set in the session, default to German.
        if (!isset($this->params['lang'])) {
            if ($this->Session->check('Config.language')) {
                $this->params['lang'] = $this->Session->read('Config.language');
            }
            else {
                $this->params['lang'] = Configure::read('Languages.default');
            }
            if (!$this->RequestHandler->isAjax() and !$this->RequestHandler->isPost()) { # be sure not to redirect requests that have POST content, I mean, the i18n ain't that important ;)
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

    function redirect($url, $status = null, $exit = true) {
        if (! isset($url['lang']) && isset($this->params['lang'])) {
            $url['lang'] = $this->params['lang'];
        }

        return parent::redirect($url, $status, $exit);
    }

}

?>
