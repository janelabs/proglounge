<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Common model class
 * This Class uses CodeIngniter's Active Record Class 
 */

Class Common extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * Insert data using an array
	 */
	public function insertData($table, $data)
	{
		if (is_array($data)) {
			$query = $this->db->insert($table, $data);

            if (!$query) {
                throw new Exception('Database Error: '.$this->db->_error_message());
            }

            return $query;
		} else {
			throw new Exception('Second param must be an array');
		}
	}
	
	/*
	 * Retrieve data using WHERE clause.
	 */
	public function selectWhere($table, $where, $columns = FALSE,
	                            $order = FALSE, $limit = FALSE, $offset = 0)
	{
		if (!is_array($where)) {
			throw new Exception('Second param must be an array.');
		}
		
		$this->db->where($where);
		
		//select columns
		if ($columns) {
			$this->db->select($columns);
		}
		
		// add order by in query
		if ($order) {
			$this->db->order_by($order);
		}
		
		// add limit in query
		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		$query = $this->db->get($table);

        if (!$query) {
            throw new Exception('Database Error: '.$this->db->_error_message());
        }

        return $query;
	}
	
	/*
	 * Retrieve all
	 */
	public function retrieve($table, $columns = FALSE, $order = FALSE,
                             $limit = FALSE, $offset = 0)
	{
		//select columns
		if ($columns) {
			$this->db->select($columns);
		}
		
		// add order by in query
		if ($order) {
			$this->db->order_by($order);
		}
		
		// add limit in query
		if ($limit) {
			$this->db->limit($limit, $offset);
		}

        $query = $this->db->get($table);

        if (!$query) {
            throw new Exception('Database Error: '.$this->db->_error_message());
        }

		return $query;
	}
	
	/*
	 * Retrieve data using join(inner, left, right, outer) statements
	 */
	public function selectJoin($table1, $table2, $on, $join_type = 'join', 
                               $columns = FALSE, $where = FALSE, $order = FALSE,
                               $limit = FALSE, $offset = 0)
	{
		if (!$columns) {
			$this->db->select('*');
		} else {
			$this->db->select($columns);
		}
		
		$this->db->from($table1);
		$this->db->join($table2, $on, $join_type);
		
		// add where in query
		if ($where && is_array($where)) {
			$this->db->where($where);
		}
		
		// add order by in query
		if ($order) {
			$this->db->order_by($order);
		}
		
		// add limit in query
		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		$query = $this->db->get();

        if (!$query) {
            throw new Exception('Database Error: '.$this->db->_error_message());
        }

        return $query;
	}
	
	public function deleteDataWhere($table, $where)
	{
		if (!is_array($where)) {
			throw new Exception('Second param must be an array.');
		}

		$this->db->where($where);
		$query = $this->db->delete($table);

        if (!$query) {
            throw new Exception('Database Error: '.$this->db->_error_message());
        }

        return $query;
	}

    public function updateData($table, $data, $where = '')
    {
        if (!is_array($data)) {
            throw new Exception('2nd param must be an array');
        }

        if (!is_array($where) && $where != '') {
            throw new Exception('3rd param must be an array');
        }

        if ($where != '') {
            $this->db->where($where);
        }

        $query = $this->db->update($table, $data);

        if (!$query) {
            throw new Exception('Database Error: '.$this->db->_error_message());
        }

        return $query;
    }
		
} // Class Common

/* EOF common.php */
/* Location ./application/models/common.php */