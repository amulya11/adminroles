<!DOCTYPE html>
<html>
  <head>
		<?$this->load->view('branchemployee/common/head');?>
  </head>
  <body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
		<?$this->load->view('branchemployee/common/topnav');?>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          
         
          <!-- sidebar menu: : style can be found in sidebar.less -->
			<?$this->load->view('branchemployee/common/menu');?>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <section class="content">
			<div class="row">
				<!-------- general-form elements starts -------->
				<div class="col-md-5">
					<div class="box box-danger profile-imgbxch">
						<div class="box-body box-profile">
							<?if($branch[0]->map_url!=''){?>
								<iframe src="<?echo $branch[0]->map_url;?>" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen=""></iframe>
							<?}?>
						</div>
					</div>
				</div>
				
				<div class="col-md-7">
					<div class="box box-danger">
						
						<div class="box-header with-border">
						<div class="row">
						
							<div class="col-xs-9 col-sm-6 col-md-6 col-lg-6">
								<h3 class="box-title">My Branch Profile</h3>
							</div>
							<div class="col-xs-3 col-sm-6 col-md-6 col-lg-6">
									<div class="text-right">
										<div class="btn-group">
											
										</div>
									</div>
						  
							</div>
		
						</div>
						</div>

						<div class="box-body">
						<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 user-info">
								<div class="profile-tabbx">
									<table cellpadding="0" cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td colspan="3"><h3><?echo $branch[0]->BranchName;?></h3></td>
										</tr>
										<tr>
											<td class="profile-minwd150"><strong>Email </strong></td>
											<td class="word-break-txt"><?echo $branch[0]->Email;?></td>
										</tr>
										<tr>
											<td class="profile-minwd150"><strong>Mobile</strong></td>
											<td><?echo $branch[0]->PhoneNumber;?></td>
										</tr>
										<tr>
											<td class="profile-minwd150"><strong>Location</strong></td>
											<td><?echo $branch[0]->Location;?></td>
										</tr>
										<tr>
											<td class="profile-minwd150"><strong>Address1</strong></td>
											<td class="word-break-txt"><span><?echo $branch[0]->Address1;?></span></td>
										</tr>
										<tr>
											<td class="profile-minwd150"><strong>Address2</strong></td>
											<td class="word-break-txt"><?echo $branch[0]->Address2;?></td>
										</tr>
										<tr>
											<td class="profile-minwd150"><strong>Pincode</strong></td>
											<td class="word-break-txt"><?echo $branch[0]->Pincode;?></td>
										</tr>
									</tbody>
									</table>
								</div>
								</div>
						</div>
						</div>
					</div>
				</div>
				<!-------- general-form elements ends -------->

			</div>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

		<?$this->load->view('branchemployee/common/footer');?>

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?echo base_url();?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?echo base_url();?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?echo base_url();?>/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?echo base_url();?>/dist/js/app.min.js"></script>
   
  </body>
</html>
