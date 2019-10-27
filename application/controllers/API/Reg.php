<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}
	public function index()
	{
		$username = $this->security->xss_clean($this->input->post('name'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$password = $this->security->xss_clean($this->input->post('password'));

		$mobileCheck = true;
		$emailCheck = true;
		//$checkUserName = true;

		$checkMobile = $this->Common->get_details('members',array('mobile' => $mobile))->num_rows();
		$checkEmail = $this->Common->get_details('members',array('email' => $email))->num_rows();
		//$checkUserName = $this->Common->get_details('users',array('username' => $username))->num_rows();

		if ( $checkMobile > 0 ) {
			$mobileCheck = false;
		}
		if ( $checkEmail > 0 ) {
			$emailCheck = false;
		}
		// if ($checkUserName > 0) {
		// 	$checkUserName = false;
		// }

		if($mobileCheck && $emailCheck)
		{
			$array = [
				'username' => $username,
				'email' => $email,
				'mobile' => $mobile,
				'password' => md5($password),
				'auth' => $this->getKey(),
				'image' => 'uploads/profile/user.png',
				'payment_status' => 0
			];

			if ($id = $this->Common->insert('members',$array)) {
				unset($array['password']);
				//$array['emailCheck'] = $emailCheck;
				//$array['mobileCheck'] = $mobileCheck;
				$fee = $this->Common->get_details('registration_fee',array('rf_id' => 1))->row()->fee;
				$array['member_id'] = $id;
				$array['fee'] = $fee;
				$return = [
					'status' => true,
					'data' => $array,
					'message' => 'Registration completed..!'
				];
			}
			else {
				$return = [
					'status' => false,
					'data' => array(),
					'message' => 'Registration failed , Please try again later..!'
				];
			}
		}
		else {
		    if(!$mobileCheck && !$emailCheck)
		    {
		        $message = "Mobile number and Email address already registered..!";
		    }
		    else
		    {
		        if(!$mobileCheck)
		        {
		            $message = "Mobile number already registered..!";
		        }
		        if(!$emailCheck)
		        {
		            $message = "Email address already registered..!";
		        }
		    }
			$return = [
				'status' => false,
				'data' => array(),
				'message' => $message
			];
		}

		print_r(json_encode($return));

	}

	function getKey() {
		while (true) {
			$key = $this->key();
			$cond = [
				'auth' => $key
			];

			$check = $this->Common->get_details('members',$cond);

			if ($check->num_rows() == 0) {
				break;
			}
		}
		return $key;
  }

	function key()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
		return $randomString;
	}

	public function resetPassword()
	{
	  $old = $this->security->xss_clean($this->input->post('old_password'));
		$password = $this->security->xss_clean($this->input->post('password'));
		$key = $this->security->xss_clean($this->input->post('auth'));

		if ($id = getUserId($key)) {
		    $check = $this->Common->get_details('members',array('member_id' => $id , 'password' => md5($old)))->num_rows();
		    if($check > 0)
		    {
		        $pass = [
				    'password' => md5($password)
    			];
    			if ($this->Common->update('member_id',$id,'members',$pass)) {
    				$return = [
    					'status' => true,
    					'data' => '',
    					'message' => 'Password changed successfully..!',
    					'user' => true
    				];
    			}
    			else {
    				$return = [
    					'status' => false,
    					'data' => '',
    					'message' => 'Failed to update password..!',
    					'user' => true
    				];
    			}
		    }
		    else
		    {
		        $return = [
    				'status' => false,
    				'data' => '',
    				'message' => 'Incorrect password..!',
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


}
?>
