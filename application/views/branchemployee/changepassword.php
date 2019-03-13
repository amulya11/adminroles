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
            Change Password
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Change Password</li>
          </ol>
        </section>

         <section class="content">

			<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-danger">
              <?php echo ((isset($_SESSION['errorMsg']))?$_SESSION['errorMsg']:'');?>
				<?php  unset($_SESSION['errorMsg']); ?>
                <div class="box-header with-border">
                  <h3 class="box-title">Change Password</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
              
                <form role="form" id="form" method="post"> 
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Current Password</label>
                      <input type="password" class="form-control required" name="oldpassword" id="oldpassword " placeholder="Current Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">New Password</label>
                      <input type="password" class="form-control required" name="newpassword" id="newpassword" placeholder="New Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Confirm Password</label>
                      <input type="password" id="confirmnewpassword" name="confirmnewpassword" class="form-control required" equalTo="#newpassword"  placeholder="Confirm Password">
                                            
                       
                    </div>
                </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button class="btn btn-md btn-primary" id="btsubmit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>                  
                  </div>
                </form>
              </div><!-- /.box -->

            </div>
            
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
	<script>
	$(document).ready(function(){
	
	$('form').submit(function(e){
		var isValid=true;
		$('input[type="password"]').each(function(){
			
			if($.trim($(this).val())==''){
				isValid=false;
				$(this).css({
					"border":"1px solid red"
				});
			}
			else{
				$(this).css({
					"border":""
				});
			}
		});
		if($("#newpassword").val()!='')
		{
			if($("#newpassword").val()!=$("#confirmnewpassword").val())
			{
				isValid=false;
				$("#newpassword").css({"border":"1px solid red"});
				$("#confirmnewpassword").css({"border":"1px solid red"});
			}
			else{
				$("#newpassword").css({"border":""});
				$("#confirmnewpassword").css({"border":""});
			}
		}
		if(!isValid)
		return false;
	
	});
});
	</script>
  </body>
</html>
