<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_eventsUp','eventsUpcoming');
			$this->load->model('M_eventsCo','eventsCompleted');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		//$data['images'] = $this->Common->get_details('event',array())->result();
		$this->load->view('admin/events/view');
	}

	public function get()
	{
		$result = $this->eventsUpcoming->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status) {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->ev_image . '" width="100px" height="100px">';
			$sub_array[] = $res->ev_name;
			$sub_array[] = $res->ev_description;
			$sub_array[] = $res->location;
			$sub_array[] = $res->start_date;
			$sub_array[] = $res->start_time;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/events/edit/'.$res->ev_id) . '"><i class="fa fa-pencil-square-o"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->eventsUpcoming->get_all_data(),
			"recordsFiltered" => $this->eventsUpcoming->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function completed()
	{
		$this->load->view('admin/events/completed');
	}

	public function getCompleted()
	{
		$result = $this->eventsCompleted->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status) {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->ev_image . '" width="100px" height="100px">';
			$sub_array[] = $res->ev_name;
			$sub_array[] = $res->ev_description;
			$sub_array[] = $res->location;
			$sub_array[] = $res->start_date;
			$sub_array[] = $res->start_time;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/events/edit/'.$res->ev_id) . '"><i class="fa fa-pencil-square-o"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->eventsCompleted->get_all_data(),
			"recordsFiltered" => $this->eventsCompleted->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		$this->load->view('admin/events/add');
	}

	public function addEvent()
	{
		$ev_name = $this->security->xss_clean($this->input->post('ev_name'));
		$ev_description = $this->security->xss_clean($this->input->post('ev_description'));
		$location = $this->security->xss_clean($this->input->post('location'));
		$start_date = $this->security->xss_clean($this->input->post('start_date'));
		$end_date = $this->security->xss_clean($this->input->post('end_date'));
		$start_time = $this->security->xss_clean($this->input->post('start_time'));

		$st_time = date("H:i:s",strtotime($start_time));
		$start = $start_date . " " . $st_time;

		$array = [
			'ev_name' => $ev_name,
			'ev_description' => $ev_description,
			'location' => $location,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'start_time' => $start_time,
			'st_time' => $st_time,
			'start' => $start,
			'status' => '1'
		];

		if ( $id = $this->Common->insert('events',$array) ) {
			$image = $this->input->post('image');
			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/events/';
			$rand = $ev_name . date('Ymd') . mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/events/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));

			$array1 = [
				'ev_image' => $path,
				'ev_id' => $id
			];

			$this->Common->insert('event_images',$array1);

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New event added..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add image..!');
		}

		redirect('admin/events');
	}

	public function editEvent()
	{
		$ev_id = $this->security->xss_clean($this->input->post('ev_id'));

		$ev_name = $this->security->xss_clean($this->input->post('ev_name'));
		$ev_description = $this->security->xss_clean($this->input->post('ev_description'));
		$location = $this->security->xss_clean($this->input->post('location'));
		$start_date = $this->security->xss_clean($this->input->post('start_date'));
		$end_date = $this->security->xss_clean($this->input->post('end_date'));
		$start_time = $this->security->xss_clean($this->input->post('start_time'));
		$status = $this->security->xss_clean($this->input->post('status'));

		$st_time = date("H:i:s",strtotime($start_time));
		$start = $start_date . " " . $st_time;

		$array = [
			'ev_name' => $ev_name,
			'ev_description' => $ev_description,
			'location' => $location,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'start_time' => $start_time,
			'st_time' => $st_time,
			'start' => $start,
			'status' => $status
		];

		if ( $id = $this->Common->update('ev_id',$ev_id,'events',$array) ) {
			$image = $this->input->post('image');
			if ($image != '') {
				$ev = $this->Common->get_details('event_images',array('ev_id' => $ev_id))->row();
				$remove_path = FCPATH . $ev->ev_image;

				$img = substr($image, strpos($image, ",") + 1);

				$url = FCPATH.'uploads/events/';
				$rand = $ev_name . date('Ymd') . mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path = "uploads/events/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				$array1 = [
					'ev_image' => $path
				];

				$this->Common->update('ev_id',$ev_id,'event_images',$array1);
				unlink($remove_path);
			}

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Event updated..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Event updation image..!');
		}

		redirect('admin/events');
	}

	public function edit($ev_id)
	{
		$event = $this->eventsUpcoming->getEvent($ev_id);
		if ($event->num_rows() > 0) {
			$data['event'] = $event->row();
			$this->load->view('admin/events/edit',$data);
		}
		else {
			redirect('admin/events');
		}
	}

}
?>
