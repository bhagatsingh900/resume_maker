<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_model extends CI_Model {
	
	public function selectOne($tbl,$where='')
	{
		$this->db->from($tbl);
		if(!empty($where)){
			$this->db->where($where);
		}
		$qry=$this->db->get();
		return $qry->result(); 
	}
	
	public function selectAll($tbl,$where='',$coloumn_name='',$order='')
	{
		$this->db->from($tbl);
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($coloumn_name)){
			$this->db->order_by($coloumn_name,$order);
		}
		$qry= $this->db->get();
		return $qry->result();		 
	} 
	
	public function insertData($tbl,$data)
	{
		$this->db->insert($tbl,$data);
		return $this->db->insert_id();
	}
	
	public function updateData($tbl,$data,$where)
	{
		$qry=$this->db->table($tbl)->where($where)->update($data);
		return $qry;
	}
	
	
}
