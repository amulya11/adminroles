<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct(){
         parent::__construct();
		$this->load->helper('url');
         //$this->load->model('Users_model'); //Load the Model here   

 }
	public function index()
	{
		$data['name'] = 'amulya';
		$this->load->view('welcome_message',$data);
	}
	public function showpage() {
		$this->load->view('show_message');
		
	}
}
