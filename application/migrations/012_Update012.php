<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update012 extends CI_Migration {

	function up() {
		$this->db->query("
				ALTER TABLE `" . $this->db->dbprefix('chapters') . "`
					ADD `downloads` int(11) NOT NULL DEFAULT '0' AFTER `editor`
		");
	}

}