<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update015 extends CI_Migration {

	function up() {
		$this->db->query("
				ALTER TABLE `" . $this->db->dbprefix('comics') . "`
					ADD `author_stub` varchar(256) COLLATE utf8_unicode_ci NOT NULL AFTER `author`
		");
		$this->db->query("
				ALTER TABLE `" . $this->db->dbprefix('comics') . "`
					ADD `parody_stub` varchar(256) COLLATE utf8_unicode_ci NOT NULL AFTER `parody`
		");
	}

}