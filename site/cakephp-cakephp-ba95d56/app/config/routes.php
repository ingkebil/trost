<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */

    
    /*
    http://www.studiocanaria.com/articles/quicktips_finding_all_the_controllers_in_your_cakephp_application
    */
    function listControllers() {
        return array_unique(
            array_map('__plunderscore', Configure::listObjects('controller'))
        );
    }

    function __plunderscore($name) {
        return Inflector::pluralize(Inflector::underscore($name));
    }

    # connect the from page
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/:lang', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
    Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/dis/abled', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/:lang/dis/abled', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/people/disabled', array('controller' => 'pages', 'action' => 'display', 'person_disabled'));
	Router::connect('/:lang/people/disabled', array('controller' => 'pages', 'action' => 'display', 'person_disabled'));
	Router::connect('/:lang/phenotypes/', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/:lang/phenotypes/index', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/:lang/phenotypes/upload', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/:lang/phenotypes/manualupload', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/:lang/phenotypes/edit/:id', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/:lang/phenotypes/delete', array('controller' => 'pages', 'action' => 'display', 'disabled'));
	Router::connect('/:lang/temps/erature', array('controller' => 'pages', 'action' => 'display', 'disabled'));


    # connect the singular named gmd page
    Router::connect('/gmd', array('controller' => 'gmd'));
    Router::connect('/:lang/gmd', array('controller' => 'gmd'));

    # connect the file downloading
    Router::connect('/files', array('controller' => 'ufiles', 'action' => 'index'));
    Router::connect('/:lang/files', array('controller' => 'ufiles', 'action' => 'index'));
    Router::connect('/files/*', array('controller' => 'ufiles', 'action' => 'download'));
    Router::connect('/:lang/files/*', array('controller' => 'ufiles', 'action' => 'download'));

    #Router::connect('/de-de/:controller/:action/*', array('lang' => 'de-de'));
    #Router::connect('/en-us/:controller/:action/*', array('lang' => 'en-us'));
    # explicitly attach all the indexes
    $controllers = listControllers();
    foreach ($controllers as $controller) {
        Router::connect("/:lang/$controller", array('controller' => $controller, 'action' => 'index'));
    #    Router::connect("/:lang/$controller/edit/*", array('controller' => $controller, 'action' => 'edit'));
    }

    Router::connectNamed(array('p', 'c', 'e', 'id', 'page', 'sort', 'direction', 'drop', 'name', 'keyword', 'description', 'person_id', 'location_id', 'invalid'));
    Router::connect('/:controller/:action');
    Router::connect('/:lang/:controller', array('action' => 'index'));
    Router::connect('/:lang/:controller/:action/*');
