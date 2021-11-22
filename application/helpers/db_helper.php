<?php

/*
	@AUTHOR: olaiya segun

*/
	
	class DB  
	{
		static function updateOrCreate($table = null, $data = null, $where = null)
		{
			$CI = & get_instance();
			if($where != null && is_array($where)){

				if($CI->db->get_where($table, $where)->num_rows() > 0)
					return $CI->db->where($where)->update($table, $data);

			}

			$CI->db->insert($table, $data);
			return $CI->db->insert_id();

		}

		static function create($table = null, $data = null)
		{
			$CI = & get_instance();

			$CI->db->insert($table, $data);
			return $CI->db->insert_id();
		}

		static function firstOrNew($table = null, $where = null)
		{
			$CI = & get_instance();
			$tuple = null;

			if($where != null && is_array($where))
				$tuple = $CI->db->get_where($table, $where)->row();

			if($tuple == null){

				foreach($CI->db->list_fields($table) as $row)
					$tuple[$row] = '';

				$tuple = (object)$tuple;
			}

			return $tuple;
		}

		static function first($table = null, $where = null)
		{
			$CI = & get_instance();
			if($where != null && is_array($where))
				return $CI->db->get_where($table, $where)->row();

			return n;
		}


		static function has($table = null, $field = null, $value = null)
		{
			$CI = & get_instance();
			return $CI->db->get_where($table, [$field=>$value])->num_rows() > 0 ? true : false;
		}

		static function contains($table = null, $where = null)
		{
			$CI = & get_instance();
			return $CI->db->get_where($table, $where)->num_rows() > 0 ? true : false;
		}


		static function count($table = null, $where = null)
		{
			$CI = & get_instance();
			return $CI->db->get_where($table, $where)->num_rows();
		}

		static function update($table='', $where=[], $data = [])
		{
			$CI = & get_instance();
			$CI->db->where($where);
			$CI->db->update($table, $data);
			
			return $CI->db->affected_rows() > 0;
		}

		static function delete($table='', $where=[])
		{
			$CI = & get_instance();
			$CI->db->where($where);
			$CI->db->delete($table);
			
			return $CI->db->affected_rows() > 0;
		}

		static function sum($table = null, $field = null, $where = [])
		{
			$CI = & get_instance();
			return $CI->db->where($where)->select_sum($field, 'sum')->get($table)->result()[0]->sum;
		}

		//Backward Compatibility Purposes

		static function save($table = '', $data = [])
		{
			$CI = & get_instance();
			$CI->db->insert($table, $data);
			return $CI->db->insert_id();
		}

		static function get($table = '',$where = [], $orderfield = '', $ordercode='', $limit = 0, $offset = 0)
		{
			$CI = & get_instance();
			if(!empty($orderfield) && !empty($ordercode))
				$CI->db->order_by($orderfield, $ordercode);
			if($limit > 0 && $offset >= 0)
				$CI->db->limit($limit, $offset);
			if(!empty($where))
				return $CI->db->get_where($table, $where)->result();

			return $CI->db->get($table)->result();
		}

		static function getArray($table = '', $orderfield = '', $ordercode='', $limit = '', $offset = '', $where=[])
		{
			$CI = & get_instance();
			if(!empty($orderfield) && !empty($ordercode))
				$CI->db->order_by($orderfield, $ordercode);
			if($limit > 0 && $offset >= 0)
				$CI->db->limit($limit, $offset);
			if(!empty($where))
				return $CI->db->get_where($table, $where)->result_array();

			return $CI->db->get($table)->result_array();
		}

		static function getRow($table='', $where=[], $want_array = FALSE)
		{
			$CI = & get_instance();
			$query = $CI->db->get_where($table, $where);
			if($query->num_rows() > 0){
				if($want_array)			{
					return $query->result_array();
				}else{
					return $query->row();
				}
			}
			else
				return false;
		}

		

		static function getCell($table='', $where=[], $cell='')
		{
			$CI = & get_instance();
			$query = $CI->db->get_where($table, $where);
			if($query->num_rows() > 0)
				return $query->row()->$cell;
			else
				return '';
		}

		static function itExists($table='', $field='', $value='')
		{
			$CI = & get_instance();
			$query = $CI->db->get_where($table, [$field=>$value]);
			if($query->num_rows() > 0)
				return TRUE;
			else
				return FALSE;
		}


		static function numRows($table = '', $where=[])
		{
			$CI = & get_instance();
			return $CI->db->get_where($table, $where)->num_rows();
		}

		static function tableSum($table = '', $field = '', $where=[])
		{
			$CI = & get_instance();
			$CI->db->where($where);
			$CI->db->select_sum($field, 'sum');
			return $CI->db->get($table)->result()[0]->sum;
		}

		static function tableMax($table = '', $field = '')
		{
			$CI = & get_instance();
			$CI->db->select_max($field, 'max');
			return $CI->db->get($table)->result()[0]->max;
		}
	/*
		@$base_table : Table to get from
		@$link : eg ID, field to use for join
		@$join: array of tables to join to.
		@$where : where clause if any.
	 */
		static function tableJoin($base_table = '', $link = '', $joins = [], $where = [], $return_array = FALSE)
		{
			if($base_table == '' || $link == '' || count($joins) < 1)
				return FALSE;

			$CI = & get_instance();

			for($i = 0; $i<count($joins); $i++){
				$CI->db->join($joins[$i], $joins[$i].'.'.$link.'='.$base_table.'.'.$link);
			}

			if(count($where) > 0){
				$CI->db->where($where);
			}

			if($return_array == TRUE){
				return $CI->db->get($base_table)->result_array();
			}

			return $CI->db->get($base_table)->result();

		}

	}
