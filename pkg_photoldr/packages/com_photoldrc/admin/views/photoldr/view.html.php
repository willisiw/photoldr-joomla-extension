<?php
//No direct access to this file should be called by Joomla
defined('_JEXEC') or die('Restricted Access');
//import joomla controller library
jimport('joomla.application.component.view');
class photoldrViewphotoldr extends JView
{
    //Overrite JView display method
    function display($tpl = null)
    {
    //Assign data to the view
    $document   = & JFactory::getDocument();       
	$document->addStyleSheet( JURI::base().'/components/com_photoldr/style.css' );
	$document->addStyleSheet( JURI::base().'/components/com_photoldr/colors-fresh.min.css' );
	
	/* $items = $this->get('Items');
            
 
                // Check for errors.
              if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
              //  $this->items = $items;
            
 
                // Set the toolbar and number of found items
                $this->addToolBar();*/
 
                // Display the template
       parent::display($tpl);
    }
	/* protected function addToolBar($total=null) 
    {
                JToolBarHelper::title(JText::_('PhotoLDR').
                        //Reflect number of items in title!
                        ($total?' <span style="font-size: 0.5em; vertical-align: middle;">('.$total.')</span>':'')
                        , 'helloworld');
                JToolBarHelper::apply('Apply', 'photoldr.apply');
                JToolBarHelper::save('photoldr.save');
                JToolBarHelper::cancel('photoldr.cancel','JTOOLBAR_CLOSE');
    }*/
}
?>