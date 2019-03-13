<?php
class Dashboard_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->userid=$this->session->userdata("admin_id");
	}
	function getSiteMeta()
	{
		return $this->db->get("mep_site_settings")->result();
	}
	function getAdminProfile()
	{
		$admin_id = $this->session->userdata('admin_id');
		return $this->db->get_where("mep_admin_user_localization",array("admin_user_id"=>$admin_id))->result();
	}
	function setAdminProfilePic($admin_id,$source_image)
	{
		$data = array(
               'imagepath' => $source_image
            );
		$this->db->where('admin_user_id', $admin_id);
		$this->db->update('mep_admin_user_localization', $data); 
	}
	
	public function changepassword()
	{
		$data=$this->input->post();
		
		if($this->session->userdata('dummy_admin_login') == "1")
		{
			$dadmin_email =  $this->session->userdata('dummy_admin_email');
			$query = $this->db->get_where('mep_tb_dummyadmins', array('username' => $dadmin_email,"password"=>md5($data['oldpassword'])));
			$rows= $query->result();
			if(count($rows)>0){
				$where=array('username'=>$dadmin_email);
				$data=array('password'=>md5($data['newpassword']));
				$this->db->update('mep_tb_dummyadmins',$data,$where);
				$result=array('error'=>1,'errorMsg'=>'<div class="alert alert-success">Password changed sucessfully</div>');
			} else
				$result=array('error'=>1,'errorMsg'=>'<div class="alert alert-danger">Invalid current password</div>');	
			
			$this->session->set_userdata($result);
		}
		else
		{
			$query = $this->db->get_where('mep_admin_users', array('id' => $this->userid,"password"=>md5($data['oldpassword'])));
			$rows= $query->result();
			if(count($rows)>0){
				$where=array('id'=>$this->userid);
				$data=array('password'=>md5($data['newpassword']));
				$this->db->update('mep_admin_users',$data,$where);
				$result=array('error'=>1,'errorMsg'=>'<div class="alert alert-success">Password changed sucessfully</div>');
			} else
				$result=array('error'=>1,'errorMsg'=>'<div class="alert alert-danger">Invalid current password</div>');	
			
			$this->session->set_userdata($result);
		}
		return $result;
	}	
	function setSocialSettings()
	{
		$data=$this->input->post();
		$idata=array();
		if(isset($data['fb_page_link']) && $data['fb_page_link'])
			$idata['facebook']=$data['fb_page_link'];
		if(isset($data['google_page_link']) && $data['google_page_link'])
			$idata['google']=$data['google_page_link'];
		if(isset($data['twitter_ac_link']) && $data['twitter_ac_link'])
			$idata['twitter']=$data['twitter_ac_link'];
		if(isset($data['youtube_channel_link']) && $data['youtube_channel_link'])
			$idata['youtube']=$data['youtube_channel_link'];
		if(isset($data['linkedin_ac_link']) && $data['linkedin_ac_link'])
			$idata['linkedin']=$data['linkedin_ac_link'];
		if(isset($data['pintrest_link']) && $data['pintrest_link'])
			$idata['Pintrest']=$data['pintrest_link'];
		  
		$idata['last_updated']= date("Y-m-d H:i:s");
			
		$this->db->update('mep_tb_socialsettings',$idata);
		if($this->db->affected_rows() > 0)
			return 1 ;
		else
		return 0;
   }
	function getSocialSettings()
	{
		$query = $this->db->query("select * from mep_tb_socialsettings");
		return $rows= $query->result();	
	}
	function setWidget()
	{
		$data=$this->input->post();
		$idata=array();
		if(isset($data['widget_title']) && $data['widget_title'])
			$idata['widgetname']=$data['widget_title'];
		if(isset($data['widget_content']) && $data['widget_content'])
			$idata['widgetcontent']=$data['widget_content'];
		else
			$data['widgetcontent']="";
        
		$idata['last_updated']=date('Y-d-m H:i:s');
			//print_r($data['id']); exit;
		$this->db->update('mep_tb_widgets',$idata);
		return $this->db->affected_rows(); 
	}
	function getwidgetvalues()
	{
		$this->db->select('*');
		$res = $this->db->get('mep_tb_widgets');
		$rows= $res->result();#print_r($rows);exit;
		return $rows;
	}
	function getmetasite()
	{
		$data=$this->input->post();
		$result=array('error'=>0,'errorMsg'=>'Error Occured');
		#echo'<pre>';print_r($data);exit;
		$idata=array();
		if(isset($data['site_title']) && $data['site_title'])
			$idata['metasitetitle']=$data['site_title'];
		if(isset($data['site_content']) && $data['site_content'])
			$idata['metasitedesc']=$data['site_content'];
		else
			$data['metasitedesc']="";
            if(isset($data['Createdby']) && $data['Createdby'])
			$idata[	'Createdby']=$this->ChangeDBTime($data['Createdby']);
		else
			$idata['Createdby']=date('Y-d-m H:i:s');
			//print_r($data['id']); exit;
			$this->db->update('mep_tb_metasite',$idata);
			$result=array('error'=>1,'errorMsg'=>'Metasite updated successfully.');
		$this->session->set_userdata($result); 
		return $result;
	}
	function getmetasitevalues()
	{
		$this->db->select('*');
		$res = $this->db->get('mep_tb_metasite');
		$rows= $res->result();#print_r($rows);exit;
		return $rows;
			
	}
	function InsertCourses($image)
	{
		$data=$this->input->post();
		$result=array('error'=>0,'errorMsg'=>'Error Occured');
		//echo'<pre>';print_r($data);exit;
		$idata=array();
		$type=$data['post_type'];
		if(isset($data['form_state_CourseTypeId']) && $data['form_state_CourseTypeId'])
			$idata['CourseTypeId']=$data['form_state_CourseTypeId'];
		if(isset($data['coursename']) && $data['coursename'])
			$idata['CourseName']=$data['coursename'];
		if(isset($data['fee']) && $data['fee'])
			$idata['Fee']=$data['fee'];
		if(isset($data['duration']) && $data['duration'])
			$idata['Duration']=$data['duration'];
		if(isset($data['startdate']) && $data['startdate'])
			//$idata['StartDate']=date('m-d-Y H:i:s',strtotime($data['startdate']));
		$idata['StartDate']=$data['startdate'];
			//$idata['EndDate']=date('m-d-Y H:i:s',strtotime($data['enddate']));
		if(isset($data['enddate']) && $data['enddate'])
			$idata['EndDate']=$data['enddate'];	
		if(isset($data['starttime']) && $data['starttime'])
			$idata['StartTime']=$data['starttime'];
		if(isset($data['endtime']) && $data['endtime'])
			$idata['EndTime']=$data['endtime'];
		if(isset($data['eligibility']) && $data['eligibility'])
			$idata['Eligibility']=$data['eligibility'];
		if(isset($data['form_state_BranchId']) && $data['form_state_BranchId'])
			$idata['BranchId']=$data['form_state_BranchId'];	
		if(isset($data['totalseats']) && $data['totalseats'])
			$idata['TotalSeats']=$data['totalseats'];
		if(isset($data['form_state_status']) && $data['form_state_status'])
			$idata['Status']=$data['form_state_status'];
		if(isset($data['description']) && $data['description'])
			$idata['Description']=$data['description'];
		else
			$idata['description']="";
		if(isset($data['Createdby']) && $data['Createdby'])
			$idata[	'Createdby']=$this->ChangeDBTime($data['Createdby']);
		else
			$idata['Createdby']=date('Y-d-m H:i:s');
		if(isset($_FILES['CourseBanner']) && $_FILES['CourseBanner']['tmp_name']) {
			if(isset($_FILES['CourseBanner'])&&$_FILES['CourseBanner'])
				 $idata['CourseBanner'] = $file_path;
		}
		if($data['CourseId']){
			//print_r($idata); exit;
			$this->db->where('CourseId',($this->input->post ('CourseId')));
			$this->db->update('mep_tb_Course',$idata);
			$result=array('error'=>1,'errorMsg'=>'Course updated successfully.');
		}else {
			//print_r($idata);exit;
			$CourseId="";
				$this->db->insert('mep_tb_Course',$idata);
					$CourseId=$this->db->insert_id();
			$result=array('error'=>1,'errorMsg'=>'Course added successfully.');
		}
		$this->session->set_userdata($result); 
		return $result;	
	}
	public function gettabled()
    {
		$query= $this->db->get_where('mep_tb_CourseType ');
		return $query->result();
	}
	public function getbranch()
    {
		$query= $this->db->get_where('mep_tb_Branches ');
		return $query->result();
	}
	
	public function getalltable( $limit, $offset)
    {
		//$query= $this->db->query("SELECT * FROM `mep_tb_Course` as c INNER JOIN mep_tb_CourseType as ct ON ct.`CourseTypeId`=c.`CourseTypeId`");
		//$query= $this->db->get_where('mep_tb_Course');
		// $query= $this->db->get_where('mep_vw_Course');
		$course=$this->input->post('search') ;
		if(!empty($course))
			return $this->db->query(" select * from mep_vw_Course  where CourseTypeId='$course'")->result();
		$startdate=$this->input->post('sd') ;
		if(!empty($startdate))
			return $this->db->query(" select * from mep_vw_Course  where StartDate='$startdate'")->result();
		$enddate=$this->input->post('ed') ;
		if(!empty($enddate))
		return $this->db->query(" select * from mep_vw_Course  where EndDate='$enddate'")->result();
		$branch=$this->input->post('form_state_BranchId') ;
		if(!empty($branch))
			return $this->db->query(" select * from mep_vw_Course  where BranchId='$branch'")->result();

		$status=$this->input->post('form_state_status') ;
		if(!empty($status))
		return $this->db->query(" select * from mep_vw_Course  where Status='$status'")->result();
		else{
			$query = $this->db->get_where('mep_vw_Course', array(),  $limit, $offset);
			return $query->result(); 
		}
    }
	public function getCourse()
	{
		$this->load->database();
		$query=$this->db->get('mep_tb_Course');
		return $query->result();
	
	}	
	function setPageContent($page,$data)	
	{
		//var_dump($data);
		if($page=='about')
			$this->db->update('mep_content' ,array("about_us"=>$data));
		else if($page=='privacy')
			$this->db->update('mep_content' ,array("policy"=>$data));
		else if($page=='terms')
			$this->db->update('mep_content' ,array("terms"=>$data));
	}
	function insertuser()
	{
		$data=$this->input->post();
		
		if($data["userid"]=="")
		{
		  $this->db->select('*');
		$this->db->where('email',$this->input->post ('user_email'));
		$res = $this->db->get('mep_users_localization');
		$rows= $res->result();
		#echo "<pre>";print_r($rows);exit;
		if(count($rows)>0){
			$result='text';  
			return $result;
		}
			
			//new user
			$idata = array();
			$idata['user_name'] = $data['user_email'];
			$idata['password'] = md5($data['ppass']);
			$idata['created_on'] = date("Y-m-d H:i:s");
			$idata['status'] = $data['status'];
			$this->db->insert("mep_users", $idata);
			$uid = $this->db->insert_id();
			
			$idata = array();
			$idata['userid'] = $uid;
			$idata['firstname'] = $data["firstname"];
			$idata['lastname'] = $data["lastname"];
			$idata['email'] = $data["user_email"];
			$idata['mobile'] = $data["mobile"];
			$idata['perm_address'] = $data["perm_address"];
			$idata['present_address'] = $data["present_address"];
			$this->db->insert("mep_users_localization", $idata);
			
		}
		else
		{
			//update user
			
			$idata['firstname'] = $data["firstname"];
			$idata['lastname'] = $data["lastname"];
			$idata['mobile'] = $data["mobile"];
			$idata['perm_address'] = $data["perm_address"];
			$idata['present_address'] = $data["present_address"];
			$this->db->where("userid",$data['userid']);
			$this->db->update("mep_users_localization", $idata);
			$x= $this->db->affected_rows();
			$idata = array();
			$idata['status'] = $data['status'];
			if($data['ppass']!='')
				$idata['password'] = md5($data['ppass']);
			$this->db->where("userid",$data['userid']);
			$this->db->update("mep_users", $idata);
			$x1= $this->db->affected_rows();
			return max($x,$x1);
		}
		
		/*$data[] = $data['firstname']
		lastname
		user_email
		mobile
		perm_address
		present_address
		status
		$result=array('error'=>0,'errorMsg'=>'Error Occured');
		$email=$this->input->post('user_email');
		$idata=array();

			if(isset($data['firstname']) && $data['firstname'])
				$idata['firstname']=$data['firstname'];
			if(isset($data['lastname']) && $data['lastname'])
				$idata['lastname']=$data['lastname'];
			if(isset($data['user_email']) && $data['user_email'])
			{
				$idata['email']=$data['user_email'];
				$jdata['user_name']=$data['user_email'];
			}
			if(isset($data['mobile']) && $data['mobile'])
				$idata['mobile']=$data['mobile'];
			if(isset($data['user_password']) && $data['user_password'])
			{
				$jdata['password']=md5($data['user_password']);
			}
			if(isset($data['present_address']) && $data['present_address'])
				$idata['present_address']=$data['present_address'];	
			if(isset($data['perm_address']) && $data['perm_address'])
				$idata['perm_address']=$data['perm_address'];			
			if(isset($_FILES['Image'])&&$_FILES['Image'])
				$idata['user_image'] = $image;
			if(isset($data['Createdby']) && $data['Createdby'])
				$jdata['created_on']=$this->ChangeDBTime($data['created_on']);
			else
				$jdata['created_on']=date('Y-d-m H:i:s');
			$uid = $this->input->post('userid');
			#echo "<pre>";print_r($uid);exit;
			if(!empty($uid)){
				#print_r($idata); exit;
				$this->db->where('userid',$this->input->post ('userid'));
				$this->db->update('mep_users',$jdata);
				$this->db->where('userid',$this->input->post ('userid'));
				$this->db->update('mep_users_localization',$idata);
				$result=array('error'=>1,'errorMsg'=>'user updated successfully.');
			}
			$this->db->select('*');
		$this->db->where('email',$this->input->post ('user_email'));
		$res = $this->db->get('mep_users_localization');
		$rows= $res->result();
		#echo "<pre>";print_r($rows);exit;
		if(count($rows)>0)
			$result=array('error'=>1,'errorMsg'=>'Email Already exists');
		
			else {
				//print_r($idata);exit;
				$userid="";
				$chtml="Thank you for registering with us we will contact you soon.";
				$from="info@admin.com";
				$to=$data['user_email'];
				#var_dump($to);die;
				$this->email($to,$data['user_email'],'mep user registration confirmation',$chtml,'Admin');
				$this->db->insert('mep_users',$jdata);
				$userid=$this->db->insert_id();
				$idata['userid']=$userid;
				$this->db->insert('mep_users_localization',$idata);
				$result=array('error'=>1,'errorMsg'=>'User added successfully.');
			}
		
		$this->session->set_userdata($result); 
		return $result;	*/
	}
	public function getallusers()
	{
		$query= $this->db->get_where('mep_users');
		return $query->result();
	}
	function undeleteUser($uid)	
	{
		$idata['status'] = 0;
		$this->db->where("userid",$uid);
		$this->db->update("mep_users", $idata);
	}
		/*public function getpageusers($limit='',$offset='')
		{
			$result=$this->input->post();
			$email = $this->input->post('email');
			$name=$this->input->post('name');
			$phone=$this->input->post('phone');

			if(!empty($result))
			{
				$sql = "SELECT * from mep_users_localization,mep_users where mep_users_localization.userid=mep_users.userid and mep_users.status in (0,1)";

				if($email!='')
					$sql.= "  AND email like '%$email%'";
				if($phone!='') 
					$sql.= "  AND mobile like '%$phone%'";
				if($name!='')
				{
					$sql.= "  AND firstname like '%$name%' ";
				}
				$abc = $this->db->query($sql)->result();
				return $this->db->query($sql)->result();
			}
			else
			{
				$query= $this->db->order_by('userid', 'DESC')->get_where('mep_users_localization',array(),$limit,$offset);
				return $query->result();
			}
		}*/
	
	public function getpageusers($sname='',$sphone='',$semail='',$page='',$status='')
	{
		$lstart = (intval($page)-1)*10;
		$lend = 10;
		$sql = "SELECT * FROM mep_users_localization ul
				INNER JOIN mep_users u ON u.userid = ul.userid
				WHERE u.status IN (0,1,2)";
		
		if($semail!='')
			$sql.= "  AND ul.email like '%$semail%' ";
		
		if($sphone!='')
			$sql.= " AND ul.mobile like '%$sphone%' ";
		
		if($sname!='')
			$sql.= " AND ul.firstname like '%$sname%' ";
		
		if($status!='')
			$sql.= " AND  u.status = $status ";
			
		$vsql = $sql;
		$tot = $this->db->query($vsql);
		$sql.= " order by u.created_on DESC LIMIT $lstart, $lend";
		$total = $tot->num_rows();
		$users = $this->db->query($sql)->result();
		return array("total"=>$total,"users"=> $users);
	}
	
	public function get_user($id="")
	{
		if($id=='')
			return '';
		 return $this->db->query("SELECT * FROM mep_users_localization ul
				INNER JOIN mep_users u ON u.userid = ul.userid
				WHERE u.userid=$id")->result_array();
	}
	
	function insertbranch()
	{
		$data=$this->input->post();
		
		$result=array('error'=>0,'errorMsg'=>'Error Occured');
		$id=$this->input->post('branchid');
		$idata=array();
		
		if(isset($data['BranchName']) && $data['BranchName'])
			$idata['BranchName']=$data['BranchName'];
		if(isset($data['Location']) && $data['Location'])
			$idata['Location']=$data['Location'];
		if(isset($data['Email']) && $data['Email'])
			$idata['Email']=$data['Email'];
		if(isset($data['Phonenumber']) && $data['Phonenumber'])
			$idata['PhoneNumber']=$data['Phonenumber'];	
		if(isset($data['Address1']) && $data['Address1'])
			$idata['Address1']=$data['Address1'];	
		if(isset($data['Address2']) && $data['Address2'])
			$idata['Address2']=$data['Address2'];			
		if(isset($data['Pincode']) && $data['Pincode'])
			$idata['Pincode']=$data['Pincode'];	
		
		$idata['status']=$data['status'];
		if(isset($data['mapurl']) && $data['mapurl'])
			$idata['map_url']=$data['mapurl'];		   
		$uid = $this->input->post('branchid');
		//var_dump($idata); die;
		if(!empty($uid)){
			$this->db->where('BranchId',$this->input->post ('branchid'));
			$this->db->update('mep_tb_Branches',$idata);
			$result=array('error'=>1,'errorMsg1'=>'<div class="alert alert-success">Branch updated successfully.</div>');
		
		}else {
			//print_r($idata);exit;
			$uid="";
			$idata['CreatedDate'] = date('Y-m-d H:i:s');
			$idata['CreatedBy'] = $this->session->userdata('admin_id');
			$this->db->insert('mep_tb_Branches',$idata);
			$BranchId=$this->db->insert_id();
			$this->db->insert('branch_admin',array(
				"branch_id"=>$BranchId,
				"email_addr"=>$idata['Email'],
				"password"=>MD5("123456"),
				"status"=>1
			));
			$ba_id=$this->db->insert_id();
			$this->db->insert('branch_admin_localization',array(
				"ba_id"=>$ba_id,
				"email"=>$idata['Email']
			));
			$this->sendBranchAdminMail($idata['Email'],$idata['BranchName'],$idata['Location']);
			$result=array('error'=>1,'errorMsg1'=>'<div class="alert alert-success">Branch added successfully.</div>');
		}  
		$this->session->set_userdata($result); 
		return $result;	
	}
	function sendBranchAdminMail($to,$branch,$location){
		$this->load->library('email');
		$this->email->from('info@mepcentre.com', 'MEP CENTRE');
		$this->email->to($to); 
		$this->email->set_mailtype("html");
		$this->email->subject('Welcome to MEP');
		$message = $this->load->view("emailtemplates/branchreg",array("email"=>$to,"location"=>$location, "branch"=>$branch),TRUE);
		$this->email->message($message);
		$this->email->send();	
	}
	function getpagebranch($limit='',$offset='')
    {
		
		$sql = "SELECT * from mep_tb_Branches order by CreatedDate desc limit $offset, $limit";
		return $this->db->query($sql)->result();
		
   }
	public function get_branch($id="")
	{
		 return $this->db->get_where('mep_tb_Branches', array('BranchId' => $id))->result_array();
	}
		 function get_enquiry($id="")
	{
		// return $this->db->get_where('mep_enquiry', array('id' => $id))->result_array();
		 $sql= "SELECT e.*,c.CourseName,b.BranchName,b.Location from mep_enquiry e inner join  mep_tb_Course c on c.CourseId=e.courses LEFT JOIN mep_tb_Branches b on e.place=b.BranchId  where id =$id";
		return $this->db->query($sql)->result();
		
	}
    function get_contact($id="")
	{
		 return $this->db->get_where('mep_contact_us', array('id' => $id))->result_array();
	}
  
	public function deletebranch($tids)
	{
		$tids =	implode(",",$tids);
			$this->db->query("DELETE FROM mep_tb_Branches where BranchId in ($tids)");
		return 1;
	}
function getaboutus()
	{
		$this->db->select('about_us');
		$res = $this->db->get('mep_content');
		return  $res->result(); 
	}
	function gettermsandcond()
	{
		$this->db->select('terms');
		$cond = $this->db->get('mep_content');
		$rows= $cond->result();
		return $rows;
	}
	function getpolicyppp()
	{
		$this->db->select('policy');
		$cond = $this->db->get('mep_content');
		$rows= $cond->result();
		return $rows;
	}


	
	function getsettings()
	{
			
		$this->db->select('*');
		$res = $this->db->get('mep_settings');
		$rows= $res->result();#print_r($rows);exit;
		return $rows;
		
	}	
	
	function getsearchuser($email='',$name='',$phone='',$limit,$offset)
	{
		$result=($this->input->post());
		if(!empty($result))
		{
		$sql = "SELECT * from mep_users where status in(0,1)";
				
				 if($email!='')
			$sql.= "  AND email like '%$email%'";
			if($name!='')
			$sql.= "  AND name like '%$name%'";
			if($phone!='')
			$sql.= "  AND phone like '%$phone%'";
		//	echo $sql; die;
			return $this->db->query($sql)->result();
		}
		else
		{
			 $query= $this->db->get_where('mep_users',array(),$limit,$offset);
         return $query->result();
		 }
		}
	public function getpageenquiry($limit='',$offset='')
    {
		    $sql = "SELECT e.*,c.CourseName,b.BranchName,b.Location FROM mep_enquiry e 
				INNER JOIN  mep_tb_Course c ON c.CourseId=e.courses 
				LEFT JOIN mep_tb_Branches b ON e.place=b.BranchId
				WHERE e.status IN(0,1) ";
			if($this->input->post())
			{
				$email = $this->input->post('email');
				$name=$this->input->post('name');
				$phone=$this->input->post('mobile');
				$course=$this->input->post('course');
					
				if($course!='')
				$sql.= "  AND e.courses =$course";
				if($phone!='') 
				$sql.= "  AND e.contact like '%$phone%'";
				if($name!='')
				$sql.= "  AND e.name like '%$name%'";
				if($email!='')
				$sql.= "  AND e.email like '%$email%'";
			}
			$tot = $sql;
			$sql.=" order by e.added_on desc limit $limit,$offset";
			$query = $this->db->query($sql);
			$total = $this->db->query($tot);
			return array("rows"=>$query->result(),"total"=>$total->num_rows());
    }
	public function delete1enquiry($tids)
	{
		
		$this->db->query("DELETE FROM mep_enquiry where id in ($tids)");
		return 1;
	}
	function saveSiteSetings()
	{
		$data=$this->input->post(); 
		if(!empty($_FILES['image']['name'])){
				
		    $config['upload_path'] = 'images/logos';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']	= '1000000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$upload = $this->upload->do_upload('image');
		
			$idata= $this->upload->data();
			 
			$error = array('error' => $this->upload->display_errors());
			#var_dump($idata);die;
	       
			$document=base_url("images/logos/".$idata['file_name']);
			//$data['image'] = $document;
			#var_dump($data['image']);die;
			$this->gallery_path = realpath(APPPATH . '../images/logos');
			 
				$config1 = array(
					  'source_image' => $idata['full_path'], 
					  'new_image' => $this->gallery_path.'/thumbs', 
					  'maintain_ratio' => true,
					  'width' => 50,
					  'height' => 50 
       
				);
				$this->load->library('image_lib');
                 $this->image_lib->initialize($config1);
							
				if($this->image_lib->resize())
				$data['site_logo']=$document;
			
		}  
		if(!empty($_FILES['rightlogo']['name'])){
			#var_dump($_FILES['rightlogo']['name']);die; 				
		    $config['upload_path'] = 'images/logos/right';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']	= '1000000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$upload = $this->upload->do_upload('rightlogo');
		
			$idata= $this->upload->data();
			
			$error = array('error' => $this->upload->display_errors());
			
	        #var_dump($idata);die;
			$document=base_url("images/logos/right/".$idata['file_name']);
			#$data['rightlogo'] = $document;
			#var_dump($data['rightlogo']);die;
			$this->gallery_path = realpath(APPPATH . '../images/logos/right');
			 
				$config1 = array(
					  'source_image' => $idata['full_path'], 
					  'new_image' => $this->gallery_path.'/thumbs', 
					  'maintain_ratio' => true,
					  'width' => 134,
					  'height' => 70 
       
				);
				#var_dump($config1);die;
				$this->load->library('image_lib');
                 $this->image_lib->initialize($config1);
							
				if($this->image_lib->resize())
				$data['right_logo']=$document;
			
		}  
		$this->db->update('mep_settings', $data);  
	}
	public function Inserttestimonials($file_path='')
	{
		$data=$this->input->post();
		$result=array('error'=>0,'errorMsg'=>'Error Occured');
		$idata=array();
		
		if(isset($data['TestimonialName']) && $data['TestimonialName'])
		   $idata['TestimonialName']=$data['TestimonialName'];
	   if(isset($data['test_type']) && $data['test_type'])   
		   $idata['TestimonialType']=$data['test_type'];
		//if(isset($data['status']) && $data['status'])
			   $idata['status']=$data['status']; 
	   if(isset($data['EmailId']) && $data['EmailId'])
		       $idata['EmailId']=$data['EmailId'];
		 if(isset($data['Phone_number']) && $data['Phone_number'])
		       $idata['Phone_number']=$data['Phone_number'];
	   if(isset($data['TestimonialText']) && $data['TestimonialText'])
		       $idata['TestimonialText']=$data['TestimonialText'];
			   
		else 
		$idata['TestimonialText']='';
		if(isset($_FILES['image'])&&$_FILES['image'] && $file_path!='')
		$idata['image'] = $file_path;
		 if(isset($data['test1_content']) && $data['test1_content'])
		       $idata['TestimonialLink']=$data['test1_content'];
	
	//var_dump($idata); die;
		if($data['userid']){
			#var_dump($idata);die;
			$this->db->where('TestimonialId',($this->input->post ('userid')));
			$this->db->update('mep_tb_Testimonials',$idata);
			$result=array('error'=>1,'errorMsg'=>'testimonials updated successfully.');	
		}else {
				//print_r($idata);exit;
				$userid="";  
				$idata["CreatedDate"] = date("Y-m-d H:i:s");
				$idata['CreatedBy'] = $this->session->userdata('admin_id');
				$this->db->insert('mep_tb_Testimonials',$idata);
				$TestimonialId=$this->db->insert_id();
				$result=array('error'=>1,'errorMsg'=>'testimonials added successfully.');
			}
		$this->session->set_userdata($result); 
		return $result;
	}
	
	public function getalltestimonials($limit='',$offset='')
    {
		$result=$this->input->post();
		$name = $this->input->post('name');
		if($result)
		{
			$sql = "SELECT * from mep_tb_Testimonials order by CreatedDate desc  where TestimonialName like '%$name%'" ;  
			$query= $this->db->query($sql);
			return array("rows"=>$query->result(),"total"=>$query->num_rows()); 
		}
		else
		{
			$sql = "SELECT * from mep_tb_Testimonials order by CreatedDate desc limit $limit,$offset";
			$sql1 = "SELECT * from mep_tb_Testimonials"; 
			$query= $this->db->query($sql);
			$query1= $this->db->query($sql1);
			return array("rows"=>$query->result(),"total"=>$query1->num_rows()); 
		}
		#echo $sql; die;
		 
    }

	public function getTestimonial($id="")
	{
		 return $this->db->get_where('mep_tb_Testimonials', array('TestimonialId' => $id))->result_array();
	}
	function saveGoveScheme($data)
	{
		if($data["gs_id"]!='')
		{
			$idata["gs_name"] = $data["gs_name"];
			$idata["gs_desc"] = $data["gs_content"];
			$this->db->where("gs_id",$data["gs_id"]);
			$this->db->update("mep_govt_schemes",$idata);
		}
		else
		{
			$idata["gs_name"] = $data["gs_name"];
			$idata["gs_desc"] = $data["gs_content"];
			$idata["added_on"] = date("Y-m-d H:i:s");
			$this->db->insert("mep_govt_schemes",$idata);
		}
	}
	function getAllGovtSchemes()
	{
		return $this->db->get("mep_govt_schemes")->result();
	}
	function trashSchemes($data)
	{
		if (strpos($data['id'],',') !== false)
			$ids = implode(",",$data['id']);
		else
		$ids = $data['id'];
		$this->db->query("delete from mep_govt_schemes where gs_id in ($ids)");
	}
	public function getScheme($id="")
	{
		 return $this->db->get_where('mep_govt_schemes', array('gs_id' => $id))->result();
	}

	public function test()
	{
	  $this->load->database();
       $query=$this->db->get('mep_tb_Testimonials');//employee is a table in the database
       return $query->result();
	   
	}
	
	public function getGovernamentSchemes($limit='',$offset='')
    {
		$sql = "SELECT * from mep_govt_schemes order by added_on desc limit $limit,$offset";
		$sql1 = "SELECT * from mep_govt_schemes"; 
		$query= $this->db->query($sql);
		$query1= $this->db->query($sql1);
		return array("rows"=>$query->result(),"total"=>$query1->num_rows());
		 
    }
	
	  

	public function Delete()
	{
		$result=array('error'=>0,'errorMsg'=>'Error Occured.');
		$data=$this->input->post();
		//echo "<pre>";print_r($data);exit;
		foreach($ids as $id){
			$this->db->delete('mep_tb_Testimonials','TestimonialId',$id);
		}
		$result=array('error'=>1,'errorMsg'=>'Selected records deleted successfully.');
		$this->session->set_userdata($result);
		return $result;
	}
	public function deleteTestimonial($tids)
	{
		$this->db->query("DELETE FROM mep_tb_Testimonials where TestimonialId in ($tids)");
		return 1;
	}
	public function deleteAllTestimonial($tids)
	{
		$tids =	implode(",",$tids);   
		$this->db->query("DELETE FROM mep_tb_Testimonials where TestimonialId in ($tids)");
		return 1;
	}

		function deleteenquiry($tids)
	{
		$tids =	implode(",",$tids);
			$this->db->query("DELETE FROM mep_enquiry where id in ($tids)");
		return 1;
	}
	function deletecontact($tids)
	{
		$tids =	implode(",",$tids);
			$this->db->query("DELETE FROM mep_contact_us where id in ($tids)");
		return 1;
	}
	function delete1contact($id)
	{
		//$id =$biids;
		//var_dump($id);die;
			$this->db->query("DELETE FROM mep_contact_us where id in ($id)");
		return 1;
	}
	
	public function deleteuser($tids)
	{
		$tids =	implode(",",$tids);
		$this->db->query("UPDATE mep_users set status=2  where userid in ($tids)");
		return 1;
	}
	
	public function getContactUsMessages($limit='', $offset='')
	{
 $sql = "SELECT * from mep_contact_us where status in(0,1) order by id desc";
		

			
			if($this->input->post())
			{
            $email = $this->input->post('email');
			$name=$this->input->post('name');
			$phone=$this->input->post('mobile');
			$course=$this->input->post('course');
			
			
			if($email!='')
			$sql.= "  AND email like '%$email%'";    
			
			if($name!='')
			$sql.= "  AND name like '%$name%'";
			
		
		}
        $tot=$sql;
        $sql.=" limit $limit,$offset";
        	$query = $this->db->query($sql);
			$total = $this->db->query($tot);
			return array("rows"=>$query->result(),"total"=>$total->num_rows());
		

	}
	 function get_corporate($id="")
	{
		 return $this->db->get_where('mep_tb_corporate', array('cid' => $id))->result_array();
	}
	 function get_feedbackReq($id="")
	{
		 return $this->db->get_where('mep_feedback', array('id' => $id))->result_array();
	}
  
	public function enquiry($limit, $offset)
	{
		$query = $this->db->query("select * from mep_enquiry LIMIT $offset, $limit");
		return $rows= $query->result();
	}
	
	public function Insertsliderimages($file_path='')
	{
		
		$data=$this->input->post();
		$result=array('error'=>0,'errorMsg'=>'Error Occured');
		$idata=array();
		  
		if(isset($data['BannerName']) && $data['BannerName'])
			$idata['BannerName']=$data['BannerName'];
			
		if(isset($data['status']) && $data['status'])
			$idata['status']=$data['status'];
		       # var_dump($idata['status']);die;    
		if(isset($data['BannerDesc']) && $data['BannerDesc'])
			$idata['BannerDesc']=$data['BannerDesc'];
		else 
			$idata['BannerDesc']='';
		if($file_path!='')
		$idata['BannerImage'] = $file_path;
        $idata['status'] = $data['status'];
		if($data['bid']){
			
			$idata["last_modified"] = date("Y-m-d H:i:s");
			$this->db->where('BannerId',($this->input->post ('bid')));
			$this->db->update('mep_tb_Banners',$idata);
			$result=array('error'=>1,'errorMsg'=>'Banners updated successfully.');
		}else {
			$bid=""; 
			$idata["CreatedDate"] = date("Y-m-d H:i:s");
			$idata["last_modified"] = date("Y-m-d H:i:s");
			$idata['CreatedBy'] = $this->session->userdata('admin_id');
			$this->db->insert('mep_tb_Banners',$idata);
			$BannerId=$this->db->insert_id();
			$result=array('error'=>1,'errorMsg'=>'Banners added successfully.');
		}
		$this->session->set_userdata($result); 
		return $result;
	}
	public function getallbanners($limit='',$offset='')
    {
		$result=$this->input->post();
		$name = $this->input->post('name');
		$this->db->order_by("last_modified", "desc"); 
		if(!empty($result))
		{
			$sql = "SELECT * from mep_tb_Banners where status in(0,1)";
			if($name!='')
			$sql.= "  AND BannerName like '%$name%'";
			#echo $sql; die;
			return array("total"=>$this->db->query($sql)->num_rows(),
						"rows"=>$this->db->query($sql)->result());
		}
		else{
			
			$query= $this->db->get_where('mep_tb_Banners',array(),$limit,$offset);
			return array("total"=>$this->db->get("mep_tb_Banners")->num_rows(),
						"rows"=>$query->result());
		}
		
    }

public function gettest21($idb="")
	{
		 return $this->db->get_where('mep_tb_Banners', array('BannerId' => $idb))->result_array();
		
	}


public function testbimage()
{
	  $this->load->database();
       $query=$this->db->get('mep_tb_Banners');
       return $query->result();
	   
	}
	

	
	  

	public function Deletebanner()
	{
		$result=array('error'=>0,'errorMsg'=>'Error Occured.');
		$data=$this->input->post();
		//echo "<pre>";print_r($data);exit;
		foreach($bannerids as $id){
			$this->db->delete('mep_tb_Banners','BannerId',$id);
		}
		$result=array('error'=>1,'errorMsg'=>'Selected records deleted successfully.');
		$this->session->set_userdata($result);
		return $result;
	}
	public function deleteImages($biids)
	{
		$biids =	implode(",",$biids);
			$this->db->query("DELETE FROM mep_tb_Banners where BannerId in ($biids)");
		return 1;
	}
	public function deleteoneImage($id)
	{
		//$id =$biids;
		//var_dump($id);die;
			$this->db->query("DELETE FROM mep_tb_Banners where BannerId in ($id)");
		return 1;
	}
	
	function changestatus1($var)
{
	  $this->db->query("UPDATE `mep_tb_Banners` SET STATUS=NOT STATUS WHERE BannerId = $var");
      
	   
	}

	
	/*
public function Insertsliderimages($file_path='')
	{
		
$data=$this->input->post();
print_r($data);exit;
		$data=$this->input->files();
		
		
		$result=array('error'=>0,'errorMsg'=>'Error Occured');
		$idata=array();
		
		if(isset($data['BannerName']) && $data['BannerName'])
			$idata['BannerName']=$data['BannerName'];
			if(isset($data['BannerDesc']) && $data['BannerDesc'])
			$idata['BannerDesc']=$data['BannerDesc'];
			
		
		
			else
			$idata['BannerDesc']='';
			if(isset($_FILES['BannerImage'])&&$_FILES['BannerImage'])
				 $idata['BannerImage']=$file_path;
        
	
		echo "<pre>";print_r($idata); exit;
		if($data['BannerId']) {
			$where=array('BannerId'=>$data['BannerId']);
			$this->db->update('mep_tb_Banners',$idata,$where);
		if($postId) {
			$where=array('BannerId'=>$postId);
			$this->db->update('mep_tb_Banners',$idata,$where);
			$result=array('error'=>1,'errorMsg'=>'Banner Image(s) updated successfully.');
		
		} else {
			print_r($idata);exit;
				foreach($t as $k=>$v){
				foreach($data['BannerName'] as $multipleid) {
					$ddate=array('multiple_id'=>$multipleid,'filename'=>$v);	
					$ddate['BannerImage']=$data['BannerImage'];
					$this->db->insert('mep_tb_Bannerimages',$ddate);
				}
			}
				$this->db->insert('mep_tb_Banners',$idata);
				
			$result=array('error'=>1,'errorMsg'=>'Banner Image(s) added successfully.');
		}
		
		$this->session->set_userdata($result);
		return $result;
		echo "<pre>";print_r($_FILES);exit;
		
		}*/
		
          public function corporateuser($limit='',$offset='')
    {
			$result=$this->input->post();
		    $email = $this->input->post('email');
			$name=$this->input->post('name');
			$phone=$this->input->post('mobile');
			$designation=$this->input->post('designation');
				#var_dump($name);die;
		   if(!empty($result))
		{
		$sql = "SELECT * from mep_tb_corporate where status in(0,1)";
				
			if($email!='')
			$sql.= "  AND cemail like '%$email%'";
			if($phone!='') 
			$sql.= "  AND cmobile like '%$phone%'";
			if($name!='')
			$sql.= "  AND cname like '%$name%'";
			if($designation!='')
			$sql.=" AND cdesignation like '%$designation%'";
			  
			#echo $sql; die;
	 	
		#var_dump($abc);die;
			return $this->db->query($sql)->result();
		}
		    else{ 
		
		 $query= $this->db->order_by('cid', 'DESC')->get_where('mep_tb_corporate',array(),$limit,$offset);
		 #var_dump($query);die;
         return $query->result();
		}
    }
	function FeedbackRequests($limit='',$offset='')
	{
		$email = (isset($_REQUEST['feed_email']))?$_REQUEST['feed_email']:'';
		$name = (isset($_REQUEST['feed_name']))?$_REQUEST['feed_name']:'';
		$phone = (isset($_REQUEST['feed_mobile']))?$_REQUEST['feed_mobile']:'';
		$category = (isset($_REQUEST['feed_category']))?$_REQUEST['feed_category']:'';
		
			$sql = "SELECT * from mep_feedback where status in(0,1)";  
			if($phone!='') 
			$sql.= "  AND phoneno like '%$phone%'";
			if($name!='')
			$sql.= "  AND name like '%$name%'";
			if($email!='')
			$sql.= "  AND email like '%$email%'";
			if($category!='')
			$sql.= "  AND category like '%$category%'";
			$tsql = $sql;
			$sql.=" order by id desc limit $limit, $offset";
			#echo $sql; die;
			$query = $this->db->query($sql);
			return array("rows"=>$query->result(),"total"=>$this->db->query($tsql)->num_rows());
		
		
	}
	function deletecorporate($tids)
	{
		$tids =	implode(",",$tids);
			$this->db->query("DELETE FROM mep_tb_corporate where cid in ($tids)");
		return 1;
		
	}
	function deleteFeedback($id)
	{

		$this->db->query("DELETE FROM mep_feedback where id in ($id)");
		return 1;
	}
	public function deleteonecorporate($id)
	{
		//$id =$biids;
		//var_dump($id);die;
			$this->db->query("DELETE FROM mep_tb_corporate where cid in ($id)");
		return 1;
	}
	function deleteCheckedFeedback($tids)
	{
		$tids=implode(",",$tids);
		$this->db->query("DELETE from mep_feedback where id in ($tids)");
		return 1;  
	}
	
	public function deleteonecontact($id)  
	{
		//$id =$biids;
		//var_dump($id);die;
			$this->db->query("DELETE FROM mep_contact_us where id in ($id)");
		return 1;
	}
	
         public function getimages($id="")
	{
		$result=$this->getRecord('*','mep_tb_Banners','id="'.$id.'"' );
		
		return $result;
	}
	
	function changestats($var)
	{
		$this->db->query("UPDATE `mep_tb_Testimonials` SET STATUS=NOT STATUS WHERE TestimonialId = $var"); 
	}

	function getIndianStateVisitorLogs($start_date,$end_date)
	{
		return $this->db->query("SELECT state, COUNT(log_id) AS visits FROM visitor_access_log WHERE country_code='IN'
				 AND recorded_datetime BETWEEN '$start_date' AND '$end_date 23:59:59' GROUP BY state ORDER BY visits DESC")->result();
	}
	function getIndianCityVisitorLogs($start_date,$end_date)
	{
		return $this->db->query("SELECT city, COUNT(log_id) AS visits FROM visitor_access_log WHERE country_code='IN'
		AND recorded_datetime BETWEEN '$start_date' AND '$end_date 23:59:59'
		GROUP BY city ORDER BY visits DESC")->result();
	}
	function getStateVisitorPercentage($start_date,$end_date)
	{
		$givendates = $this->db->query("SELECT state, COUNT(log_id) AS visits FROM visitor_access_log 
		WHERE country_code='IN' AND recorded_datetime BETWEEN '$start_date' AND '$end_date 23:59:59'
		GROUP BY state ORDER BY visits DESC
		LIMIT 3")->result();
		$resultArray = array();
		foreach($givendates as $gstate)
		{
			$state = $gstate->state;
			$gvisits = $gstate->visits;
			
			$totalvisits = $this->db->query("SELECT COUNT(log_id) AS overallvisits FROM visitor_access_log 
			WHERE country_code='IN'  AND state='$state'")->result();
			
			$overallvisits = 0;
			if(count($totalvisits)>0)
				$overallvisits = $totalvisits[0]->overallvisits;
			if($overallvisits>0)
			{
				$percentage = ($gvisits/$overallvisits) * 100;
				$percentage-=100;
			}else
				$percentage = 0;
			$resultArray[] = array(
				"state" =>$state,
				"visits_in_given_date"=>$gvisits,
				"overallvisits"=>$overallvisits,
				"percentage"=>$percentage,
			);
		}
		return $resultArray;
	}
	function getCityVisitorPercentage($start_date, $end_date)
	{
		$givendates = $this->db->query("SELECT city, COUNT(log_id) AS visits FROM visitor_access_log 
		WHERE country_code='IN' AND recorded_datetime BETWEEN '$start_date' AND '$end_date 23:59:59'
		GROUP BY city ORDER BY visits DESC
		LIMIT 3")->result();
		$resultArray = array();
		foreach($givendates as $gcity)
		{
			$city = $gcity->city;
			$gvisits = $gcity->visits;
			
			$totalvisits = $this->db->query("SELECT COUNT(log_id) AS overallvisits FROM visitor_access_log 
			WHERE country_code='IN'  AND city='$city'")->result();
			
			$overallvisits = 0;
			if(count($totalvisits)>0)
				$overallvisits = $totalvisits[0]->overallvisits;
			$percentage = ($gvisits/$overallvisits) * 100;
			$percentage-=100;
			$resultArray[] = array(
				"city" =>$city,
				"visits_in_given_date"=>$gvisits,
				"overallvisits"=>$overallvisits,
				"percentage"=>$percentage,
			);
		}
		return $resultArray;
	}
	function getCourseCount()
	{
		return $this->db->get("mep_tb_Course")->num_rows();
	}
	function getBranchCount()
	{
		return $this->db->get("mep_tb_Branches")->num_rows();
	}
	function getStudentCount()
	{
		return $this->db->get("mep_users")->num_rows();
	}
	function getBookingCount()
	{
		return $this->db->get("mep_tb_course_branch_booking")->num_rows();
	}
	function getAdminUsers()
	{
		return $this->db->get("mep_tb_dummyadmins")->result();
	}
	function deleteDummyAdmin($dm_id)
	{
		$this->db->where("dm_id",$dm_id);
		$this->db->delete("mep_tb_dummyadmins");
	}
	function changeDummyAdminpassword($dm_id)
	{
		$rand = rand();
		$password = md5($rand);
		$this->db->where("dm_id",$dm_id);
		$this->db->update("mep_tb_dummyadmins",array(
			"password"=>$password,
			"last_modified" => date("Y-m-d H:i:s")
		));
		$rows = $this->db->get_where("mep_tb_dummyadmins",array("dm_id"=>$dm_id))->result();
		
		
		
		$d=$this->input->post();
				$to=$rows[0]->username;
				$subject ="Password Reset";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: admin@mepcentre.com" . "\r\n";
				$msg=$this->load->view('passwordReset_template','$d',true);
				//var_dump($msg); die;
				$patterns = array();
				$patterns[0] = '/<<password>>/';  
				$replacements = array(); 
				$replacements[0] = $rand;
				$msg = preg_replace($patterns, $replacements, $msg);
				mail($to, $subject, $msg, $headers); 
		
	}
	function addDummyAdmin($username)
	{
		$rows = $this->db->get_where("mep_tb_dummyadmins",array("username"=>$username))->num_rows();
		if($rows>0)
			return 0;
		$rand = rand();
		$password = md5($rand);
		$this->db->insert("mep_tb_dummyadmins",array(
			"username"=>$username,
			"password"=>$password,
			"last_modified" => date("Y-m-d H:i:s"),
			"added_on" => date("Y-m-d H:i:s")
		));
		
		$d=$this->input->post();
				$to=$d['username'];
				$subject ="Welcome to MEP";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: admin@mepcentre.com" . "\r\n";
				$msg=$this->load->view('dummyAdmin_template','$d',true);
				//var_dump($msg); die;
				$patterns = array();
				$patterns[0] = '/<<username>>/'; 
				$patterns[1] = '/<<password>>/';   
				$replacements = array();
				$replacements[1] = $to;  
				$replacements[0] = $rand;
				$msg = preg_replace($patterns, $replacements, $msg);
				mail($to, $subject, $msg, $headers); 	
	}
}
?>