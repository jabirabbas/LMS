<?php
	$param = $this->uri->segment(3);
	$page = $this->uri->segment(4);
?>

<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-list"></i>
						<h3>Leads - <?=$total_rows?></h3>
						<form action="<?=site_url('leads/setpage')?>" method="post" style="margin-top:-40px">
	                        <select name="limit" onchange="this.form.submit()" style="width:80px; float: right; margin:6px">
	                        	<option <?=($this->session->userdata('limit') == 10) ? 'selected' : ''?> value="10">10</option>
	                        	<option <?=($this->session->userdata('limit') == 25) ? 'selected' : ''?> value="25">25</option>
	                        	<option <?=($this->session->userdata('limit') == 50) ? 'selected' : ''?> value="50">50</option>
	                        	<option <?=($this->session->userdata('limit') == 100) ? 'selected' : ''?> value="100">100</option>
	                        	<option <?=($this->session->userdata('limit') == 250) ? 'selected' : ''?> value="250">250</option>
	                        	<option <?=($this->session->userdata('limit') == 500) ? 'selected' : ''?> value="500">500</option>
	                        	<option <?=($this->session->userdata('limit') == 1000) ? 'selected' : ''?> value="1000">1000</option>
	                        </select>	
	                    </form>    

                        <?php /*if($role == "Manager"){ ?>
	                        <button class="btn btn-info" onclick="location.href='<?php echo site_url('leads/add')?>'" style="float:right; margin:6px">Add Leads</button>
	                    <?php }*/ ?>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
					<div class="table-responsive"> 
                    
                    	<?php if($this->session->flashdata('message') != ''){ ?>
                            <div class="alert alert-success">
                              <strong>Success!</strong> <?php echo $this->session->flashdata('message')?>
                            </div>
                        <?php } ?>
                    	         
  						<table class="table">
                
			                <thead>
			                    <tr>
			                       <th><input class="check-all" type="checkbox" /></th>
			                       <th>Sr.No</th>
			                       <th>Name</th>
			                       <th>Email</th>
			                       <th>Mobile</th>
			                       <?php if($role == 'Admin'){ ?>
			                       	<th>Source</th>
			                       <?php } ?>
			                       <th>Comment</th>	
			                       <th>Status</th>
			                       <th>Created On</th>
			                       <th>Last Modified</th>
			                       <?php if($role == "Manager" or $role == 'Admin'){ ?>
			                       		<th>Assigned</th>
			                       <?php } ?>
			                       <th width="120">Action</th>
			                    </tr>
			                </thead>
			                <?php if(count($leads) > 0){ ?>
				             	<tfoot>
				                    <tr>
				                        <td colspan="12">
				                            <div class="bulk-actions align-left">
				                            	<select name="status" onChange="updateBulkStatus(this.value)" class="span3" style="margin-right:5px" id="status">
			                                		<option value="">--Select Status--</option>
			                                		<option value="In Process">In Process </option>
			                                		<option value="KYC">KYC</option>
			                                		<option value="AC Opened">AC Opened</option>
			                                		<option value="Failed">Failed</option>	
			                                	</select>
				                                <?php if($role == 'Admin') { ?><a class="button" href="#" id="apply">Delete Selected</a> &nbsp;<?php } ?>
				                                <?php if($role == 'Admin' or $role == 'Manager') { ?><a class="button" href="<?=site_url('leads/excel')?>" id="excel">Export To Excel</a><?php } ?>
				                            </div>
				                        </td>
				                    </tr>
				                </tfoot>
				            <?php } ?>
			             
			                <tbody>
			                    <?php 
			                    	$i = ($this->uri->segment(4)) ? $this->uri->segment(4)+1 : 1; 
			                    	foreach($leads as $c){ 
									
									if(isset($c->callback) and $c->callback != "0000-00-00 00:00:00" and $c->callback != ""){
										$title = "Callback - ".date('d M Y H:i', strtotime($c->callback));	
									} else {
										$title = "Callback - No Callback";	
									}
									
								?>
			                    <tr data-seen="<?=$c->seen?>" <?php echo ($c->seen == 0 and $role == 'Executive') ? 'style="background-color:paleturquoise"' : ''?>>
			                        <td><input type="checkbox" class="checking" id="<?=$c->id?>" /></td>
			                        <td><?=$i?></td>
			                        <!--<td><a href="#" data-toggle="popover" data-trigger="click" title="<?=$title?>" data-content="<?=nl2br($c->notes)?>"><?=$c->firstname.' '.$c->middlename.' '.$c->lastname?></a></td>-->
			                        <td><?=$c->name?></td>
			                        <td><?=$c->email?></td>
			                        <td><?=$c->mobile?></td>
			                        <?php if($role == 'Admin'){ ?>
			                       		<td><?=$c->source?></td>
			                       	<?php } ?>
			                       	<td><?=nl2br($c->notes)?></td>
			                        <td><?=$c->status?></td>
			                        <td><?=($c->created_on != "0000-00-00 00:00:00" and $c->created_on != "") ? date('d M Y H:i', strtotime($c->created_on)) : ""?></td>
			                        <td>
			                        	<?=isset($c->modified_by) ? $c->modified_by : ''?>
			                        	<?=($c->modified_on != "0000-00-00 00:00:00" and $c->modified_on != "") ? date('d M Y H:i', strtotime($c->modified_on)) : ""?>
			                        </td>
			                        <?php if($role == "Manager" or $role == 'Admin'){ ?>
				                        <td><?=($c->assigned) ? $c->assigned : 'N/A'?></td>
				                    <?php } ?>
			                        <td>
			                             <a href="<?=site_url('leads/edit/'.$c->id)?>" style="color:green" title="Edit"><i class="icon-pencil"></i> Edit</a>
			                             <?php if($role == 'Admin'){ ?>
			                             | 
			                             <a href="javascript:void(0)" style="color:red" onclick="conf('<?=site_url("leads/delete/$param/$page/?id=$c->id")?>')" title="Delete"><i class="icon-trash"></i> Delete</a> 
			                             <?php } ?>
			                        </td>
			                    </tr>
			                    <? $i++; } ?>

			                    <?php 
			                    	if(count($leads) == 0){ 
			                    		echo '<tr><td style="text-align:center" align="center" colspan="10">No Leads Found</td></tr>';
			                    	}
			                    ?>

			                </tbody>
			                
			            </table>
			            <p align="center"><?php echo $links; ?></p>
			          </div>
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	
	      </div> <!-- /row -->
	
	    </div>
        
<script type="text/javascript">
$(function(){
	$('.check-all').click(function(){
		prop = $(this).prop('checked');
		$('.checking').prop('checked', prop);
	});
});

$("#apply").click(function(){
	var ids = [];					   
	$('.checking:checked').each(function(){
		ids.push($(this).attr('id'));							 
	});
	ids = ids.join();
	
	var c = confirm('Are you sure you want to delete selected leads?');
	if(c == true){
		location.href = '<?php echo site_url("leads/deleteMultiple/$param/$page/?id=")?>'+ids;	
	} else {
		return false;	
	}
});

function updateBulkStatus(status){
	if(status == "") return false;

	var ids = [];					   
	$('.checking:checked').each(function(){
		ids.push($(this).attr('id'));							 
	});
	ids = ids.join();

	if(ids.length == 0){
		alert('Please select leads to update bulk status');
		return false;
	}
	
	var c = confirm('Are you sure you want to update selected leads?');
	if(c == true){
		location.href = '<?php echo site_url("leads/updateBulkStatus/$param/$page/?status=")?>'+status+'&id='+ids;	
	} else {
		return false;	
	}
}

	function conf(url){
		var c = confirm('Are you sure you want to delete this Lead?');
		if(c == true){
			location.href = url;	
		} else {
			return false;	
		}
	}
	
setInterval(function(){window.location.reload()}, 60000);	
</script>