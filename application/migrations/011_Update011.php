<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update011 extends CI_Migration {

	function up() {
		$this->db->query("
				ALTER TABLE `" . $this->db->dbprefix('tags') . "`
					ADD `thumbnail` varchar(512) COLLATE utf8_unicode_ci NOT NULL AFTER `description`
		");
	}

}