<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Android');
	}
	public function index()
	{
		$images = $this->Android->getImages();
		foreach($images as $image)
		{
		    $image->image = base_url() . $image->image;
		}
		$return = [
			'status' => true,
			'data' => $images,
			'message' => ''
		];
		print_r(json_encode($return));
	}
}
?>
