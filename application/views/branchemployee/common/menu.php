	<div class="user-panel">
		<div class="pull-left image">
		<?
			if($bemployee[0]->bemp_avatar)
				$src=base_url("images/branch_employees_images/thumbs")."/".$bemployee[0]->bemp_avatar;
			else
				$src=base_url('images/dummy_user.png');
		?>
			<img src="<?echo $src;?>" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<p>
			<?
				$fname=$lname="";
				if($bemployee[0]->firstname)
					$fname=$bemployee[0]->firstname;
				if($bemployee[0]->lastname)
					$lname=$bemployee[0]->lastname;
				if($fname=="" && $lname=="")
					$name="No Name";
				else
					$name = $fname.' '.$lname;
				echo $name;
					?>
			</p>
			<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		</div>
	</div>
	<ul class="sidebar-menu">
		<li class="header">MAIN NAVIGATION</li>
			<li class="active">
				<a href="<?echo base_url('Mybranchemployee');?>">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<?foreach($roles as $role){
				if($role->be_role == "students")
				{
					$url = base_url('mybranchemployee/students');
					$text = "Students";
					$icon ="fa-users";
				}
				if($role->be_role == "jobs")
				{
					$url = base_url('mybranchemployee/jobs');
					$text = "Careers";
					$icon ="fa-graduation-cap";
				}
				if($role->be_role == "reward points")
				{
					$url = base_url('mybranchemployee/rewards');
					$text = "Reward Points";
					$icon ="fa-forumbee";
				}
				if($role->be_role == "booking management")
				{
					$url = base_url('mybranchemployee/bookings');
					$text = "Booking Management";
					$icon ="fa fa-book";
				}
				echo '<li class="">
						<a href="'.$url.'">
							<i class="fa '.$icon.'"></i> <span>'.$text.'</span>
						</a>
					</li>';
			}?>
			<!--<li class="">
				<a href="<?echo base_url('mybranch/courses');?>">
					<i class="fa fa-calendar"></i> <span>Courses</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-envelope"></i> <span>Messages</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?echo base_url('mybranch/enquiries');?>"><i class="fa fa-commenting"></i>Enquiries</a></li>
					<li class=""><a href="<?echo base_url('mybranch/messages');?>"><i class="fa fa-commenting-o"></i> Contact Messages</a></li>
				</ul>
			</li>
			<li class="">
				<a href="<?echo base_url('mybranch/students');?>">
					<i class="fa fa-users"></i> <span>Students</span>
				</a>
			</li>
			<li class="">
				<a href="<?echo base_url('mybranch/employees');?>">
					<i class="fa fa-users"></i> <span>Employees</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#"><i class="fa fa-calendar"></i> <span>Events</span> <i class="fa fa-angle-left pull-right"></i></a>
				  <ul class="treeview-menu">
					<li><a href="<?echo base_url('mybranch/events');?>">Event Calender</a></li>
					<li><a href="<?echo base_url('mybranch/seminars');?>">Online Seminars</a></li>
				  </ul>
			</li>
			
			<li class="">
				<a href="<?echo base_url('mybranch/careers');?>">
					<i class="fa fa-graduation-cap"></i> <span>Careers</span>
				</a>
			</li>-->
			<li class="">
				<a href="<?echo base_url('mybranch/logout');?>">
					<i class="fa fa-mail-reply-all"></i> <span>Logout</span>
				</a>
			</li>
			
	</ul>