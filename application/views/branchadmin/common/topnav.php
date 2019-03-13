<?
	if($bAdmin[0]->badmin_avatar)
		$src=base_url("images/badminimages")."/thumbs/".$bAdmin[0]->badmin_avatar;
	else
		$src=base_url('images/dummy_user.png');
?>
        <!-- Logo -->
        <a href="<?echo base_url('mybranch');?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>MEP</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>MEP</b>Branch</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		
                  <img src="<?echo $src;?>" class="user-image" alt="User Image">
                  <span class="hidden-xs">
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
				  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?echo $src;?>" class="img-circle" alt="User Image">
                    <p>
						<?echo $name;
						print " - ".$bAdmin[0]->designation;
						//if(isset($bAdmin[0]->$designation))
						//	echo " - ".$bAdmin[0]->designation;
						$added_on = new DateTime($branch[0]->CreatedDate);?>
						
                      <small>Member since <?echo $added_on->format('M').', '.$added_on->format('Y');?></small>
                      
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                      <a href="<?echo base_url('mybranch/changepassword')?>">Change Password</a>
                    </div>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?echo base_url('mybranch/adminProfile');?>" class="btn btn-primary btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?echo base_url('mybranch/logout');?>" class="btn btn-danger btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>