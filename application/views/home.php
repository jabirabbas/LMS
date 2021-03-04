<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Choice Broking - LMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url('resources/css/bootstrap.min.css?v=1')?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/bootstrap-responsive.min.css')?>" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="<?php echo base_url('resources/css/font-awesome.css')?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/style.css?v=0.2')?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/pages/dashboard.css?v=0.1')?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/datetimepicker.css')?>" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script src="<?php echo base_url('resources/js/jquery-1.7.2.min.js')?>"></script>     
</head>

<body>

<?php 
	$user = $this->session->userdata('user');
	if(!$user) header('Location: '.site_url('login/index'));
?>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?=site_url('home')?>">Choice Broking</a>
      <div class="nav-collapse">
      
      <?php 
			$notifications = $this->session->userdata('notifications');
		?>	
      
        <ul class="nav pull-right">
        	<?php /*<li class="dropdown">
          		<a href="#" class="dropdown-toggle" id="callback" data-toggle="dropdown">
                <?php if(count($notifications) != 0){ ?>
                	<span class="badge" style="display:none;position:absolute;left:-11px;top:0px"><?=count($notifications)?></span> 
                <?php } ?>
                <i class="icon-globe"></i> <strong>Notifications </strong><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <?php 
  				      if(count($notifications) != 0){
                  foreach($notifications as $cb){ 
                    if($cb->type == 'callback'){		
  			      ?>
  					  	<li><a href="<?php echo site_url('leads/edit/'.$cb->id)?>"><?=$cb->firstname.' '.$cb->lastname.' ('.$cb->mobile.')<br/><i class="icon-headphones"></i> Callback - '.date('d M Y', strtotime($cb->date))?></a></li>
  					  <?php } else { ?>
              	<li><a href="<?php echo site_url('leads/edit/'.$cb->id)?>"><?=$cb->firstname.' '.$cb->lastname.' ('.$cb->mobile.')<br/><i class="icon-warning-sign"></i> CED - '.date('d M Y', strtotime($cb->date))?></a></li>
              <?php }}} else { ?>  
              	<li><a href="javascript:void(0)">No New Notifications!</a></li>
              <?php } ?>
            </ul>
          </li> */?>
          
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo 'Welcome '.ucwords($this->session->userdata('user')->name)?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo site_url('profile')?>">Change Password</a></li>
              <li><a href="<?php echo site_url('login/logout')?>" id="logout">Logout</a></li>
            </ul>
          </li>
        </ul>
        
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->

<?php 
	
	$role = $this->session->userdata('user')->role;
  $this->load->view('menu.php', array('role'=>$role));
  
?>

<!-- /subnavbar -->
<div class="main">
  <div class="main-inner" style="min-height:430px">
		
    <?php 
			if(isset($filename)){ 
				$this->load->view($filename);    
			} else {
				//echo '<h2 align="center">'.ucwords($role).' Login</h2>';	
			
    	 /*if($role != "Admin"){ ?>
        <div class="widget widget-nopad" style="margin:30px"><div class="alert alert-danger"><font size="+2" style="font-style:italic">"</font> <?=$message->message.'<font size="+2" style="font-style:italic">"</font><br/><em>-'.date('d M Y H:i', strtotime($message->datetime)).'</em>'?></div></div>
        <?php }*/ ?>
      <div class="container">  
        <?php if($role != "Youtuber" and $role != 'Executive'){ ?>
        	<style>
				@media(min-width: 761px){
					.control-set{
						width:24%;
						float:left;
						padding-right:15px;
					}
					
					.control-set:nth-child(4){
						padding-right:0!important;
						margin-bottom:20px;
					}
					
				}

				@media(max-width: 760px){
					.control-set{
						padding:10px;
					}
					
					.control-set input, .control-set select{
						padding:10px;
						height: 40px
					}
					
				}
					
					.form-actions{
						clear: left;
						margin-top: 20px;
						text-align: right;
						padding: 10px;
						width:98%;
						float:left;
					}
				</style>
        	<div class="widget widget-nopad" id="filterWidget" style="<?=(empty(array_filter($criteria))) ? 'display:none' : ''?>">
	            <div class="widget-header"> <i class="icon-list-alt"></i>
	              <h3>Filter Dashboard</h3>
	            </div>
	            <!-- /widget-header -->
	            <div class="widget-content">
                	<form id="filterForm" action="<?=site_url('home/index')?>" style="margin:0" class="form-horizontal" method="post">

                        <fieldset style="padding:15px"> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                            
                            <?php if($role == 'Admin' or $role == 'Head'){ ?>
                                <div class="control-set">                                           
                                    <label class="controlset-label" for="username">Source</label>
                                    <div class="control">
                                        <select class="span3" name="source" id="source">
                                        <option value="">-- Select Source --</option>
                                        <?php foreach($source as $u){ ?>
                                            <option <?=($u->source == $criteria['source']) ? 'selected' : ''?> value="<?=$u->source?>"><?=$u->source?></option>
                                        <?php } ?>   
                                    </select>
                                    </div> <!-- /controls -->               
                                </div> <!-- /control-group -->
                            <?php } else if($role == 'Manager') { ?>
                                <input type="hidden" name="source" value="<?=$this->session->userdata('user')->source?>" />    
                            <?php } ?>
                            
                            <div class="control-set">											
                                <label class="controlset-label" for="username">From Date</label>
                                <div class="control">
                                	<input type="text" class="span3 datepicker" readonly="" id="fromdate" name="fromdate" value="<?=$criteria['fromdate']?>" />
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                            
                            <div class="control-set">											
                                <label class="controlset-label" for="username">To Date</label>
                                <div class="control">
                                	<input type="text" class="span3 datepicker" readonly="" id="todate" name="todate" value="<?=$criteria['todate']?>" />
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->

                            <div class="form-actions" style="margin-top:20px; margin-bottom: 0!important">
                            	<?php if(!empty(array_filter($criteria))){ ?>
                            		<button type="button" onclick="$('#excelForm').submit()" class="btn btn-warning">Export Leads to Excel</button>
                            	<?php } ?>	
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" class="btn" onclick="location.href='<?php echo site_url('home')?>'">Reset</button>
                            </div> <!-- /form-actions -->
                        </fieldset>
                    </form> 
                    <form method="post" action="<?php echo site_url('home/excel')?>" id="excelForm">
                        <input type="hidden" name="source" value="<?=$criteria['source']?>">
                        <input type="hidden" name="fromdate" value="<?=$criteria['fromdate']?>">
                        <input type="hidden" name="todate" value="<?=$criteria['todate']?>">
                    </form>
	            </div>
	        </div>        	
          
	        <div class="widget widget-nopad">
	            <div class="widget-header"> <i class="icon-list-alt"></i>
	              <h3>Statistics</h3>
	              <i class="icon-filter" onclick="$('#filterWidget').slideToggle('medium');" style="float: right; padding:13px 15px 0 0"></i>
	            </div>
	            <!-- /widget-header -->
	            <div class="widget-content">
	              <div class="widget big-stats-container">
	                <div class="widget-content">
	                  <div id="big_stats" class="cf">
	                    <div class="stat"> <i class="text-warning icon-time"></i> <span class="value"><?=($numbers['Pending']) ?? 0?></span><h3>Pending</h3> </div>
	                    <!-- .stat -->
	                    
	                    <div class="stat"> <i class="text-primary icon-sitemap"></i> <span class="value"><?=($numbers['Assigned']) ?? 0?></span><h3>Assigned</h3> </div>
	                    <!-- .stat -->
	                    
	                    <div class="stat"> <i class="text-info icon-refresh"></i> <span class="value"><?=($numbers['In Process']) ?? 0?></span><h3>In Process</h3> </div>

	                    <div class="stat"> <i class="text-purple icon-file"></i> <span class="value"><?=($numbers['KYC']) ?? 0?></span><h3>KYC</h3> </div>
	                    <!-- .stat -->
	                    
	                    <div class="stat"> <i class="text-success icon-ok-sign"></i> <span class="value"><?=($numbers['AC Opened']) ?? 0?></span><h3>A/C Opened</h3> </div>
	                    <!-- .stat -->

	                    <div class="stat"> <i class="text-danger icon-remove-sign"></i> <span class="value"><?=($numbers['Failed']) ?? 0?></span><h3>Failed</h3> </div>
	                    <!-- .stat --> 

	                    <!--<div class="stat"> <i class="icon-group"></i> <span class="value"><?=($stats->users) ?? 0?></span><h3>Users</h3></div>-->
	                  </div>
	                </div>
	              </div>
	            </div>
	        </div>
        <?php } ?>

        <div class="row">
        	<div class="span6">
      			<div class="widget widget-nopad">
		            <div class="widget-header"> <i class="icon-bar-chart"></i>
		              <h3>Graphical Representation</h3>
		            </div>  
		            <div class="widget-content">
		              <div class="widget big-stats-container">
		                  <div class="widget-content" id="pie" style="padding-top:20px">
		                  </div>
		              </div>      
		            </div>
	          	</div>
	        </div>
			<div class="span6">
          		<div class="widget widget-nopad">
		            <div class="widget-header"> <i class="icon-bar-chart"></i>
		              <h3>Monthly Statistics</h3>
		            </div>  
		            <div class="widget-content">
		              <div class="widget big-stats-container">
		                  <div class="widget-content" id="bar" style="padding-top:20px">
		                  </div>
		              </div>      
		            </div>
		        </div>
		    </div>
		</div>                    
         
          <div class="widget widget-nopad hide" style="margin:30px">
            <div class="widget-header"> <i class="icon-envelope"></i>
               <?php if($role!="Admin"){ ?>
              	<h3>Other Messages from Admin</h3>
               <?php } else { ?>
                <h3>Messages By Admin</h3>
               <?php } ?> 
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                	<div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>&nbsp;</th>
                                <th>Date</th>
                                <?php if($role=="Admin"){ ?><th>To</th><?php } ?>
                                <th>Type</th>
                                <th>Message</th>
                                
                            </tr>
                            <?php $i=1; foreach($messages as $m){ ?>
                                <tr>
                                	<td><?=$i.'.'?></td>
                                    <td><?=date('d M Y H:i:s', strtotime($m->datetime))?></td>
                                    <?php if($role=="Admin"){ ?><td><?=$m->name?></td><?php } ?>
                                    <td><?=$m->type?></td>
                                    <td><?=nl2br($m->message)?></td>
                                </tr>
                            <?php $i++; } ?>
                        </table>
                    </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          
          <?php } ?>
  </div>
  
</div>



<div class="footer hide">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12">Developed by  <a style="color:#FFF" href="https://www.jacwiz.com" target="_blank">JACWIZ</a> </div>
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="<?php echo base_url('resources/js/bootstrap.js')?>"></script>
<script src="<?php echo base_url('resources/js/datetimepicker.js')?>"></script>
<script src="<?php echo base_url('resources/js/base.js')?>"></script> 

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#top").click(function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
	});

	$('#filterForm').submit(function(){
		var date1 = new Date($('#fromdate').val()).getTime();
		var date2 = new Date($('#todate').val()).getTime();
		if(date2 < date1){
			alert('To date cannot be less than From date.')
			return false;
		} else {
			return true;
		}
	})

	//sliding up message div
	if($(".alert-success").is(':visible')){
		$(".alert-success").delay(4000).slideUp('fast');	
	}
	
	if(sessionStorage.badgeSeen==0 || typeof sessionStorage.badgeSeen == 'undefined'){
		$('.badge').show();
    } 
	
	$("#callback").click(function(){
		$(this).find('.badge').remove()	
		sessionStorage.badgeSeen=1;
	});
	
	$("#logout").click(function(){
		sessionStorage.badgeSeen=0;
		location.href='<?php echo site_url('login/logout')?>';
	});

  Highcharts.chart('pie', {
    chart: {
        type: 'pie',
    },
    title:'',
    tooltip: {
        pointFormat: '<b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    credits:{enabled:false},
    series: [{
        type: 'pie',
        name: 'Lead Status',
        data: <?=$graph?>,
        point:{
              events:{
                  click: function (event) {
                      location.href = '<?=site_url('leads/index')?>/'+this.name;
                  }
              }
          }         
    }]
  });


  Highcharts.chart('bar', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Total Leads Monthwise'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: <?=json_encode($months)?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Leads'
        }
    },
    tooltip: {
        headerFormat: null,
        pointFormat: '<tr><td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    credits:{enabled:false},
    series: [{
        name: 'Leads',
        data: <?=json_encode($count,JSON_NUMERIC_CHECK)?>
    	}]
	});

});

</script>


</body>
</html>