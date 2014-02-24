<?php
/**
 * @package      SocialCommunity
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class SocialCommunityViewProfile extends JViewLegacy {
    
    protected $state;
    protected $item;
    protected $form;
    
    protected $documentTitle;
    protected $option;
    
    public function __construct($config) {
        parent::__construct($config);
        $this->option = JFactory::getApplication()->input->get("option");
    }
    
    /**
     * Display the view
     */
    public function display($tpl = null){
        
        $this->state= $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');
        
        $this->params       = $this->state->get("params");
        
        if(empty($this->item->id)) {
            $app = JFactory::getApplication();
            $app->enqueueMessage(JText::_("COM_SOCIALCOMMUNITY_NO_PROFILE"), "notice");
            $app->redirect( JRoute::_('index.php?option=com_socialcommunity&view=profiles', false) );
            return;
        }
        
        $model = $this->getModel();
        
        $this->imagesFolder = "../".$this->params->get("images_directory", "images/profiles");
        $this->item         = $model->getItem();
        
        // Prepare actions, behaviors, scritps and document
        $this->addToolbar();
        $this->setDocument();
        
        parent::display($tpl);
    }
    
    /**
     * Add the page title and toolbar.
     *
     * @since   1.6
     */
    protected function addToolbar(){
        
        JFactory::getApplication()->input->set('hidemainmenu', true);
        $isNew = ($this->item->id == 0);
        
        $this->documentTitle = $isNew ? JText::_('COM_SOCIALCOMMUNITY_NEW_PROFILE')
		                              : JText::_('COM_SOCIALCOMMUNITY_EDIT_PROFILE');
        
		if(!$isNew) {
		    JToolBarHelper::title($this->documentTitle, 'itp-profile-edit');
		} else { 
            JToolBarHelper::title($this->documentTitle, 'itp-profile-add');
		}
		                             
        JToolBarHelper::apply('profile.apply');
        JToolBarHelper::save('profile.save');
    
        if(!$isNew){
            JToolBarHelper::cancel('profile.cancel', 'JTOOLBAR_CANCEL');
        }else{
            JToolBarHelper::cancel('profile.cancel', 'JTOOLBAR_CLOSE');
        }
        
    }
    
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() {
	    
	    // Add behaviors
        JHtml::_('behavior.tooltip');
        JHtml::_('behavior.formvalidation');
        
        JHtml::_('formbehavior.chosen', '#jform_country_id');
        
		$this->document->setTitle($this->documentTitle);
        
		// Add scripts
		$this->document->addScript(JURI::root() . 'media/'.$this->option.'/js/admin/'.strtolower($this->getName()).'.js');
        
	}

}