<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Event');
	}
	public function getUpcoming()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$events = $this->Event->getUpcoming();
			foreach($events as $event)
			{
			    $event->event_images = $this->Event->getImages($event->ev_id);
			}
			$events = $this->sort($events);
			$return = [
				'status' => true,
				'data' => $events,
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
	public function getPast()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
    		$events = $this->Event->getPast();
    		foreach($events as $event)
			{
			    $event->event_images = $this->Event->getImages($event->ev_id);
			}
    		$events = $this->sort($events);
    		$return = [
				'status' => true,
				'data' => $events,
				'message' => '',
				'user' => true,
			];
		}
		else {
			$return = [
				'status' => true,
				'data' => array(),
				'message' => '',
				'user' => false,
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
	
    function sort($evs)
    {
      $start_date = $evs[0]->start_date;
      $date = $this->changeformat($start_date);

      $data = [];
      foreach($evs as $event)
      {
        $start = $this->changeformat($event->start_date);
        if($date == $start)
        {
          $data[$date][] = $event;
        }
        else
        {
          $date = $this->changeformat($event->start_date);
      	  $data[$date][] = $event;
        }
      }
      return $data;
    }
}
?>
