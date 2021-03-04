<div class="container">  
        
        	<style>
            .stat h3{font-size: 16px!important}
            .stat sub{
              font-size: 12px;
            }
				  </style>

          <div align="right" style="width: 100%; height: 50px">
            <h3 style="width: 250px; float: left; text-align: left;">Total Influencers : <?=$count?></h3>
            <form action="<?=site_url('influencer/summary')?>" method="post">
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
                    <h3><?=(!isset($mfilter)) ? date('M Y') : $mfilter?>'s Stats</h3>
                  </div>
                  <!-- /widget-header -->
                  <div class="widget-content">
                    <div class="widget big-stats-container">
                      <div class="widget-content">
                        <div id="big_stats" class="cf">
                          <div class="stat"><span class="value"><?=($month->clicks) ?? 0?></span><h3>Clicks</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value"><?=($month->leads) ?? 0?></span><h3>Leads</h3> </div>
                          <!-- .stat -->
                          
                          <div class="stat"><span class="value"><?=($month->app_installs) ?? 0?></span><h3>App Installs</h3> </div>

                          <div class="stat"><span class="value"><?=($month->ac_opened) ?? 0?></span><h3>A/C Opened</h3> </div>
                        </div>
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
    </div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>    
<script type="text/javascript">
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
</script>        
