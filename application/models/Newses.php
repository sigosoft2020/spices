<?php

class Newses extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function getNewses()
  {
    $this->db->select('news_id,title,description,location,added_date,added_time,added,status');
    $this->db->from('news');
    $this->db->where('status','a');
    $this->db->order_by('added_date','asc');
    return $this->db->get()->result();
  }
  function getImages($news_id)
  {
    $this->db->select('news_image');
    $this->db->from('news_images');
    $this->db->where('news_id',$news_id);
    $results = $this->db->get()->result();

    foreach($results as $result)
    {
        $result->news_image = base_url() . $result->news_image;
    }
    return $results;
  }
  
  function make_query(){
    $today = date('Y-m-d H:i:s');

    $table = "news";
    $select_column = array("news.news_id","title","description","location","added_date","added_time","status","news_image");
    $order_column = array(null,"title","description","location",null,null,null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('news_images','news.news_id=news_images.news_id','left outer');
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      $this->db->where("(title LIKE '%" . $search .  "%' OR description LIKE '%" . $search . "%')",NULL,false);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("news_id","desc");
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
    $this->db->from("news");
    return $this->db->count_all_results();
  }

  function getNews($news_id)
  {
    $this->db->select('news.news_id,title,description,location,status,news_image');
    $this->db->from('news');
    $this->db->join('news_images','news.news_id=news_images.news_id','left outer');
    $this->db->where('news.news_id',$news_id);
    return $this->db->get()->row();
  }
}

?>
