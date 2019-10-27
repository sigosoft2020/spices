<?php
  function admin()
  {
    $ci =& get_instance();
	  $ci->load->library('session');
	  $admin = $ci->session->userdata('admin');
    if (isset($admin)) {
      return true;
    }
    else {
      return false;
    }
  }
  function getUserId($key)
  {
    $ci =& get_instance();
    $ci->load->database();

    $value = $ci->db->select('member_id')->from('members')->where('auth',$key)->get();

    if($value->num_rows() > 0)
    {
      return $value->row()->member_id;
    }
    else {
      return false;
    }
  }
 ?>
