<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update010 extends CI_Migration {

	function up() {
		if (!$this->db->table_exists($this->db->dbprefix('tags')))
		{
			$this->db->query(
					"CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix('tags') . "` (
                                          `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
                                          `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
                                          `description` text COLLATE utf8_unicode_ci NOT NULL,
                                          PRIMARY KEY (`id`)
                                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;"
			);
		}
		
		if (!$this->db->table_exists($this->db->dbprefix('jointags')))
		{
			$this->db->query(
					"CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix('jointags') . "` (
                                          `id` int(11) NOT NULL AUTO_INCREMENT,
                                          `jointag_id` int(11) NOT NULL,
                                          `tag_id` int(11) NOT NULL,
                                          PRIMARY KEY (`id`)
                                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;"
			);
		}
		
		$this->db->query("
				ALTER TABLE `" . $this->db->dbprefix('comics') . "`
					ADD `jointag_id` INT( 11 ) NOT NULL AFTER `typeh_id`
		");
	}

}