<?php
/**
 * articlephotoldr Model for articlephotoldr World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * articlephotoldr Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class articlephotoldrModelarticlephotoldr extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getgreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT title,article_id FROM #__articlephotoldr';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	

	}
	
	class mynewclassModelmynewclass extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getgreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT title,article_id FROM #__mynewclass';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	

	}
	
	class articlecssModelarticlecss extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getgreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT title,article_id FROM #__articlecss';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	

	}
	
	class articlecontentModelarticlecss extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getgreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT title,article_id FROM #__articlcontent';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	

	}
?> 