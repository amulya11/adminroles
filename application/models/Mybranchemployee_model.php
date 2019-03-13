<?
class Mybranchemployee_model extends CI_Model {
	function __construct(){
		parent::__construct();

	}
	function getBranchEmpProfile($bemp_id)
	{
		return $this->db->get_where("branch_employees",array("be_id"=>$bemp_id))->result();
	}
	function saveBranchEmployeeAvatar($bemp_id,$file_name)
	{
		$data = array(
		   'bemp_avatar' => $file_name
		);

		$this->db->where('be_id', $bemp_id);
		$this->db->update('branch_employees', $data);
	}
	function saveBranchEmployeeProfile($data, $bemp_id)
	{
		$idata = array(
		   'firstname' => $data["af_name"],
		   'lastname' => $data["al_name"]
		);

		$this->db->where('be_id', $bemp_id);
		$this->db->update('branch_employees', $idata);
	}
	public function changepassword($bemp_id, $data)
	{
		$query = $this->db->get_where('branch_employees', array('be_id' => $bemp_id,"password"=>md5($data['oldpassword'])));
        $rows= $query->result();
		if(count($rows)>0){
			$where=array('be_id'=>$bemp_id);
			$data=array('password'=>md5($data['newpassword']));
			$this->db->update('branch_employees',$data,$where);
			$result=array('error'=>0,'errorMsg'=>'<div class="alert alert-success">Password changed sucessfully</div>');
		} else {
			$result=array('error'=>1,'errorMsg'=>'<div class="alert alert-danger">Invalid current password</div>');	
		}
		$this->session->set_userdata($result);
		return $result;
	}
	function getAssignedRoles($bemp_id)
	{
		$sql="SELECT br.be_role FROM `branch_emp_roles_assigned` ba
		LEFT JOIN `branch_employee_roles_listing` br ON ba.`role_id`= br.`ber_id`
		WHERE ba.`br_emp_id`=$bemp_id";
		return $this->db->query($sql)->result();
	}
	function trashBranchJobPosting($job_id)
	{
		$this->db->where('job_id', $job_id);
		$this->db->where('added_if_branch', $this->session->userdata('branch_id'));
		$this->db->delete('mep_tb_job_postings');
		return $this->db->affected_rows();
	}
	function saveJobPosting($bemp_id, $data)
	{
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
			$idata["added_on"] = date("Y-m-d H:i:s");
			$idata["added_by_user"] = $bemp_id;
			$idata["added_by_user_type"] = "branch_employee";
			$idata["added_if_branch"] = $this->session->userdata('branch_id');
			$this->db->insert("mep_tb_job_postings", $idata);
		}
		
		
	}
	function getRewardTypes()
	{
		return $this->db->get_where("student_reward_types",array("status"=>1))->result();
	}
	function searchStudent($term)
	{
		return $this->db->query("SELECT ul.userid,ul.firstname,ul.lastname,ul.email,ul.mobile,ul.user_avatar,SUM(IFNULL(points,0)) AS points
				FROM mep_users_localization ul
				INNER JOIN mep_users u ON u.userid = ul.userid
				LEFT JOIN student_rewward_earnings re ON re.student_id = u.userid
				WHERE (ul.firstname LIKE '%$term%' OR ul.lastname LIKE '%$term%' OR ul.email LIKE '%$term%' OR ul.mobile LIKE '%$term%') AND u.status = 1
				GROUP BY  ul.userid,ul.firstname,ul.lastname,ul.email,ul.mobile,ul.user_avatar
				")->result();
	}
	function saveRewards($data)
	{
		$idata["student_id"] = $data["studentid"];
		$idata["reward_id"] = $data["rew_type"];
		$idata["points"] = $data["points"];
		$idata["remarks"] = $data["remarks"];
		$idata["added_on"] = date("Y-m-d H:i:s");
		$idata["updated_by_user_id"] = $this->session->userdata('bemp_id');
		$idata["updated_by_user_type"] = "branch_employee";
		$this->db->insert("student_rewward_earnings",$idata);
		
		$this->db->select_sum('points');
		$this->db->from('student_rewward_earnings');
		$this->db->where('student_id', $data["studentid"]);
		$query = $this->db->get();
		$total_sold = $query->row()->points;
		return $total_sold;
	}
}

?>