<?
defined('BASEPATH') OR exit('No direct script access allowed');
class Mybranchemployee extends CI_Controller {
	function __construct()
	{
		ob_start();
		parent::__construct();
		global $data;
		if($this->session->userdata('bemp_mail')=="" || $this->session->userdata('bemp_id')=="")
		{
			redirect("Mybranch/login");
			exit;
		}
		$bemp_id = $this->session->userdata('bemp_id');
		$this->load->model('Mybranchemployee_model');
		$this->load->model('Dashboard_model');
		$this->load->model('Mybranch_model');
		$data["roles"] = $this->Mybranchemployee_model->getAssignedRoles($bemp_id);
	}
	function index()
	{
		global $data;
		$bemp_id = $this->session->userdata('bemp_id');
		$branch_id = $this->session->userdata('branch_id');
		$branchProfile = $this->Mybranch_model->getBranchProfile($branch_id);
		$data["branch"] = $branchProfile["branch"];
		$data['bemployee'] = $this->Mybranchemployee_model->getBranchEmpProfile($bemp_id);
		$this->load->view("branchemployee/be_dashboard",$data);
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect("Mybranch/login");
		exit;
	}
	function myProfile()
	{
		global $data;
		$bemp_id = $this->session->userdata('bemp_id');
		$data['bemployee'] = $this->Mybranchemployee_model->getBranchEmpProfile($bemp_id);
		$this->load->view("branchemployee/be_profile",$data);
	}
	function saveBranchEmployeeAvatar()
	{
		if($_FILES)
		{
			$filename = $_FILES["images"]["name"];
			$config['upload_path'] = 'images/branch_employees_images';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name'] = time().$filename;
			//$config['max_size']	= '1000';
			//$config['max_width'] = '1024';
			//$config['max_height'] = '768';
			$this->load->library('upload', $config);
			if($this->upload->do_upload("images"))
			{
				$updata = $this->upload->data();
				//$this->load->library('image_lib');
				$rconfig['image_library'] = 'gd2';
				$rconfig['source_image']	= 'images/branch_employees_images/'.$this->upload->file_name;
				$rconfig['new_image']	= 'images/branch_employees_images/thumbs/'.$this->upload->file_name;
				$rconfig['create_thumb'] = TRUE;
				$rconfig['thumb_marker'] = "";
				$rconfig['maintain_ratio'] = TRUE;
				$rconfig['width']	= 230;
				$rconfig['height']	= 230;
				 
				$this->load->library('image_lib');
				$this->image_lib->initialize($rconfig); 
				if($this->image_lib->resize())
				{
					$bemp_id = $this->session->userdata('bemp_id');
					$this->Mybranchemployee_model->saveBranchEmployeeAvatar($bemp_id,$this->upload->file_name);
					echo base_url($rconfig['new_image']);
				}
				$this->image_lib->clear();
			}
			else	
			echo "0";
			die;
		}
	}
	function saveBranchEmployeeProfile()
	{
		if($this->input->post())
		{
			
			$bemp_id = $this->session->userdata('bemp_id');
			$this->Mybranchemployee_model->saveBranchEmployeeProfile($this->input->post(),$bemp_id);
			echo "Success";
		}
	}
	function changepassword()
	{
		global $data;
		$bemp_id = $this->session->userdata('bemp_id');
		if($this->input->post()){
			$rdata=$this->Mybranchemployee_model->changepassword($bemp_id, $this->input->post());
			$data['errorMsg']=$rdata['errorMsg'];
		}
		$data['bemployee'] = $this->Mybranchemployee_model->getBranchEmpProfile($bemp_id);	
		$this->load->view("branchemployee/changepassword",$data);
	}
	public function addEditUser()
	{		
		if($this->input->post()){	
			if($this->input->post["userid"]=="")
			{
				$to = $this->input->post['user_email'];
				$subject ="Mep Registration confirmation";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: admin@mepcentre.com" . "\r\n";
				$msg=$this->load->view('emailtemplates/coursereg','',true);
				//var_dump($msg); die;
				$patterns = array();
				$patterns[0] = '/<<firstname>>/'; 
				$patterns[1] = '/<<email>>/';   
				$replacements = array();
				$replacements[1] = $this->input->post["firstname"].' '.$this->input->post["lastname"];  
				$replacements[0] = $to;
				$msg = preg_replace($patterns, $replacements, $msg);
				mail($to, $subject, $msg, $headers);  
			}
			echo $this->Dashboard_model->insertuser();  
			
		}		
	}
	public function undeleteUser()
	{
		if($this->input->post()){
			echo $this->Dashboard_model->undeleteUser($this->input->post('uid'));
		}
	}
	public function deleteuser()
	{
			//var_dump($this->input->post());die;
			if($this->input->post())
			{
				$result	=$this->Dashboard_model->deleteuser($this->input->post("tids"));
				echo $result;
			}  
			else
			echo "Permission Denied";
	}

	function viewJob()
	{
		if($this->input->post())
		{
			$cid = $this->input->post("cid");
			echo json_encode($this->Mybranch_model->viewJob($cid));
		}
	}
	function trashBranchJobPosting()
	{
		if($this->input->post())
		{
			$job_id = $this->input->post("cid");
			return $this->Mybranchemployee_model->trashBranchJobPosting($job_id);
		}
		else
			return 0;
	}
	function saveJobPosting()
	{
		if($this->input->post() && $this->session->userdata('bemp_id')!='')
		{
			$bemp_id = $this->session->userdata('bemp_id');
			$this->Mybranchemployee_model->saveJobPosting($bemp_id, $this->input->post());
		}
	}
	function searchStudent()
	{
		$rows=array();
		if(isset($_GET['term']))
		{
			$students =  $this->Mybranchemployee_model->searchStudent(strip_tags($_GET['term']));
			foreach($students as $student){
				$rows[] = array(
					"studentid" => $student->userid,
					"label" => $student->firstname.' '.$student->lastname,
					"value" => $student->firstname.' '.$student->lastname,
					"email" => $student->email,
					"mobile" => $student->mobile,
					"desc" => "Email:".$student->email.' '."Mobile".$student->mobile,
					"rpoints"=>$student->points,
					"user_avatar"=>$student->user_avatar
				);
			}
		}
		echo json_encode($rows);
	}
	function getCourseBookingSchemes()
	{
		if($this->input->post())
		{
			$rows = $this->Mybranch_model->getCourseBookingSchemes($this->input->post());
			echo json_encode($rows);
		}
	}
	function saveCBBSchemes()
	{
		if($this->input->post())
			$this->Mybranch_model->saveCBBSchemes($this->input->post());
	}
}
?>