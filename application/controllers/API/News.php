<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Newses','news');
	}
	public function getNewses()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$newses = $this->news->getNewses();
			foreach($newses as $news)
			{
			    $news->news_images = $this->news->getImages($news->news_id);
			}
			$newses = $this->sort($newses);
			$return = [
				'status' => true,
				'data' => $newses,
				'message' => '',
				'user' => true,
			];
		}
		else {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}

		print_r(json_encode($return));

	}


	public function changeformat($date)
	{
		$format = date("d-m-Y",strtotime($date));
		$array = explode("-",$format);
		$final = $array[1] . "-" . $array[2];

		return $final;
	}

    function sort($newses)
    {
      $start_date = $newses[0]->added_date;
      $date = $this->changeformat($start_date);

      $data = [];
      foreach($newses as $news)
      {
        $start = $this->changeformat($news->added_date);
        if($date == $start)
        {
          $data[$date][] = $news;
        }
        else
        {
          $date = $this->changeformat($news->added_date);
      	  $data[$date][] = $news;
        }
      }
      return $data;
    }
}
?>
