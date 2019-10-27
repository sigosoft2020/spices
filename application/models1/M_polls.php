<?php

class M_polls extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function upcoming()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('polls.poll_id,question');
    $this->db->from('polls');
    $this->db->where('ts >',$today);
    $this->db->where('status','1');
    return $this->db->get()->result();
  }
  function checkPoll($id,$poll_id)
  {
    $this->db->select('opt_id');
    $this->db->from('results');
    $this->db->where('poll_id',$poll_id);
    $this->db->where('member_id',$id);
    $get = $this->db->get();

    if ($get->num_rows() > 0) {
      return $get->row()->opt_id;
    }
    else {
      return false;
    }
  }
  function getOptions($poll_id)
  {
    $this->db->select('opt_id,option_name');
    $this->db->from('poll_options');
    $this->db->where('poll_id',$poll_id);
    $get = $this->db->get()->result();
    return $get;
  }
  function completed()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('polls.poll_id,question');
    $this->db->from('polls');
    $this->db->where('ts <=',$today);
    $this->db->where('status','1');
    return $this->db->get()->result();
  }
  function getTotal($poll_id)
  {
    $this->db->select('*');
    $this->db->from('results');
    $this->db->where('poll_id',$poll_id);
    return $this->db->count_all_results();
  }
  function getTotalOfOption($opt_id)
  {
    $this->db->select('*');
    $this->db->from('results');
    $this->db->where('opt_id',$opt_id);
    return $this->db->count_all_results();
  }
}

?>
