<?php
/**
 * @package      Socialcommunity
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class SocialcommunityModelLocation extends JModelAdmin
{
    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   string $type    The table type to instantiate
     * @param   string $prefix A prefix for the table class name. Optional.
     * @param   array  $config Configuration array for model. Optional.
     *
     * @return  JTable|bool  A database object
     * @since   1.6
     */
    public function getTable($type = 'Location', $prefix = 'SocialcommunityTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array   $data     An optional array of data for the form to interogate.
     * @param   boolean $loadData True if the form is to load its own data (default case), false if not.
     *
     * @return  JForm|bool   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm($this->option . '.location', 'location', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed   The data for the form.
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState($this->option . '.edit.location.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Save data into the DB
     *
     * @param array $data   The data about item
     *
     * @return  int   Item ID
     */
    public function save($data)
    {
        $id          = Joomla\Utilities\ArrayHelper::getValue($data, 'id');
        $name        = Joomla\Utilities\ArrayHelper::getValue($data, 'name');
        $latitude    = Joomla\Utilities\ArrayHelper::getValue($data, 'latitude');
        $longitude   = Joomla\Utilities\ArrayHelper::getValue($data, 'longitude');
        $countryCode = Joomla\Utilities\ArrayHelper::getValue($data, 'country_code');
        $timezone    = Joomla\Utilities\ArrayHelper::getValue($data, 'timezone');

        // Load a record from the database
        $row = $this->getTable();
        $row->load($id);

        $row->set('name', $name);
        $row->set('latitude', $latitude);
        $row->set('longitude', $longitude);
        $row->set('country_code', $countryCode);
        $row->set('timezone', $timezone);

        $row->store();

        return $row->get('id');
    }
}
