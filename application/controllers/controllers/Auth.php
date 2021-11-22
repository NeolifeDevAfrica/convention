<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {   
        parent::__construct();
    }

    public function index()
    {
        if(Login::check())
            redirect(site_url());

        if(!$this->input->post())
            return $this->form();

        $user = DB::first('users', ['id' => $this->input->post('user_id') ]);

        if(!$user){

            $this->session->set_flashdata('error', 'Authentication Failed. User not found.');
            return $this->form();
        }

        if($user->status == 'inactive'){

            $this->session->set_flashdata('error', $user->name.' is not allowed to login at the moment.');
            return $this->form();
        }

        if($user->status == 'in_session'){

            $this->session->set_flashdata('error', $user->name.' is currently logged in somewhere else. Please logout from all devices first.');
            return $this->form();
        }

        DB::update('users', ['id' => $user->id], ['status' => 'in_session']);

        $this->session->set_userdata([

            'name'      => $user->name,
            'user_id'   => $user->id
        ]);

        redirect('home');
    }

    public function logout()
    {
        DB::update('users', ['id' => $this->session->userdata('user_id')], ['status' => 'active']);
        
        Login::logout();
    }

    public function form()
    {
        $data['page']   = 'auth/index';
        $data['users']  = DB::get('users');

        $this->load->view('index', $data);
    }

}
