<?php

class Event extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function getUpcoming()
  {
    $today = date('Y-m-d');

    //$this->db->distinct();
    $this->db->select('ev_id,ev_name,ev_description,location,start_date,end_date,start_time');
    $this->db->from('events');
    //$this->db->join('event_images','events.ev_id=event_images.ev_id');
    $this->db->where('end_date >=',$today);
    $this->db->where('status','1');
    //$this->db->group_by('event_images.ev_id');
    $this->db->order_by("events.end_date", "asc");
    return $this->db->get()->result();
  }
  function getPast()
  {
    $today = date('Y-m-d');

    //$this->db->distinct();
    $this->db->select('ev_id,ev_name,ev_description,location,start_date,end_date,start_time');
    $this->db->from('events');
    //$this->db->join('event_images','events.ev_id=event_images.ev_id');
    $this->db->where('end_date <',$today);
    $this->db->where('status','1');
    //$this->db->group_by('event_images.ev_id');
    $this->db->order_by("events.end_date", "asc");
    return $this->db->get()->result();
  }
  function getImages($ev_id)
  {
      $this->db->select('ev_image');
      $this->db->from('event_images');
      $this->db->where('ev_id',$ev_id);
      $results = $this->db->get()->result();
      foreach($results as $result)
      {
          $result->ev_image = base_url() . $result->ev_image;
      }
      return $results;
  }
}

?>
