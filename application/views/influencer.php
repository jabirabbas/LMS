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
<link href="<?php echo base_url('resources/css/style.css?v=0.1')?>" rel="stylesheet">
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
        	<!--<li class="dropdown">
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
          </li>-->
          
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
			
    	?>
        
        
      <div class="container">  
        
        	<style>
            .stat h3{font-size: 16px!important}
            .stat sub{
              font-size: 12px;
            }
				  </style>

          <div align="right">
            <form action="<?=site_url('influencer/index')?>" method="post">
              <select name="mfilter" onchange="this.form.submit()">
                <?php 
                  for($i = 0; $i < 3; $i++){
                ?>    
                  <option <?=($filter == date('Y-m',strtotime('-'.$i.' months'))) ? 'selected' : ''?> value="<?=date('Y-m',strtotime('-'.$i.' months'))?>"><?=date('M Y',strtotime('-'.$i.' months'))?></option>
                <?php } ?>
              </select>

            </form>  
          </div>  
        	       	
          <div class="row">
            <div class="span6">
    	        <div class="widget widget-nopad">
    	            <div class="widget-header"> <i class="icon-list-alt"></i>
    	              <h3>Yesterday's Stats</h3>
    	            </div>
    	            <!-- /widget-header -->
    	            <div class="widget-content">
    	              <div class="widget big-stats-container">
    	                <div class="widget-content">
    	                  <div id="big_stats" class="cf">
    	                    <div class="stat"><span class="value"><?=($yesterday->clicks) ?? 0?></span><h3>Clicks</h3> </div>
    	                    <!-- .stat -->
    	                    
    	                    <div class="stat"><span class="value"><?=($yesterday->leads) ?? 0?></span><h3>Leads</h3> </div>
    	                    <!-- .stat -->
    	                    
    	                    <div class="stat"><span class="value"><?=($yesterday->app_installs) ?? 0?></span><h3>App Installs</h3> </div>

    	                    <div class="stat"><span class="value"><?=($yesterday->ac_opened) ?? 0?></span><h3>A/C Opened</h3> </div>
    	                  </div>
    	                </div>
    	              </div>
    	            </div>
    	        </div>
            </div>

            <div class="span6">
              <div class="widget widget-nopad">
                  <div class="widget-header"> <i class="icon-list-alt"></i>
                    <h3>Cost Alloted</h3>
                  </div>
                  <!-- /widget-header -->
                  <div class="widget-content">
                    <div class="widget big-stats-container">
                      <div class="widget-content">
                        <div id="big_stats" class="cf">
                          <div class="stat"><span class="value">&#x20B9;<?=$this->session->userdata('user')->cpc?></span><h3>Clicks</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value">&#x20B9;<?=$this->session->userdata('user')->cpl?></span><h3>Leads</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value">&#x20B9;<?=$this->session->userdata('user')->cpa?></span><h3>App Installs</h3> </div>

                          <div class="stat"><span class="value">&#x20B9;<?=$this->session->userdata('user')->cpo?></span><h3>A/C Opened</h3> </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="span6">
              <div class="widget widget-nopad">
                  <div class="widget-header"> <i class="icon-list-alt"></i>
                    <h3>Yesterday's Earnings</h3>
                    <?php
                      $total = ($this->session->userdata('user')->cpc * $yesterday->clicks) + ($this->session->userdata('user')->cpl * $yesterday->leads) + ($this->session->userdata('user')->cpa * $yesterday->app_installs) + ($this->session->userdata('user')->cpo * $yesterday->ac_opened);
                    ?>
                    <span style="float: right; padding-right: 10px; font-size: medium; <?=($total < 1) ? 'color:red' : 'color:green'?>">&#x20B9;<?=$total?></span>
                  </div>
                  <!-- /widget-header -->
                  <div class="widget-content">
                    <div class="widget big-stats-container">
                      <div class="widget-content">
                        <div id="big_stats" class="cf">
                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpc * $yesterday->clicks)?></span><h3>Clicks</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpl * $yesterday->leads)?></span><h3>Leads</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpa * $yesterday->app_installs)?></span><h3>App Installs</h3> </div>

                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpo * $yesterday->ac_opened)?></span><h3>A/C Opened</h3> </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>

            <div class="span6">
              <div class="widget widget-nopad">
                  <div class="widget-header"> <i class="icon-list-alt"></i>
                    <h3><?=(!isset($mfilter)) ? date('M Y') : $mfilter?>'s Earnings</h3>
                    <?php
                      $mtotal = ($this->session->userdata('user')->cpc * $month->clicks) + ($this->session->userdata('user')->cpl * $month->leads) + ($this->session->userdata('user')->cpa * $month->app_installs) + ($this->session->userdata('user')->cpo * $month->ac_opened);
                    ?>
                    <span style="float: right; padding-right: 10px; font-size: medium; <?=($mtotal < 1) ? 'color:red' : 'color:green'?>">&#x20B9;<?=$mtotal?></span>
                  </div>
                  <!-- /widget-header -->
                  <div class="widget-content">
                    <div class="widget big-stats-container">
                      <div class="widget-content">
                        <div id="big_stats" class="cf">
                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpc * $month->clicks)?></span><h3>Clicks</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpl * $month->leads)?></span><h3>Leads</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpa * $month->app_installs)?></span><h3>App Installs</h3> </div>

                          <div class="stat"><span class="value">&#x20B9;<?=($this->session->userdata('user')->cpo * $month->ac_opened)?></span><h3>A/C Opened</h3> </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div> 


        <div class="row">
          <div class="span12">
                  <div class="widget">
                    <div class="widget-header"> <i class="icon-list-alt"></i>
                      <h3>Click sources</h3>
                    </div>  
                    <div class="widget-content">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr><th>No. of clicks</th><th>Source</th></tr>
                          </thead>
                          <tbody>  
                            <?php
                              foreach ($records as $arr) {
                                $data = json_decode($arr->json);
                                if(!empty($data)){
                                  echo '<tr bgcolor="#f4f4f4"><th colspan="2">'.date('d M Y',strtotime($arr->date)).'</th></tr>';
                                  
                                  foreach ($data as $val) {
                                    echo '<tr><td>'.$val->key.'</td><td>'.$val->val.'</td></tr>';
                                  }
                                }
                              }
                            ?>
                          </tbody>  
                        </table>  
                      </div> 
                    </div>
                </div>
            </div>
        </div>     

        <div class="row">
    			<div class="span12">
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

        <div class="row">
          <div class="span12">
                  <div class="widget widget-nopad">
                    <div class="widget-header"> <i class="icon-bar-chart"></i>
                      <h3>Monthly Earnings</h3>
                    </div>  
                    <div class="widget-content">
                      <div class="widget big-stats-container">
                          <div class="widget-content" id="bar1" style="padding-top:20px">
                          </div>
                      </div>      
                    </div>
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

  Highcharts.chart('bar', {
    chart: {
        type: 'column'
    },
    title: {
        text: "<?=(!isset($mfilter)) ? date('M Y') : $mfilter?>'s Statistics"
    },
    xAxis: {
        categories: <?=$dates?>,
        crosshair: true
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
    series: <?=$stats?>
  });

  Highcharts.chart('bar1', {
    chart: {
        type: 'column'
    },
    title: {
        text: "<?=(!isset($mfilter)) ? date('M Y') : $mfilter?>'s Earnings"
    },
    xAxis: {
        categories: <?=$dates?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'INR'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
    series: <?=$earnings?>
  });

});

</script>


</body>
</html>