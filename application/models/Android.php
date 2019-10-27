<?php

class Android extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  public function loginCheck($array)
  {
    // if(is_numeric($array['username']))
    // {
    //     $array['mobile'] = $array['username'];
    //     unset($array['username']);
    // }
    // else
    // {
    //     $array['email'] = $array['username'];
    //     unset($array['username']);
    // }

    $this->db->select('member_id,username,mobile,email,auth,image,payment_status');
    $this->db->from('members');
    $this->db->where($array);
    return $this->db->get();
  }
  public function getSliders()
  {
    $this->db->select('image');
    $this->db->from('sliders');
    return $this->db->get()->result();
  }
  public function getImages()
  {
    $this->db->select('image');
    $this->db->from('gallery');
    return $this->db->get()->result();
  }
}

?>
