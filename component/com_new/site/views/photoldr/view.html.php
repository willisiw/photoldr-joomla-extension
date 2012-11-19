<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_2
 * @license    GNU/GPL
	*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the PhotoLdr Component
 *
 * @package    PhotoLdr
 */

class articlePhotoLdrViewarticlePhotoLdr extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		$title = $model->gettitle();
		$article_id = $model->getarticle_id();
		
		
		$title = $model->getgreeting();
		$this->assignRef( 'title',	$title['title']);
		
		$article_id = $model->getgreeting();
		$this->assignRef( 'article_id',	$article_id['article_id']);

		
		
		



		//$title = $model->gettitle();
		//$this->assignRef( 'article_id',	$article_id);
		
		//$title = $model->gettitle();
		//$this->assignRef( 'introtext',	$introtext);
		//$title = $model->gettitle();
		//$this->assignRef( 'created ',$created);
		//$title = $model->gettitle();
		//$this->assignRef( 'created_by_alias',$created_by_alias);
		//$title = $model->gettitle();
		//$this->assignRef( 'images',	$images);
		
		
		parent::display($tpl);
	}
}

class mynewclassViewmynewclass extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		$title = $model->gettitle();
		$article_id = $model->getarticle_id();
		
		
		$title = $model->getgreeting();
		$this->assignRef( 'title',	$title['title']);
		
		$article_id = $model->getgreeting();
		$this->assignRef( 'article_id',	$article_id['article_id']);

		
		
		



		//$title = $model->gettitle();
		//$this->assignRef( 'article_id',	$article_id);
		
		//$title = $model->gettitle();
		//$this->assignRef( 'introtext',	$introtext);
		//$title = $model->gettitle();
		//$this->assignRef( 'created ',$created);
		//$title = $model->gettitle();
		//$this->assignRef( 'created_by_alias',$created_by_alias);
		//$title = $model->gettitle();
		//$this->assignRef( 'images',	$images);
		
		
		parent::display($tpl);
	}
}

class articlecssViewarticlecss extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		$title = $model->gettitle();
		$article_id = $model->getarticle_id();
		
		
		$title = $model->getgreeting();
		$this->assignRef( 'title',	$title['title']);
		
		$article_id = $model->getgreeting();
		$this->assignRef( 'article_id',	$article_id['article_id']);

		
		
		



		//$title = $model->gettitle();
		//$this->assignRef( 'article_id',	$article_id);
		
		//$title = $model->gettitle();
		//$this->assignRef( 'introtext',	$introtext);
		//$title = $model->gettitle();
		//$this->assignRef( 'created ',$created);
		//$title = $model->gettitle();
		//$this->assignRef( 'created_by_alias',$created_by_alias);
		//$title = $model->gettitle();
		//$this->assignRef( 'images',	$images);
		
		
		parent::display($tpl);
	}
	
class articlecontentViewarticlecss extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		$title = $model->gettitle();
		$article_id = $model->getarticle_id();
		
		
		$title = $model->getgreeting();
		$this->assignRef( 'title',	$title['title']);
		
		$article_id = $model->getgreeting();
		$this->assignRef( 'article_id',	$article_id['article_id']);

		
		
		



		//$title = $model->gettitle();
		//$this->assignRef( 'article_id',	$article_id);
		
		//$title = $model->gettitle();
		//$this->assignRef( 'introtext',	$introtext);
		//$title = $model->gettitle();
		//$this->assignRef( 'created ',$created);
		//$title = $model->gettitle();
		//$this->assignRef( 'created_by_alias',$created_by_alias);
		//$title = $model->gettitle();
		//$this->assignRef( 'images',	$images);
		
		
		parent::display($tpl);
	}
}?>