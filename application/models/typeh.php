<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Typeh extends DataMapper {

	var $has_one = array();
	var $has_many = array();
	var $validation = array(
		'name' => array(
				'rules' => array('required', 'max_length' => 256),
				'label' => 'Type name',
				'type' => 'input'
		),
		'description' => array(
				'rules' => array(),
				'label' => 'Description',
				'type' => 'textarea',
		)
	);
	
	function __construct($id = NULL) {		
		parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE) {
		
	}
	
	public function add($data = array())
	{
		if (!$this->update_type($data))
		{
			log_message('error', 'add_tag: failed writing to database');
			return false;
		}
	
		// Good job!
		return true;
	}
	
	
	public function update_type($data = array())
	{
		// Check if we're updating or creating a new entry by looking at $data["id"].
		// False is pushed if the ID was not found.
		if (isset($data["id"]) && $data['id'] != '')
		{
			$this->where("id", $data["id"])->get();
			if ($this->result_count() == 0)
			{
				set_notice('error', _('Failed to find the selected type\'s ID.'));
				log_message('error', 'update_type_db: failed to find requested id');
				return false;
			}
		}
	
		// Loop over the array and assign values to the variables.
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		}
	
		// let's save and give some error check. Push false if fail, true if good.
		if (!$this->save())
		{
			if (!$this->valid)
			{
				set_notice('error', _('Check that you have inputted all the required fields.'));
				log_message('error', 'update_type: failed validation');
			}
			else
			{
				set_notice('error', _('Failed to update the tag in the database for unknown reasons.'));
				log_message('error', 'update_type: failed to save');
			}
			return false;
		}
		// It's all good
		return true;
	}
	
	
	public function remove_type()
	{
		if ($this->result_count() != 1)
		{
			set_notice('error', _('Failed to remove the type. Please, check file permissions.'));
			log_message('error', 'remove_type: id not found');
			return false;
		}
	
		if (!$this->delete())
		{
			set_notice('error', _('Failed to delete the type for unknown reasons.'));
			log_message('error', 'remove_type: failed removing type');
			return false;
		}
	
		return true;
	}
	
}