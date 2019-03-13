	<div class="user-panel">
		<div class="pull-left image">
		<?
			if($bAdmin[0]->badmin_avatar)
				$src=base_url("images/badminimages")."/thumbs/".$bAdmin[0]->badmin_avatar;
			else
				$src=base_url('images/dummy_user.png');
		?>
			<img src="<?echo $src;?>" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<p>
			<?
				$fname=$lname="";
				if($bAdmin[0]->first_name)
					$fname=$bAdmin[0]->first_name;
				if($bAdmin[0]->last_name)
					$lname=$bAdmin[0]->last_name;
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
			<li class="<?if($this->uri->segment(2)=="") echo 'active';?>"> 
				<a href="<?echo base_url('mybranch');?>">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li class="<?if($this->uri->segment(2)=="courses") echo 'active';?>">
				<a href="<?echo base_url('mybranch/courses');?>">
					<i class="fa fa-calendar"></i> <span>Courses</span>
				</a>
			</li>
			<li class="<?if($this->uri->segment(2)=="bookings") echo 'active';?>">
				<a href="<?echo base_url('mybranch/bookings');?>">
					<i class="fa fa-book"></i> <span>My Branch Bookings</span>
				</a>
			</li>
			<li class="<?if($this->uri->segment(2)=="enquiries") echo 'active';?>">
				<a href="<?echo base_url('mybranch/enquiries');?>">
					<i class="fa fa-envelope"></i> <span>Messages</span>
				</a>
			</li>
			<li class="<?if($this->uri->segment(2)=="students") echo 'active';?>">
				<a href="<?echo base_url('mybranch/students');?>">
					<i class="fa fa-user"></i> <span>Students</span>
				</a>
			</li>
			<li class="<?if($this->uri->segment(2)=="employees") echo 'active';?>">
				<a href="<?echo base_url('mybranch/employees');?>">
					<i class="fa fa-users"></i> <span>Employees</span>
				</a>
			</li>
			<li class="treeview <?if($this->uri->segment(2)=="events" || $this->uri->segment(2)=="seminars") echo 'active';?>">
				<a href="#"><i class="fa fa-calendar"></i> <span>Events</span> <i class="fa fa-angle-left pull-right"></i></a>
				  <ul class="treeview-menu">
					<li><a href="<?echo base_url('mybranch/events');?>">Event Calender</a></li>
					<li><a href="<?echo base_url('mybranch/seminars');?>">Online Seminars</a></li>
				  </ul>
			</li>
			
			<li class="<?if($this->uri->segment(2)=="careers") echo 'active';?>">
				<a href="<?echo base_url('mybranch/careers');?>">
					<i class="fa fa-graduation-cap"></i> <span>Careers</span>
				</a>
			</li>
			<li class="<?if($this->uri->segment(2)=="rewards") echo 'active';?>">
				<a href="<?echo base_url('mybranch/rewards');?>">
					<i class="fa fa-forumbee"></i> <span>Rewards</span>
				</a>
			</li>
			<li class="">
				<a href="<?echo base_url('mybranch/logout');?>">
					<i class="fa fa-mail-reply-all"></i> <span>Logout</span>
				</a>
			</li>
				<!--
           
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Layout Options</span>
                <span class="label label-primary pull-right">4</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
              </ul>
            </li>
            <li>
              <a href="pages/widgets.html">
                <i class="fa fa-th"></i> <span>Widgets</span> <small class="label pull-right bg-green">new</small>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Charts</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>UI Elements</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Forms</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Tables</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
              </ul>
            </li>
            <li>
              <a href="pages/calendar.html">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
                <small class="label pull-right bg-red">3</small>
              </a>
            </li>
            <li>
              <a href="pages/mailbox/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="label pull-right bg-yellow">12</small>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Examples</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Multilevel</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                    <li>
                      <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                      <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
              </ul>
            </li>
            <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
			-->
	</ul>