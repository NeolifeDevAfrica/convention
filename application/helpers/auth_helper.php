<?php

class Login {


	static function check(){

		$CI = & get_instance();

		if(isset($_SESSION['user_id']))
			return true;

		return $CI->session->has_userdata('user_id') && $CI->session->userdata('user_id') > 0;
	}

	static function logout(){

		$CI = & get_instance();
		unset($_SESSION['user_id']);
		$CI->session->sess_destroy();

		redirect('auth');
	}

}
