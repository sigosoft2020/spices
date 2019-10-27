<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}
	public function edit()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {

			$mCheck = true;
			$eCheck = true;

			$mobile = $this->security->xss_clean($this->input->post('mobile'));
			$email = $this->security->xss_clean($this->input->post('email'));
			$name = $this->security->xss_clean($this->input->post('name'));

			$mobileCheck = $this->Common->get_details('members',array('member_id!=' => $id,'mobile' => $mobile))->num_rows();
			$emailCheck = $this->Common->get_details('members',array('member_id!=' => $id,'email' => $email))->num_rows();

			if ($mobileCheck > 0) {
				$mCheck = false;
			}
			if ($emailCheck > 0) {
				$eCheck = false;
			}

			if ($mCheck && $eCheck) {

				$array = [
					'mobile' => $mobile,
					'email' => $email,
					'username' => $name
				];

				if ($this->Common->update('member_id',$id,'members',$array)) {
					$return = [
						'status' => true,
						'data' => '',
						'message' => 'Profile updated..!',
						'user' => true
					];
				}
				else {
					$return = [
						'status' => false,
						'data' => '',
						'message' => 'Failed to update profile informations..!',
						'user' => true
					];
				}
			}
			else {
			    
			    if(!$mCheck && !$eCheck)
    		    {
    		        $message = "Mobile number and Email address already registered..!";
    		    }
    		    else
    		    {
    		        if(!$mCheck)
    		        {
    		            $message = "Mobile number already registered..!";
    		        }
    		        if(!$eCheck)
    		        {
    		            $message = "Email address already registered..!";
    		        }
    		    }
			    
				$return = [
					'status' => false,
					'data' => '',
					'message' => $message,
					'user' => true
				];
			}
		}
		else {
			$return = [
				'status' => false,
				'data' => '',
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}

		print_r(json_encode($return));
	}
	public function getProfileDetails()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$details = $this->Common->get_details('members',array('member_id' => $id))->row();
			$fee = $this->Common->get_details('registration_fee',array('rf_id' => 1))->row()->fee;
			if($details->image != '')
			{
			    $image = base_url() . $details->image;
			}
			else
			{
			    $image = '';
			}
			$return = [
				'status' => true,
				'data' => [
					'username' => $details->username,
					'email' => $details->email,
					'mobile' => $details->mobile,
					'auth' => $details->auth,
					'image' => $image,
					'member_id' => $details->member_id,
					'payment_status' => $details->payment_status,
					'fee' => $fee
				],
				'message' => '',
				'user' => true
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
	
	public function mobileEdit()
	{
	    $key = $this->security->xss_clean($this->input->post('auth'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		if ($id = getUserId($key)) {
			$check = $this->Common->get_details('members',array('mobile' => $mobile , 'member_id !=' => $id));
			if ($check->num_rows() > 0) {
				$return = [
					'status' => false,
					'data' => '',
					'message' => 'Mobile number already registered..!',
					'user' => true
				];
			}
			else {
				$return = [
					'status' => true,
					'data' => '',
					'message' => '',
					'user' => true
				];
			}
		}
		else {
			$return = [
				'status' => false,
				'data' => '',
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}

		print_r(json_encode($return));
	}

	public function emailEdit()
	{
	    $key = $this->security->xss_clean($this->input->post('auth'));
		$email = $this->security->xss_clean($this->input->post('email'));
		if ($id = getUserId($key)) {
			$check = $this->Common->get_details('members',array('email' => $email , 'member_id !=' => $id));
			if ($check->num_rows() > 0) {
				$return = [
					'status' => false,
					'data' => '',
					'message' => 'Email address already registered..!',
					'user' => true
				];
			}
			else {
				$return = [
					'status' => true,
					'data' => '',
					'message' => '',
					'user' => true
				];
			}
		}
		else {
			$return = [
				'status' => false,
				'data' => '',
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}

		print_r(json_encode($return));
	}

    function changeProfileImage()
	{
		$image = $this->security->xss_clean($this->input->post('image'));
		$key = $this->security->xss_clean($this->input->post('auth'));

		if ($id = getUserId($key)) {
			$user = $this->Common->get_details('members',array('member_id' => $id))->row();
			$image_path = FCPATH . $user->image;
			if ($image != '') {
				$url = FCPATH.'uploads/profile/';
				$rand='user'.date('Ymd').mt_rand(1001,9999);
				$userpath = $url . $rand.'.png';
				$path = "uploads/profile/".$rand.'.png';
				if (file_put_contents($userpath,base64_decode($image))) {
				    if($user->image != 'uploads/profile/user.png')
				    {
				        unlink($image_path);
				    }
				    $this->Common->update('member_id',$id,'members',array('image' => $path));
						$return = [
							'status' => true,
							'data' => base_url() . $path,
							'message' => 'Profile image uploaded successfully..!',
							'user' => true,
						];
				}
				else {
					$return = [
						'status' => false,
						'data' => '',
						'message' => 'Failed to upload profile image..!',
						'user' => true
					];
				}
			}
			else {
			    unlink($image_path);
			    $array = [
			      'image' => ''  
			    ];
			    if($this->Common->update('member_id',$id,'members',$array))
			    {
			        $return = [
    					'status' => true,
    					'data' => '',
    					'message' => 'Profile image removed successfully..!',
    					'user' => true
				    ];
			    }
			    else
			    {
			        $return = [
    					'status' => false,
    					'data' => '',
    					'message' => 'Failed to remove profile image..!',
    					'user' => true
				    ];
			    }
			}

		}
		else {
			$return = [
				'status' => false,
				'data' => '',
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}

		print_r(json_encode($return));
	}
	public function makePayment()
	{
	    $key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
		    $payment_id = $this->security->xss_clean($this->input->post('payment_id'));
		    $payment = $this->security->xss_clean($this->input->post('fee'));
		    
		    $date = date('Y-m-d');
		    $time = date('h:i A');
		    
		    $array = [
		      'payment' => $payment,
		      'payment_id' => $payment_id,
		      'date' => $date,
		      'time' => $time,
		      'member_id' => $id
		    ];
		    
		    if($this->Common->insert('payments',$array))
		    {
		        $this->Common->update('member_id',$id,'members',array('payment_status' => 1));
		        $return = [
    				'status' => true,
    				'data' => '',
    				'message' => 'Payment completed..!',
    				'user' => true
    			];
		    }
		    else
		    {
		        $return = [
    				'status' => false,
    				'data' => '',
    				'message' => 'Payment failed , please try again later..!',
    				'user' => true
    			];
		    }
		}
		else
		{
		    $return = [
				'status' => false,
				'data' => '',
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}
		
		print_r(json_encode($return));
	}
		
}
?>
