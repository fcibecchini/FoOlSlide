<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update013 extends CI_Migration {

	function up() {
		$this->db->query("
				ALTER TABLE `" . $this->db->dbprefix('comics') . "`
					ADD `parody` VARCHAR(512) NOT NULL AFTER `description`
		");
	}

}