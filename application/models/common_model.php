<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Common table class
 */

Class Common_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * Retrieve data using column name and column value.
	 */
	public function retrieveByColumn($table, $col, $val, $sort = FALSE, $limit, $offset)
	{
		$where = array($col => $value);
		$query = $this->db->where($table, $where);
		return $query;
	}
	
} // Class Common_model

/* EOF common_model.php */