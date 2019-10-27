<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Upcoming','up');
			$this->load->model('Completed','completed');
			$this->load->model('Cancelled','cancelled');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function upcoming()
	{
		$this->load->view('admin/bookings/upcoming');
	}
	public function getUpcoming()
	{
		$result = $this->up->make_datatables();
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->up->get_all_data(),
			"recordsFiltered" => $this->up->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function completed()
	{
		$this->load->view('admin/bookings/completed');
	}
	public function getCompleted()
	{
		$result = $this->completed->make_datatables();
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->completed->get_all_data(),
			"recordsFiltered" => $this->completed->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function cancelled()
	{
		$this->load->view('admin/bookings/cancelled');
	}
	public function getCancelled()
	{
		$result = $this->cancelled->make_datatables();
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->cancelled->get_all_data(),
			"recordsFiltered" => $this->cancelled->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function check()
	{
		$today = date('Y-m-d H:i:s');
		$test = $this->up->check($today);

		//print_r(json_encode($test));
		echo $today;
	}

	public function details($book_id)
	{
		$book = $this->Common->get_details('bookings',array('book_id' => $book_id))->row();
		$data['turf'] = $this->Common->get_details('turfs',array('turf_id' => $book->turf_id))->row();
		if ($book->voucher_status == '1') {
			$data['voucher'] = $this->Common->get_details('voucher_apply',array('book_id' => $book_id))->row()->code;
		}
		else {
			$data['voucher'] = false;
		}
		$data['user'] = $this->Common->get_details('users',array('user_id' => $book->user_id))->row();
		$data['book'] = $book;

		$this->load->view('admin/bookings/details',$data);
	}
}
?>
