<!DOCTYPE html>
<html>
  <head>
		<?$this->load->view('branchemployee/common/head');?>
		<link href="<?echo base_url('plugins/select2/select2.min.css');?>" rel="stylesheet" />
		<style>
			.select2-selection__choice{
				background-color:#36AF79 !important;
			}
			.select2-selection__choice__remove{
				color:black !important;
			}
		</style>
		<link href="<?echo base_url('plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
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
            My Branch Bookings
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Bookings </li>
          </ol>
        </section>


        <section class="content">
		<div class="row">
		<div class="col-md-12">
        
			<!-- general-form elements starts-->
			<div class="box box-danger">
				
				<div class="box-header with-border">
				<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<h3 class="box-title">Search</h3>
						</div>
				</div>
                </div>
                    
				<div class="box-body">
                	<div class="callout callout-success" style="display:none">
						<h4>Success</h4>
						<p></p>
					</div>

					<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
								<label>Type</label>
								<select id="ctype" class="form-control crs-select"> 
									<option value="">All</option>
									<?foreach($ctypes as $ctype)
									echo "<option value='".$ctype->CourseTypeId."'>".$ctype->CourseTypeName."</option>";?>
									</select>
                    		</div>                            

							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
								<label>Start</label>
								<input id="filter_start" class="crs-input" data-date-format="dd/mm/yyyy" readonly size="10">
                    		</div>                            

							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
								<label>End</label>
								<input id="filter_end" class="crs-input" data-date-format="dd/mm/yyyy" readonly size="10">
                    		</div>                            

							<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
								<label>Search</label>
                                <input id="q" type="text" class="crs-input">
                    		</div>                            

							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            	<label class="width-p100 hidden-xs hidden-sm">&nbsp;</label>
                        		<button class="btn btn-info" type="submit" onclick="getBookings(1);">
                            		<i class="fa fa-fw fa-search"></i> Search</button>
                    		</div>                            
                            
					</div>

                    <!--Widgetbody starts -->
					<div class="widget-body mar-t10"> 

					<!-- BEGIN FORM-->
					<div class="col-md-12">
                    <div class="row">
                    

                            <!-----table-starts here -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                            
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped bs-events-table" id="bookings_table">
                                    <thead>
                                        <tr>
											<th class="text-center" style="width:15%">Course</th>
                                            <th class="text-center">Student Details</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Schemes</th>
                                            <th class="text-center">Payment Details</th>
                                        </tr>
                                    </thead>
									<tbody>
										
									</tbody>  
                                    
                                </table>        
                                </div>
                                <div class="col-md-12 text-right">
                                    <ul class="pagination" id="pagination">
                                        
                                    </ul>
                                </div>
                               <div class="loading" align="center">
                                        Loading. Please wait.<br>
                                        <br>
                                        <img src="<?echo base_url('images/715.GIF')?>" alt="">
                                    </div>
                               
                            </div>     
                            </div>     
                            <!-----table-starts ends-->
						
					</div>
					</div>
                    <!-- END FORM-->  

                  
					</div>
                    <!--Widgetbody ends-->

				</div>


			</div>
			<!-- general-form elements ends-->
		
        </div>
		</div>
		</section>
	
    </div>
	<!-- /.content-wrapper -->

		<?$this->load->view('branchadmin/common/footer');?>
	
			<!-- Modal content ends-->
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?echo base_url();?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?echo base_url();?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?echo base_url();?>/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?echo base_url();?>/dist/js/app.min.js"></script>
	 <script src="<?echo base_url('plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
	<script src="<?echo base_url('plugins/select2/select2.full.min.js');?>"></script>
	<script>
	var schmes_options='';
	<?foreach($govt_schemes as $scheme){?>
		schmes_options+="<option value='<?echo $scheme->gs_id;?>'><?echo $scheme->gs_name;?></option>"
	<?}?>
														
													
	var startDate = new Date('01/01/2012');
	var FromEndDate = new Date();
		$("#filter_start").datepicker({
				format: "yyyy-mm-dd",
				autoclose: true
			}).on('changeDate', function(selected){
				startDate = new Date(selected.date.valueOf());
				startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
				$('#filter_end').datepicker('setStartDate', startDate);
			});
			
			$("#filter_end").datepicker({
				format: "yyyy-mm-dd",
				autoclose: true
			}).on('changeDate', function(selected){
				FromEndDate = new Date(selected.date.valueOf());
				FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
				$('#filter_start').datepicker('setEndDate', FromEndDate);
			});
		$(function(){
			getBookings(1)
		})
		function getBookings(page)
		{
			var modal = $('<div />');
			modal.addClass("modal");
			$('body').append(modal);
			var loading = $(".loading");
			var top = Math.max($(window).height() / 2 - loading[0].offsetHeight / 2, 0);
			var left = Math.max($(window).width() / 2 - loading[0].offsetWidth / 2, 0);
			loading.css({ top: top, left: left });
			$.ajax({
				url:"<?echo base_url('mybranchemployee/bookings')?>",
				type:"post",
				data:{
					type: $("#ctype").val(),
					start: $("#filter_start").val(),
					end: $("#filter_end").val(),
					q: $("#q").val(),
					page: page
				},
				beforeSend:function(){
					loading.show();
				},
				complete:function(){
					loading.hide();
				},
				success:function(data){
					data = $.parseJSON(data)
					var html=''
					$.each(data.bookings, function(i){
							var item = data.bookings[i];
							var course_type_name= "<strong>Type:</strong><p>"+item.CourseTypeName+"</p>"+
							"<strong>Name:</strong><p>"+item.CourseName+"</p>";
							if(item.courseStatus=="1")
								course_type_name+="<strong>Course Status:</strong><p><a class='label label-success'>Active</a></p>";
							else if(item.courseStatus=="0")
								course_type_name+="<strong>Course Status:</strong><p><a class='label label-warning'>Inactive</a></p>";
							else
								course_type_name+="<strong>Course Status:</strong><p><a class='label label-danger'>Deleted</a></p>";
							
							var student_details= "<strong>Name:</strong><p>"+item.firstname+" "+item.lastname+"</p>"+
							"<strong>Email:</strong><p>"+item.email+"</p>"+
							"<strong>Mobile:</strong><p>"+item.mobile+"</p>"+
							"<span class='usr-nme-imgbx'><img alt='' src='<?echo str_replace('/backend','',base_url());?>/images/userimages/thumbs/"+item.user_avatar+"'></span>";
							
							var reg_dtls = "<strong>Date:</strong><p>"+item.registered_datetime+"</p>"+
							"<strong>Seat:</strong><p>"+item.seat_num+"</p>";
							
							var xml = item.server_response_xml;
							var payment_dtls = "<strong>Amount:</strong><p>"+$(xml).find('amount').text()+"</p>"+
							"<strong>TxnId:</strong><p>"+$(xml).find('txnid').text()+"</p>"+
							"<strong>Bank Ref Num:</strong><p>"+$(xml).find('bank_ref_num').text()+"</p>"+
							"<strong>Name on Card:</strong><p>"+$(xml).find('name_on_card').text()+"</p>"+
							"<strong>Card Num:</strong><p>"+$(xml).find('cardnum').text()+"</p>";
							
							var schemes_string="<div class='ldrps'><select cbbid='"+item.cbb_id+"' style='width:100%' name='gscheme_booking' class='form-control select2 select2-hidden-accessible' data-placeholder='Schemes' multiple='' tabindex='-1' aria-hidden='true'>"+schmes_options+"</select>"	+
								"<img class='loading-imgwrps' name='loading-imgwrps-' src='<?echo base_url('images/715.GIF')?>'></div>";
	
							html+="<tr><td>"+course_type_name+"</td><td>"+student_details+"</td>"+
								"<td>"+reg_dtls+"</td><td class='bokg-tab-wd200'>"+schemes_string+"</td><td>"+payment_dtls+"</td></tr>";
						
					})
					
						$("#bookings_table").find('tbody').html(html)
						$(".select2").select2()
						getCourseBookingSchemes()
						$("#pagination").html(data.pagination)
						$(document).find(".pagination li").on("click",function(){
							cpage=$(this).attr('page');
							getBookings($(this).attr('page')) 
						})
						$("#pagination").show()
				}
			})
		}
		function getCourseBookingSchemes()
		{
			var bookings=[];
			$("[name=gscheme_booking]").each(function(){
				bookings.push($(this).attr("cbbid"))
			})
			$.ajax({
				url:"<?echo base_url('mybranchemployee/getCourseBookingSchemes')?>",
				type:"post",
				async:false,
				data:{
					bookings:bookings
				},
				beforeSend:function(){
					
				},
				complete:function(){
					
				},
				success:function(data){
					data =$.parseJSON(data)
					$.each(data,function(i){
						var item = data[i];
						var values = []
						$.each(item, function(j){
							values.push(item[j].scheme_id)
						})
						
						$("[cbbid="+i+"]").select2("val",values)
					})
				}
			})
			bindSave()
		}
		function bindSave()
		{
			$("[name=gscheme_booking]").on("change",function(){
			var cbbid = $(this).attr("cbbid");
			$.ajax({
				url:"<?echo base_url('mybranchemployee/saveCBBSchemes')?>",
				type:"post",
				data:{
					bookings:$(this).select2("val"),
					cbbid:cbbid
				},
				async:false,
				beforeSend:function(){
					$("[name=loading-imgwrps-"+cbbid+"]").show()
				},
				complete:function(){
					$("[name=loading-imgwrps-"+cbbid+"]").hide()
				},
				success:function(data){
					
				}
			})
		})
		}
	</script>
  <style>
.loading {
  font-family: Arial;
  font-size: 10pt;
  border: 5px solid #67CFF5;
  width: 200px;
  height: 100px;
  display: none;
  position: fixed;
  background-color: White;
  z-index: 999;
}
.ldrps {
		position: relative;	
	}
	.ldrps .loading-imgwrps{
		position: absolute;
		top: 8px;
		right: 8px;
		width: 16px;
		display:none;
	}
</style>
  </body>
</html>
