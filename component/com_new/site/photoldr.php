<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * components/com_articlePhotoLdr/articlePhotoLdr.php
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1#Creating_the_Entry_Point
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller

require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require specific controller if requested
if ($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// Create the controller
$classname	= 'articlePhotoLdrController'.$controller;
$controller	= new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Create the controller
$classname	= 'articlecssController'.$controller;
$controller	= new $classname();
// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );
// Create the controller
$classname	= 'mynewclassController'.$controller;
$controller	= new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );
$controller->execute( JRequest::getVar( 'task' ) );
// Create the controller
$classname	= 'myarticlecontentController'.$controller;
$controller	= new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );


// Redirect if set by the controller
$controller->redirect();