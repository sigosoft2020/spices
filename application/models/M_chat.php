<?php

class M_chat extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function insert($data)
  {
    $this->db->insert('messages',$data);
    return true;
  }
  function getUsername($id)
  {
    $this->db->select('member_id,username,image');
    $this->db->from('members');
    $this->db->where('member_id',$id);
    return $this->db->get()->row();
  }
  function getMessages($limit)
  {
    $this->db->select('id,message,date,username,members.member_id,image');
    $this->db->from('messages');
    $this->db->join('members','members.member_id=messages.member_id');
    $this->db->order_by('id','desc');
    $this->db->limit(10,$limit);
    return $this->db->get()->result();
  }
}

?>
