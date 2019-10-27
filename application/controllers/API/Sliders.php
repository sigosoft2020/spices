<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sliders extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Android');
	}
	public function index()
	{
		$sliders = $this->Android->getSliders();
		foreach($sliders as $slider)
		{
		    $slider->image = base_url() . $slider->image;
		}
		$return = [
			'status' => true,
			'data' => $sliders,
			'message' => ''
		];
		print_r(json_encode($return));
	}
}
?>
