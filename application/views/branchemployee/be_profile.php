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
          <h1>My Profile<small></small></h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">My Profile</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
        <div class="alert alert-success alert-dismissible" id="dlg-msg" style="display:none">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4>	<i class="icon fa fa-check"></i> Success!</h4>
			Operation Success. Reloading the data...
		</div>
        

        <div class="row">
          

			<!-------- general-form elements starts -------->
			<div class="col-md-4">
				<div class="box box-danger profile-imgbxch">
                <div class="box-body box-profile">
                <?
				if($bemployee[0]->bemp_avatar)
					$src=base_url("images/branch_employees_images")."/thumbs/".$bemployee[0]->bemp_avatar;
				else
					$src=base_url('images/dummy_user.png');
				?>
					<img id="user_profile_pic" src="<?echo $src;?>" style="height:180px; width:180px" alt="User profile picture" class="profilech-user-img img-responsive img-circle">

                    <br>
					<div class="input-group prf-file-wd100">
					<div class="controls bck-sldimg-box">
                            <form id="pic_form" method="post" enctype="multipart/form-data"> 
                                <input style="width:100%;" type="file" class="file-inputrw input-xxlarge" name="pic" id="pic"> 
                            </form>
                        	<img id="img_upload_preloader" style="display:none" src="<?echo base_url('images/Preloader_3.gif')?>">
						
					</div>
					</div>
                    
                    

                </div>
                </div>
            </div>
            
			<div class="col-md-8">
				<div class="box box-danger">
                    
                    <div class="box-header with-border">
                    <div class="row">
                    
                        <div class="col-xs-9 col-sm-6 col-md-6 col-lg-6">
                            <h3 class="box-title">My Profile</h3>
                        </div>
                        <div class="col-xs-3 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-right">
                                    <div class="btn-group">
                                        <button data-original-title="Edit" data-toggle="modal" data-target="#profileModal" class="btn btn-sm btn-primary mar-b5" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
    
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
										<td colspan="3">
											<h3>
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
											</h3>
										</td>
									</tr>
									<tr>
										<td class="profile-minwd150"><strong>Email </strong></td>
										<td class="word-break-txt"><?echo $bemployee[0]->email;?></td>
									</tr>
									<tr>
										<td class="profile-minwd150"><strong>Branch</strong></td>
										<td class="word-break-txt"><span><?echo $bemployee[0]->branch_id;?></span></td>
									</tr>
									<tr>
										<td class="profile-minwd150"><strong>Member since</strong></td>
										<td class="word-break-txt"><?echo $bemployee[0]->added_on;?></td>
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
		
        </section>
        <!-- /.content -->
      </div><!-- /.content-wrapper -->

		<?$this->load->view('branchemployee/common/footer');?>
<!---- Modal-poup-starts ----->
	<div class="modal fade"  id="profileModal" role="dialog">
    <div class="modal-dialog">
      
		<!-- Modal content starts-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"> Update Your Profile</h4>
			</div>


			<div class="modal-body">
				<div class="row">   
				<div class="col-lg-12">

					<div class="input-group urs-wd-sm">
						<span class="input-group-addon urs-min-wd150">First Name</span>
						<input type="text" id="af_name" class="form-control" required='required' value="<?php echo  $bemployee[0]->firstname; ?>" placeholder="First Name" />                        
					</div>
					<br>
					<div class="input-group urs-wd-sm">
						<span class="input-group-addon urs-min-wd150">Last Name</span>
						<input type="text" id="al_name" class="form-control" required='required' value="<?php echo  $bemployee[0]->lastname; ?>" placeholder="Last Name" />                        
					</div>
					<br>
					<div class="input-group urs-wd-sm">
						<span class="input-group-addon urs-min-wd150">E-mail</span>
						<input readonly type="email" class="form-control" value="<?php echo  $bemployee[0]->email; ?>" />                        
					</div>

                </div>
                </div>
			</div>
			
            <div class="modal-footer text-right"> 	
            		<img src="<?echo base_url('images/715.GIF')?>" id="save_preloader" style="display:none;" />
					<button class="btn btn-md btn-primary" id="saveProfile">
                    	<i class="fa fa-fw fa-save"></i> Save</button>
					<button class="btn btn-md btn-warning" data-dismiss="modal">
                    	<i class="fa fa-fw fa-times"></i> Close</button>
			</div>

            </form>
            
		</div>
		<!-- Modal content ends-->
        
        
	</div>
	</div>
	<!----- Modal-poup-ends ---->
      
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
	var c=0
	$(':file').change(function(){
			var file = this.files[0];
			var name = file.name;
			var size = file.size;
			var type = file.type;
			var error=0;
			if(file.name.length < 1) {
				alert("Invalid File name")
				error=1;
			}
			else if(file.size > 100000000) {
				alert("File is to big");
				error=1;
			}
			else if(file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg' ) {
				alert("File doesnt match png, jpg or gif");
				error=1;
			}
			else
				error=0;
			
			if(error==0)
			{
				var data = new FormData();
				data.append("images", file);
				var formData = $("#pic_form").serialize();
		
				if (data) {
				  $.ajax({
					url: "<?echo base_url('mybranchemployee/saveBranchEmployeeAvatar')?>",
					type: "POST",
					data: data,
					processData: false,
					beforeSend:function(){
						$("#img_upload_preloader").show()
					},
					complete:function(){
						$("#img_upload_preloader").hide()
					},
					contentType: false,
					success: function (res) {
					  if(res=='0')
					  {
						  
					  }
					  else
					  {
						$("#user_profile_pic").attr("src",res)
						$(".user-image").attr("src",res)
						$(".img-circle").attr("src",res)
					  }
					}
				  });
				}
			}
		});
		$('#profileModal').on('hidden.bs.modal', function (e) {
			if(c==0)
			location.reload()
		})
		$("#saveProfile").click(function(){
			var error=0;
			if($("#af_name").val()=="")
			{
				error=1;
				$("#af_name").css("border","1px solid red")
			}
			else
				$("#af_name").css("border","")
			if($("#al_name").val()=="")
			{
				error=1;
				$("#al_name").css("border","1px solid red")
			}
			else
				$("#al_name").css("border","")
			
			if(error>0)
				return false;
			
			
			$.ajax({
				url: "<?echo base_url('mybranchemployee/saveBranchEmployeeProfile')?>",
				data:{
					addr : $("#addr").val(),
					a_desig : $("#a_desig").val(),
					dob : $("#dob").val(),
					a_mobile : $("#a_mobile").val(),
					s_email : $("#s_email").val(),
					al_name : $("#al_name").val(),
					af_name : $("#af_name").val(),
				},
				type:"POST",
				beforeSend:function(){
					$("#save_preloader").show()
				},
				complete:function(){
					$("#save_preloader").hide()
				},
				success: function(data){
					c=1;
					$('#profileModal').modal('hide')
					$("#dlg-msg").fadeIn().fadeOut(3000,function(){ location.reload(); })
				}
			})
		});
	</script>
  </body>
</html>
