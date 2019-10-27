<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
			$this->load->model('Android');
	}
	public function index()
	{
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$password = $this->security->xss_clean($this->input->post('password'));

		$array = [
			'mobile' => $mobile,
			'password' => md5($password)
		];

		$check = $this->Android->loginCheck($array);

		if ($check->num_rows() > 0) {

		    $success = $check->row();
		    $auth_old = $success->auth;
		    if($success->image != '')
		    {
		        $success->image = base_url() . $success->image;
		    }
		    
		    $auth = $this->getKey();

		    if($this->Common->update('member_id',$success->member_id,'members',array('auth' => $auth)))
		    {
		        $success->auth = $auth;
		    }
		    
		    $this->sendNotification($auth_old);
		    
		    $fee = $this->Common->get_details('registration_fee',array('rf_id' => 1))->row()->fee;
		    $success->fee = $fee;

			$return = [
				'status' => true,
				'data' => $success,
				'message' => 'Login success'
			];
		}
		else {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => 'Invalid username or password'
			];
		}

		print_r(json_encode($return));
	}

	public function resetPassword()
	{
		$password = $this->security->xss_clean($this->input->post('password'));
		$key = $this->security->xss_clean($this->input->post('auth'));

		if ($id = getUserId($key)) {
			$pass = [
				'password' => md5($password)
			];
			if ($this->Common->update('member_id',$id,'members',$pass)) {
				$return = [
					'status' => true,
					'data' => array(),
					'message' => 'Password changed successfully..!',
					'user' => true
				];
			}
			else {
				$return = [
					'status' => false,
					'data' => array(),
					'message' => 'Failed to update password..!',
					'user' => true
				];
			}
		}
		else {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => 'Failed to update password..!',
				'user' => false
			];
		}

		print_r(json_encode($return));
	}

	public function mobileCheck()
	{
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$array = [
			'mobile' => $mobile
		];

		$check = $this->Common->get_details('members',$array);

		if ($check->num_rows() > 0) {
			$user = $check->row();

			$return = [
				'status' => true,
				'data' => [
					'mobile' => true,
					'auth' => $user->auth
				],
				'message' => ''
			];
		}
		else {
			$return = [
				'status' => false,
				'data' => [
					'mobile' => false,
					'auth' => false
				],
				'message' => ''
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
				    if($user->image != '')
				    {
				        unlink($image_path);
				    }
				    $this->Common->update('member_id',$id,'members',array('image' => $path));
						$return = [
							'status' => true,
							'data' => $path,
							'message' => 'Profile image uploaded successfully..!',
							'user' => true
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
				$return = [
					'status' => false,
					'data' => '',
					'message' => 'Choose an image file',
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
	public function checkMobile()
	{
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$check = $this->Common->get_details('members',array('mobile' => $mobile));
		if ($check->num_rows() > 0) {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => 'Mobile number already registered..!'
			];
		}
		else {
			$return = [
				'status' => true,
				'data' => array(),
				'message' => ''
			];
		}

		print_r(json_encode($return));
	}
	
	public function checkEmail()
	{
		$email = $this->security->xss_clean($this->input->post('email'));

		$check = $this->Common->get_details('members',array('email' => $email));
		if ($check->num_rows() > 0) {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => 'Email address already registered..!'
			];
		}
		else {
			$return = [
				'status' => true,
				'data' => array(),
				'message' => ''
			];
		}

		print_r(json_encode($return));
	}
	public function sendNotification($auth)
	{
		$SERVER_API_KEY = "AIzaSyCm131OryoKDslBi4hQgzyBEy-ljLxbHz0";

		$to = "/topics" . "/" . $auth;

		$header = [
			'Authorization: key='. $SERVER_API_KEY,
			'Content-Type: Application/json'
		];

		$notification = [
			'title' => 'Temperory setup',
			'body' => 'Testing notification',
			'content_available' => true
		];

		$data = [
			'title' => 'Temperory setup',
			'body' => 'Testing notification',
			'data' => [
				'auth' => $auth,
				'message' => 'Your session is expired, Please login again'
			]
		];

		$payload = [
			'data' => $data,
			'notification' => $notification,
			'to' => $to,
			'priority' => 10
		];

		$url = 'https://fcm.googleapis.com/fcm/send';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			 CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			 CURLOPT_RETURNTRANSFER => true,
			 CURLOPT_CUSTOMREQUEST => "POST",
			 CURLOPT_POSTFIELDS => json_encode($payload),
			 CURLOPT_HTTPHEADER => $header,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return true;

	}
}
?>
