<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('Newses','news');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		//$data['images'] = $this->Common->get_details('event',array())->result();
		$this->load->view('admin/news/view');
	}

	public function get()
	{
		$result = $this->news->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status == 'a') {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->news_image . '" width="100px" height="100px">';
			$sub_array[] = $res->title;
			$sub_array[] = $res->description;
			$sub_array[] = $res->location;
			$sub_array[] = $res->added_date;
			$sub_array[] = $res->added_time;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/news/edit/'.$res->news_id) . '"><i class="fa fa-pencil-square-o"></i></a>';
			$sub_array[] = '<a class="btn btn-link" onclick="confirm(`Are you sure to delete this news?`)" style="font-size:24px;" href="' . site_url('admin/news/delete/'.$res->news_id) . '"><i style="color:red;" class="fa fa-trash"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->news->get_all_data(),
			"recordsFiltered" => $this->news->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		$this->load->view('admin/news/add');
	}

	public function addNews()
	{
		$title = $this->security->xss_clean($this->input->post('title'));
		$description = $this->security->xss_clean($this->input->post('description'));
		$location = $this->security->xss_clean($this->input->post('location'));

		$added_date = date('Y-m-d');
		$added_time = date('h:i A');
		$added = date('Y-m-d H:i:s');

		$array = [
			'title' => $title,
			'description' => $description,
			'location' => $location,
			'added_date' => $added_date,
			'added_time' => $added_time,
			'added' => $added,
			'status' => 'a'
		];

		if ( $id = $this->Common->insert('news',$array) ) {
			$image = $this->input->post('image');
			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/news/';
			$rand = $title . date('Ymd') . mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/news/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));

			$array1 = [
				'news_image' => $path,
				'news_id' => $id
			];

			$this->Common->insert('news_images',$array1);

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New news added..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add news..!');
		}

		redirect('admin/news');
	}

	public function editNews()
	{
		$news_id = $this->security->xss_clean($this->input->post('news_id'));

		$title = $this->security->xss_clean($this->input->post('title'));
		$description = $this->security->xss_clean($this->input->post('description'));
		$location = $this->security->xss_clean($this->input->post('location'));
		$status = $this->security->xss_clean($this->input->post('status'));


		$array = [
			'title' => $title,
			'description' => $description,
			'location' => $location,
			'status' => $status
		];

		if ( $id = $this->Common->update('news_id',$news_id,'news',$array) ) {
			$image = $this->input->post('image');
			if ($image != '') {
				$img = $this->Common->get_details('news_images',array('news_id' => $news_id))->row();
				$remove_path = FCPATH . $img->news_image;

				$img = substr($image, strpos($image, ",") + 1);

				$url = FCPATH.'uploads/news/';
				$rand = $title . date('Ymd') . mt_rand(1001,9999);
				$userpath = $url . $rand .'.png';
				$path = "uploads/news/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				$array1 = [
					'news_image' => $path
				];

				$this->Common->update('news_id',$news_id,'news_images',$array1);
				unlink($remove_path);
			}

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'News updated..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'News updation image..!');
		}

		redirect('admin/news');
	}

	public function edit($news_id)
	{
		$news = $this->Common->get_details('news',array('news_id' => $news_id));
		if ($news->num_rows() > 0) {
			$data['news'] = $this->news->getNews($news_id);
			$this->load->view('admin/news/edit',$data);
		}
		else {
			redirect('admin/news');
		}
	}

	public function delete($news_id)
	{
		if($this->Common->delete('news',array('news_id' => $news_id)))
		{
			$img = $this->Common->get_details('news_images',array('news_id' => $news_id))->row();
			$remove_path = FCPATH . $img->news_image;
			$this->Common->delete('news_images',array('news_id' => $news_id));
			unlink($remove_path);

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'News deleted successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to remove news..!');
		}

		redirect('admin/news');
	}

}
?>
