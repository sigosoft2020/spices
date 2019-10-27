<?php

class M_directory extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function getDirectory()
  {
    $this->db->select('member_id,username,mobile,email');
    $this->db->from('members');
    $this->db->where('status','1');
    return $this->db->get()->result();
  }
  function search($keyword)
  {
    $this->db->select('member_id,username,mobile,email');
    $this->db->from('members');
    $this->db->where("username LIKE '%$keyword%' OR mobile LIKE '%$keyword%' OR email LIKE '%$keyword%'");
    return $this->db->get()->result();
  }
}

?>
