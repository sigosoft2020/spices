<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directry extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('M_directory');
	}
	public function index()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));

		if ($id = getUserId($key)) {
			$directory = $this->M_directory->getDirectory();
			$return = [
				'status' => true,
				'data' => $directory,
				'message' => '',
				'user' => true
			];
		}
		else {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => '',
				'user' => false
			];
		}
		print_r(json_encode($return));
	}
	public function searchDirectory()
	{
	    $key = $_POST['keyword'];
	    if($key != '')
	    {
	       $keyword = str_replace(" ", "%", $key);
    	    $directories = $this->M_directory->search($keyword);
    
    		$return = [
    			'status' => true,
    			'data' => $directories,
    			'message' => ''
    		]; 
	    }
	    else
	    {
	        $directory = $this->M_directory->getDirectory();
	        $return = [
    			'status' => true,
    			'data' => $directory,
    			'message' => ''
    		];
	    }
	    
	    print_r(json_encode($return));
	}
}
?>
