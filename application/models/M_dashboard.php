<?php

class M_dashboard extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function getNumberOfUpcomingEvents()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('*');
    $this->db->from('events');
    $this->db->where('start >=',$today);
    return $this->db->get()->num_rows();
  }
  function getNumberOfCompletedEvents()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('*');
    $this->db->from('events');
    $this->db->where('start <=',$today);
    return $this->db->get()->num_rows();
  }
  function getActiveMembers()
  {
    $this->db->select('*');
    $this->db->from('members');
    $this->db->where('status',1);
    return $this->db->get()->num_rows();
  }
  function getActivePolls()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('*');
    $this->db->from('polls');
    $this->db->where('ts >=',$today);
    return $this->db->get()->num_rows();
  }
  function getCompletedPolls()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('*');
    $this->db->from('polls');
    $this->db->where('ts <=',$today);
    $this->db->order_by('poll_id','desc');
    $this->db->limit(4);
    return $this->db->get()->result();
  }
  function getActiveMembers5()
  {
    $this->db->select('member_id,username,email,mobile,image');
    $this->db->from('members');
    $this->db->where('status',1);
    $this->db->order_by('member_id','desc');
    $this->db->limit(5);
    return $this->db->get()->result();
  }
}

?>
