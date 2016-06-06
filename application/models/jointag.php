<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Jointag extends DataMapper {

	var $has_one = array();
	var $has_many = array();
	var $validation = array(
			'jointag_id' => array(
					'rules' => array('required', 'max_length' => 256),
					'label' => 'Name'
			),
			'tag_id' => array(
					'rules' => array('required', 'max_length' => 256),
					'label' => 'Stub'
			),
		);

	function __construct($id = NULL) {
		parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE) {

	}

	public function check_jointag($tags) {
		$tags = array_unique($tags);
		$size = count($tags);
		$jointags = new Jointag();
		$jointags->where('tag_id', $tags[0])->get_iterated();
		if ($jointags->result_count() < 1) {
			log_message('debug', 'check_jointag: jointag not found, result count zero');
			return false;
		}

		foreach ($jointags as $jointag) {
			$jointa = new Jointag();
			$jointa->where('jointag_id', $jointag->jointag_id)->get_iterated();
			if ($jointa->result_count() == $size) {
				$test = $tags;
				foreach ($jointa as $joi) {
					$key = array_search($joi->tag_id, $tags);
					if ($key === FALSE) {
						break;
					}
					unset($test[$key]);
				}
				if (empty($test)) {
					return $joi->jointag_id;
				}
			}
		}
		log_message('debug', 'check_jointag: jointag not found');
		return false;
	}

	public function add_jointag_via_name($tags) {
		$result = array();
		
		//tags is an array of ordered numbers that must be changed with an array of tag names  
		$alltags = new Tag();
		$alltags->order_by('name','ASC')->get();
		
		$newtags = array();
		foreach ($alltags->all as $new) 
		{
			$newtags[] = $new->name;
		}
		
		foreach ($tags as $key => $value)
		{
			$tags[$key] = $newtags[$value-1];
		} 
		
		foreach ($tags as $tag) {
			$ta = new Tag();
			$ta->where('name', $tag)->get();
			if ($ta->result_count() == 0) {
				set_notice('error', _('One of the named tags doesn\'t exist.'. $tag));
				log_message('error', 'add_joint_via_name: tag does not exist');
				return false;
			}
			$result[] = $ta->id;
		}
		return $this->add_jointag($result);
	}

	// $tags is an array of IDs
	public function add_jointag($tags) {
		if (!$result = $this->check_jointag($tags)) {
			$maxjointag = new Jointag();
			/**
			 * @todo select_max returns an error:
			 * ERROR - 2011-05-31 19:58:16 --> Severity: Notice --> Undefined offset: 0 /var/www/manga/beta3/system/database/DB_active_rec.php 1719
			*/
			//$maxjoint->select_max('joint_id')->get();
			$maxjointag->order_by('jointag_id', 'DESC')->limit(1)->get();
			$max = $maxjointag->jointag_id + 1;

			foreach ($tags as $key => $tag) {
				$jointag = new Jointag();
				$jointag->jointag_id = $max;
				$jointag->tag_id = $tag;
				if (!$jointag->save()) {
					if ($jointag->valid) {
						set_notice('error', _('Check that you have inputted all the required fields.'));
						log_message('error', 'add_jointag: validation failed');
					}
					else {
						set_notice('error', _('Couldn\'t save jointag to database due to an unknown error.'));
						log_message('error', 'add_jointag: saving failed');
					}
					return false;
				}
			}
			return $max;
		}
		return $result;
	}

	public function remove_jointag() {
		if (!$this->delete_all()) {
			set_notice('error', _('The jointag couldn\'t be removed.'));
			log_message('error', 'remove_jointag: failed deleting');
			return false;
		}
		return true;
	}

	public function add_tag($tag_id) {
		$jointag = new Jointag();
		$jointag->tag_id = $tag_id;
		$jointag->jointag_id = $this->jointag_id;
		if (!$jointag->save()) {
			if ($jointag->valid) {
				set_notice('error', _('Check that you have inputted all the required fields.'));
				log_message('error', 'add_tag (jointag.php): validation failed');
			}
			else {
				set_notice('error', _('Couldn\'t add tag to jointag for unknown reasons.'));
				log_message('error', 'add_tag (jointag.php): saving failed');
			}
			return false;
		}
	}

	public function remove_tag($tag_id) {
		$this->where('tag_id', $tag_id)->get();
		if (!$this->delete()) {
			set_notice('error', _('Couldn\'t remove the tag from the jointag.'));
			log_message('error', 'remove_tag (jointag.php): removing failed');
			return false;
		}
	}

	public function remove_tag_from_all($tag_id) {
		$jointags = new Jointag();
		$jointags->where('tag_id', $tag_id)->get();
		if (!$jointags->delete_all()) {
			set_notice('error', _('Couldn\'t remove the tag from all the joints.'));
			log_message('error', 'remove_tags_from_all (jointag.php): removing failed');
			return false;
		}
		return true;
	}

}
