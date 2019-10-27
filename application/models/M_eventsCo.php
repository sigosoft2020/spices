<?php

class M_eventsCo extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query(){
    $today = date('Y-m-d H:i:s');

    $table = "events";
    $select_column = array("events.ev_id","ev_name","ev_description","location","start_date","end_date","start_time","start","status","ev_image");
    $order_column = array(null,"ev_name","ev_description","location","start_date","end_date",null,null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('event_images','events.ev_id=event_images.ev_id');
    $this->db->where('start <=',$today);
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      $this->db->where("(ev_name LIKE '%" . $search .  "%' OR location LIKE '%" . $search . "%')",NULL,false);
      //$this->db->like("name",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("start_date","desc");
    }
  }
  function make_datatables()
  {
    $this->make_query();
    if ($_POST["length"] != -1) {
      $this->db->limit($_POST["length"],$_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data()
  {
    $this->make_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select("*");
    $this->db->from("events");
    $this->db->where('start <=',$today);
    return $this->db->count_all_results();
  }
}

?>
