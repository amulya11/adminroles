<?php
class Mybranch_model extends CI_Model {
	function __construct(){
		parent::__construct();

	}
	function getAllBranches()
	{
		return $this->db->get("mep_tb_Branches")->result();
	}
	function branchLogin($data)
	{
		$this->db->where("email_addr",$data["email"]);
		$this->db->where("branch_id",$data["branch"]);
		$this->db->where("password",$data["password"]);
		$rows = $this->db->get("branch_admin");
		if($rows->num_rows()>0)
		{
			$sql = "select *from mep_tb_Branches where BranchId=".$data["branch"]." and Email='".$data["email"]."' and status=1";
			
			if($this->db->query($sql)->num_rows()>0)
			{
				$result = $rows->result();
				$this->session->set_userdata(array("badmin_id"=>$result[0]->ba_id));
				return $result[0]->status;
			}
			else
				return -1;
			
		}
		else return 0;
		
	}
	function branchEmployeeLogin($data)
	{
		$this->db->where("email",$data["email"]);
		$this->db->where("branch_id",$data["branch"]);
		$this->db->where("password",$data["password"]);
		$rows = $this->db->get("branch_employees");
		if($rows->num_rows()>0)
		{
			$result = $rows->result();
			$this->session->set_userdata(array("bemp_id"=>$result[0]->be_id));
			return $result[0]->status;
		}
		else return 0;
	}
	function getBranchProfile($branch_id)
	{
		$branchDetails = $this->db->get_where("mep_tb_Branches",array("BranchId"=>$branch_id))->result();
		$branchAdminDetails = $this->db->query("SELECT bal.* FROM branch_admin_localization bal
											INNER JOIN `branch_admin` ba ON ba.ba_id = bal.ba_id
											WHERE ba.branch_id =$branch_id")->result();
		return array(
			"branch" => $branchDetails,
			"branchAdmin" => $branchAdminDetails
		);
	}
	function saveBranchAdminProfile($data,$bid)
	{
		$bd = $this->db->get_where("branch_admin",array("branch_id"=>$bid));
		if($bd->num_rows()>0)
		{
			$bResult = $bd->result();
			$ba_id = $bResult[0]->ba_id;
			$data = array(
               'first_name' => $data["af_name"],
               'last_name' => $data["al_name"],
               'mobile' => $data["a_mobile"],
               'dob' => $data["dob"],
               'address' => $data["addr"],
               'designation' => $data["a_desig"]
            );

			$this->db->where('ba_id', $ba_id);
			$this->db->update('branch_admin_localization', $data);
		}
	}
	function saveBranchAdminAvatar($bid,$file_name)
	{
		$bd = $this->db->get_where("branch_admin",array("branch_id"=>$bid));
		if($bd->num_rows()>0)
		{
			$bResult = $bd->result();
			$ba_id = $bResult[0]->ba_id;
			$data = array(
               'badmin_avatar' => $file_name
            );

			$this->db->where('ba_id', $ba_id);
			$this->db->update('branch_admin_localization', $data);
		}
	}
	public function changepassword($branchid, $data)
	{
		$query = $this->db->get_where('branch_admin', array('branch_id' => $branchid,"password"=>md5($data['oldpassword'])));
        $rows= $query->result();
		if(count($rows)>0){
			$where=array('branch_id'=>$branchid);
			$data=array('password'=>md5($data['newpassword']));
			$this->db->update('branch_admin',$data,$where);
			$result=array('error'=>0,'errorMsg'=>'<div class="alert alert-success">Password changed sucessfully</div>');
		} else {
			$result=array('error'=>1,'errorMsg'=>'<div class="alert alert-danger">Invalid current password</div>');	
		}
		$this->session->set_userdata($result);
		return $result;
	}
	function getBranchCourses($branch,$limit, $offset)
	{
		$sql = "SELECT c.*,ct.CourseTypeName,cb.start_date,cb.end_date FROM mep_tb_Course c
				INNER JOIN mep_tb_CourseType ct ON ct.CourseTypeId=c.CourseTypeId
				INNER JOIN mep_tb_Branches b ON  FIND_IN_SET(b.BranchId, c.BranchId) > 0 
				INNER JOIN mep_tb_course_branches cb ON cb.course_id = c.CourseId  AND cb.branch_id = b.BranchId
				WHERE c.Status IN (0,1)
				AND  FIND_IN_SET(b.BranchId, '$branch') > 0";
		$this->db->order_by("CreatedDate", "desc"); 
		return array(
			"rows" => $this->db->query($sql." LIMIT $offset, $limit")->result(),
			"total" => $this->db->query($sql)->num_rows()
		);
		
	}
	
	function getCourseview($cid)  
	{
		$abc=$this->session->userdata('badmin');
		$sql=$this->db->query("select BranchId from mep_tb_Branches where Email='".$abc."'")->result();
		$cb = $this->db->get_where("mep_tb_course_branches",array('course_id'=>$cid,'branch_id'=>$sql[0]->BranchId))->result();  
		$course = $this->db->get_where("mep_tb_Course",array('CourseId'=>$cid))->result();
		return array("course_details"=> $course, "branches"=> $cb);
	}
	function getJobPostings($offset,$limit)
	{
		$this->db->order_by("added_on","desc");
		return array(
		"total"=>$this->db->get('mep_tb_job_postings')->num_rows(),
		"rows"=>$this->db->query("select *from mep_tb_job_postings order by added_on desc limit $offset, $limit")->result())
		; 
	}
	function viewJob($jid)
	{
		return $this->db->get_where('mep_tb_job_postings', array("job_id"=>$jid))->result();
	}
	function trashBranchAdminJobPosting($branch_id,$job_id)
	{
		$bd = $this->db->get_where("branch_admin",array("branch_id"=>$branch_id));
		if($bd->num_rows()>0)
		{
			$bResult = $bd->result();
			$ba_id = $bResult[0]->ba_id;
			

			$this->db->where('job_id', $job_id);
			$this->db->where('added_by_user', $ba_id);
			$this->db->where('added_by_user_type', "branch_admin");
			$this->db->delete('mep_tb_job_postings');
			return $this->db->affected_rows();
		}
		else
			return 0;
	}
	function saveJobPosting($branchId, $data)
	{
		$bd = $this->db->get_where("branch_admin",array("branch_id"=>$branchId));
		if($bd->num_rows()>0)
		{
			$bResult = $bd->result();
			$ba_id = $bResult[0]->ba_id;
			
			if($data["job_id"]!='')
			{
				//update
				$idata["job_title"] = $data["job_title"];
				$idata["vacancy"] = $data["vacancy"];
				$idata["job_desc"] = $data["job_desc"];
				$idata["contact"] = $data["contact"];
				$idata["status"] = $data["status"];
				$this->db->where("job_id",$data["job_id"]);
				$this->db->update("mep_tb_job_postings", $idata);
			}
			else
			{
				$idata["job_title"] = $data["job_title"];
				$idata["vacancy"] = $data["vacancy"];
				$idata["job_desc"] = $data["job_desc"];
				$idata["contact"] = $data["contact"];
				$idata["status"] = $data["status"];
				$idata["added_by_user"] = $ba_id;
				$idata["added_by_user_type"] = "branch_admin";
				$idata["added_if_branch"] = $branchId;
				$idata["added_on"] = date("Y-m-d H:i:s");
				$this->db->insert("mep_tb_job_postings", $idata);
			}
		}
		
	}
	function getBranchEmployees($offset,$limit,$branch_id)
	{
		$this->db->order_by("added_on","desc");
		return array(
		"total"=>$this->db->get_where('branch_employees',array("branch_id"=>$branch_id))->num_rows(),
		"rows"=>$this->db->get_where('branch_employees',array("branch_id"=>$branch_id), $limit, $offset)->result())
		; 
	}
	function viewEmployee($beid)
	{
		return $this->db->get_where('branch_employees', array("be_id"=>$beid))->result();
	}
	function getBranchEmployeeRoles($beid)
	{
		$result = array();
		$rows = $this->db->get_where('branch_emp_roles_assigned', array("br_emp_id"=>$beid))->result();
		foreach($rows as $row)
		$result[] = $row->role_id;
		return $result;
	}
	function saveEmployee($post,$files)
	{
		if(count($files)>0)
		{
			if(isset( $files["be_avatar"]["name"]))
			{
				$config['upload_path'] = './images/branch_employees_images/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				$this->upload->do_upload('be_avatar');
				$data = $this->upload->data();
			
				//$this->load->library('image_lib');
				$rconfig['image_library'] = 'gd2';
				$rconfig['source_image']	= './images/branch_employees_images/'.$data['file_name'];
				$rconfig['create_thumb'] = TRUE;
				$rconfig['thumb_marker'] = '';
				$rconfig['maintain_ratio'] = TRUE;
				$rconfig['width']	= 250;
				$rconfig['height']	= 250;
				$rconfig['new_image'] =  './images/branch_employees_images/thumbs/'.$data['file_name'];
				$this->load->library('image_lib');
				$this->image_lib->initialize($rconfig);
				$this->image_lib->resize();
				$idata["bemp_avatar"] = $data['file_name'];
			}
		}
		$idata["firstname"]=$post["empFname"];
		$idata["lastname"]=$post["empLname"];
		$idata["email"]=$post["bempEmail"];
		$idata["status"]=$post["bempStatus"];
		if($post["be_id"]!="")
		{
			$this->db->where("be_id",$post["be_id"]);
			$this->db->update("branch_employees",$idata);
			$beid = $post["be_id"];
		}
		else
		{
			$idata['branch_id'] = $this->session->userdata('branch');
			$idata['password'] = MD5("123456");
			$idata['added_on'] = date("Y-m-d");
			$this->db->insert("branch_employees",$idata);
			$beid = $this->db->insert_id();
			$this->addEmployeeMail($idata);
		}
		
		$roles =$post["roles"];
		$roles = explode(",",$roles);
		$this->db->where("br_emp_id",$beid);
		$this->db->delete("branch_emp_roles_assigned");
		foreach($roles as $key=>$value)
		{
			$this->db->insert("branch_emp_roles_assigned", array(
				"role_id"=> $value,
				"br_emp_id"=>$beid
			));
		}
	}
	function getEmpRoles(){
		return $this->db->get("branch_employee_roles_listing")->result();
	}
	function trashBranchEmployee($branchId, $bemp_id)
	{
		$this->db->where("br_emp_id",$bemp_id);
		$this->db->delete("branch_emp_roles_assigned");
		
		$this->db->where("be_id",$bemp_id);
		$this->db->where("branch_id",$branchId);
		$this->db->delete("branch_employees");
	}
	function saveRewards($data)
	{
		$idata["student_id"] = $data["studentid"];
		$idata["reward_id"] = $data["rew_type"];
		$idata["points"] = $data["points"];
		$idata["remarks"] = $data["remarks"];
		$idata["added_on"] = date("Y-m-d H:i:s");
		$idata["updated_by_user_id"] = $this->session->userdata('badmin_id');
		$idata["updated_by_user_type"] = "branch_admin";
		$this->db->insert("student_rewward_earnings",$idata);
		
		$this->db->select_sum('points');
		$this->db->from('student_rewward_earnings');
		$this->db->where('student_id', $data["studentid"]);
		$query = $this->db->get();
		$total_sold = $query->row()->points;
		return $total_sold;
	}
	
	function getEnquiriesByBranch($branch,$limit, $offset)
	{
		$sql = "SELECT e.*,c.CourseName FROM mep_enquiry e
			INNER JOIN `mep_tb_Course` c ON c.CourseId = e.courses
			WHERE e.place =$branch";
		$this->db->order_by("id", "desc"); 
		return array(
			"rows" => $this->db->query($sql." LIMIT $offset, $limit")->result(),
			"total" => $this->db->query($sql)->num_rows()
		);
		
	}
	function addEmployeeMail($idata)
	{
		$branch_id = $idata['branch_id'];
		$branch= $this->db->get_where("mep_tb_Branches",array("BranchId"=>$branch_id))->result();
		
		$d=$this->input->post();
		$d["bname"] = $branch[0]->BranchName;
		$d["loc"] = $branch[0]->Location;
		
				$to=$idata['email'];
				$subject ="Welcome to MEP";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: admin@mepcentre.com" . "\r\n";
				$msg=$this->load->view('branchadmin/branchEmployee_template',$d,true);
				//var_dump($msg); die;
				$patterns = array();
				$patterns[0] = '/<<email>>/';   
				$replacements = array();
				$replacements[0] = $to;  				
				$msg = preg_replace($patterns, $replacements, $msg);
				mail($to, $subject, $msg, $headers); 
	}
	function forgotpassword($type,$email,$branch)
	{
		if("admin"==$type)
		{
			$br = $this->db->get_where("mep_tb_Branches",array("Email"=> $email, "BranchId"=> $branch));
			if($br->num_rows()==0)
				return array(
					"status"=>"error",
					"Message"=>"No Account Exists with given data"
				);
			else{
				$rows = $br->result();
				$status = $rows[0]->status;
				if(intval($status)==1)
				{
					$rand = rand();
					$password = md5($rand);
					/*$this->load->library('email');
					$this->email->from('info@mepcentre.com', 'MEP CENTRE');
					$this->email->to($email); 
					$this->email->subject('Password Reset');
					$this->email->message('Dear user, Your new password for logging in to Branch Admin section is '.$rand);
					$this->email->send();*/
					$d=$this->input->post();
				$to=$email;
				$subject ="Welcome to MEP";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: admin@mepcentre.com" . "\r\n";
				$msg=$this->load->view('baForgotPasswordTemplate','$d',true);
				//var_dump($msg); die;
				$patterns = array();
				$patterns[0] = '/<<email_addr>>/';
				$patterns[1] = '/<<password>>/';  	  
				$replacements = array();
				$replacements[1] = $to;
				$replacements[0] = $rand;  
				$msg = preg_replace($patterns, $replacements, $msg);
				mail($to, $subject, $msg, $headers);
					
					
					$this->db->where("branch_id",$branch);
					$this->db->update("branch_admin",array("password"=>$password));
					return array(
						"status"=>"success",
						"Message"=>"Password has been sent to your email address"
					);
				}
				else
					return array(
						"status"=>"error",
						"Message"=>"Branch has been suspended"
					);
			}
		}
		else
		{
			//
			$be = $this->db->get_where("branch_employees",array("email"=> $email, "branch_id"=> $branch));
			if($be->num_rows()==0)
				return array(
					"status"=>"error",
					"Message"=>"No Account Exists with given data"
				);	
			else
			{
				$rows = $be->result();
				$status = $rows[0]->status;
				if(intval($status)==1)
				{
					$rand = rand();
					$password = md5($rand);
					
					/*$this->load->library('email');
					$this->email->from('info@mepcentre.com', 'MEP CENTRE');
					$this->email->to($email); 
					//$this->email->to("sri.harsha@inducosolutions.com"); 
					$this->email->subject('Password Reset');
					$this->email->message('Dear user, Your new password for logging in to Branch Employee section is '.$rand);
					$this->email->send();*/
					$d=$this->input->post();
				$to=$email;
				$subject ="Welcome to MEP";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: admin@mepcentre.com" . "\r\n";
				$msg=$this->load->view('beForgotPasswordTemplate','$d',true);
				//var_dump($msg); die;
				$patterns = array();
				$patterns[0] = '/<<email>>/';
				$patterns[1] = '/<<password>>/';  	  
				$replacements = array();
				$replacements[1] = $to;
				$replacements[0] = $rand;  
				$msg = preg_replace($patterns, $replacements, $msg);
				mail($to, $subject, $msg, $headers);
					
					
					$this->db->where("branch_id",$branch);
					$this->db->where("email",$email);
					$this->db->update("branch_employees",array("password"=>$password));
					return array(
						"status"=>"success",
						"Message"=>"Password has been sent to your email address"
					);
				}
				else
					return array(
						"status"=>"error",
						"Message"=>"Your account has been suspended"
					);
			}
		}
	}
	function checkIfStudentExist($to)
	{
		return $this->db->get_where("mep_users",array("user_name"=>$to))->num_rows();
	}
	function getBranchBookings($data,$branch_id)
	{
		$page = $data['page'];
		$lstart = (intval($page)-1)*10;
		$lend = 10;
		$sql="SELECT cbb.cbb_id,c.`CourseName`,ct.CourseTypeName,ul.firstname,ul.lastname,ul.email,ul.mobile,ul.user_avatar,
			cbb.registered_datetime,cbb.seat_num,pt.`server_response_xml`,c.`Status` AS courseStatus
			FROM `mep_tb_course_branch_booking` cbb
			LEFT JOIN `mep_tb_Course` c ON c.`CourseId` = cbb.course_id
			LEFT JOIN `mep_tb_CourseType` ct ON c.`CourseTypeId` = ct.`CourseTypeId`
			LEFT JOIN `mep_users_localization` ul ON ul.userid = cbb.user_id
			LEFT JOIN `mep_tb_payment_transactions` pt ON pt.`tr_tb_id` = cbb.payment_details
			WHERE cbb.branch_id =$branch_id";
		if($data["type"]!='')
			$sql.=" AND ct.`CourseTypeId`=".$data["type"];
		if($data["start"]!='')
			$sql.=" AND cbb.registered_datetime>= '".$data["start"]."'";
		if($data["end"]!='')
			$sql.=" AND cbb.registered_datetime<= '".$data["end"]."'";
		if($data["q"]!='')
			$sql.=" AND (ul.`firstname` LIKE '%".$data["q"]."%' OR ul.lastname LIKE '%".$data["q"]."%' OR c.`CourseName` LIKE '%".$data["q"]."%')";
		$sql.=" Order by cbb.registered_datetime desc";
		return array(
				"total"=>$this->db->query($sql)->num_rows(),
				"bookings"=> $this->db->query($sql." LIMIT $lstart, $lend")->result()
			);
	}
	function getCourseBookingSchemes($data)
	{
		$result= array();
		foreach($data["bookings"] as $key=>$value)
			$result[$value] = $this->getBookingSchemesById($value);
		return $result;
	}
	function getBookingSchemesById($booking_id='')
	{
		if($booking_id!='')
		{
			return $this->db->get_where("mep_schemes_bookings",array("booking_id"=>$booking_id))->result();
		}else
			return '';
	}
	function saveCBBSchemes($data)
	{
		$this->db->where("booking_id",$data["cbbid"]);
		$this->db->delete("mep_schemes_bookings");
		foreach($data["bookings"] as $key=>$value)
		{
			$this->db->insert("mep_schemes_bookings",array(
				"scheme_id"=>$value,
				"booking_id"=>$data["cbbid"],
				"assigned_on"=>date("Y-m-d H:i:s")
			));
		}
	}
}