<?php

class M_members extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query(){
    $table = "members";
    $select_column = array("member_id","username","mobile","email","image","status","payment_status");
    $order_column = array(null,"membername","mobile","email",null,null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    if (isset($_POST["search"]["value"])) {
      $this->db->like("username",$_POST["search"]["value"]);
      $this->db->or_like("mobile",$_POST["search"]["value"]);
      $this->db->or_like("email",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("member_id","desc");
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
    $this->db->select("*");
    $this->db->from("members");
    return $this->db->count_all_results();
  }
}

?>
