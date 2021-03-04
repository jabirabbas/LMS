<style>
@media(min-width: 761px){
	.control-set{
		width:24%;
		float:left;
		padding-right:15px;
	}
	
	.control-set:nth-child(4), .control-set:nth-child(8){
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

<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-search"></i>
						<h3>Search</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    
                    	<?php if($this->session->flashdata('error') != ''){ ?>
                            <div class="alert">
                              <strong>ERROR!</strong> <?php echo $this->session->flashdata('error')?>
                            </div>
                        <?php } ?>

						
						<form action="<?=site_url('search/find')?>" class="form-horizontal" method="post">
    
                            <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                                
                                <div class="control-set">											
                                    <label class="controlset-label" for="username">Customer Name</label>
                                    <div class="control">
                                    	<input type="text" class="span3" id="name" name="name" value="<?=$criteria->name?>" />
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="control-set">											
                                    <label class="controlset-label" for="username">Customer Email</label>
                                    <div class="control">
                                    	<input type="email" class="span3" id="email" name="email" value="<?=$criteria->email?>" />
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="control-set">											
                                    <label class="controlset-label" for="username">Customer Mobile Number</label>
                                    <div class="control">
                                    	<input type="text" class="span3" id="mobile" name="mobile" value="<?=$criteria->mobile?>" />
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <?php if($role != 'Executive'){ ?>
                                    <div class="control-set">											
                                        <label class="controlset-label" for="username">Assigned To</label>
                                        <div class="control">
                                        	<select class="span3" name="user_id" id="user_id">
                                        	<option value="">-- Select User --</option>
                                        	   <optgroup label="Executive">
                                                <?php foreach($users as $val){ ?>
                                                    <option <?=($criteria->user_id == $val->id) ? 'selected' : ''?> value="<?=$val->id?>"><?=$val->name?></option>
                                                 <?php } ?>   
    	                                        </optgroup>
                                        </select>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                <?php } else { ?>
                                    <input type="hidden" name="user_id" value="<?=$this->session->userdata('user')->id?>" />
                                <?php } ?>    

                                <div class="control-set">                                           
                                    <label class="controlset-label" for="username">Status</label>
                                    <div class="control">
                                        <select class="span3" name="status" id="status">
                                            <option value="">-- Select Status --</option>
                                            <option <?=($criteria->status == 'Pending') ? 'selected' : ''?> value="Pending">Pending</option>
                                            <option <?=($criteria->status == 'Assigned') ? 'selected' : ''?> value="Assigned">Assigned</option>
                                            <option <?=($criteria->status == 'In Process') ? 'selected' : ''?> value="In Process">In Process </option>
                                            <option <?=($criteria->status == 'KYC') ? 'selected' : ''?> value="KYC">KYC</option>
                                            <option <?=($criteria->status == 'AC Opened') ? 'selected' : ''?> value="AC Opened">A/c Opened</option>
                                            <option <?=($criteria->status == 'Supervision') ? 'selected' : ''?> value="Supervision">Supervision</option>
                                            <option <?=($criteria->status == 'Failed') ? 'selected' : ''?> value="Failed">Failed</option> 
                                        </select>
                                    </div> <!-- /controls -->               
                                </div> <!-- /control-group -->

                                <?php if($role == 'Admin'){ ?>
                                    <div class="control-set">                                           
                                        <label class="controlset-label" for="username">Source</label>
                                        <div class="control">
                                            <select class="span3" name="source" id="source">
                                            <option value="">-- Select Source --</option>
                                            <?php foreach($source as $u){ ?>
                                                <option <?=($u->source == $criteria->source) ? 'selected' : ''?> value="<?=$u->source?>"><?=$u->source?></option>
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
                                        <input type="text" class="span3 datepicker" readonly="" id="fromdate" name="fromdate" value="<?=$criteria->fromdate?>" />
                                    </div>               
                                </div>
                                
                                <div class="control-set">                                           
                                    <label class="controlset-label" for="username">To Date</label>
                                    <div class="control">
                                        <input type="text" class="span3 datepicker" readonly="" id="todate" name="todate" value="<?=$criteria->todate?>" />
                                    </div>               
                                </div>
                                
                                
                                <div class="form-actions" style="margin-top:20px">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <button type="button" class="btn" onclick="location.href='<?php echo site_url('search')?>'">Reset</button>
                                </div> <!-- /form-actions -->
                                
                            </fieldset>
                            
                            <div class="clear"></div><!-- End .clear -->
                            
                        </form>
                        
                        <form method="post" action="<?php echo site_url('search/excel')?>" id="excelForm">
                            <input type="hidden" name="name" value="<?=$criteria->name?>">
                            <input type="hidden" name="mobile" value="<?=$criteria->mobile?>">
                            <input type="hidden" name="email" value="<?=$criteria->email?>">
                            <input type="hidden" name="status" value="<?=$criteria->status?>">
                            <input type="hidden" name="source" value="<?=$criteria->source?>">
                            <input type="hidden" name="user_id" value="<?=$criteria->user_id?>">
                            <input type="hidden" name="fromdate" value="<?=$criteria->fromdate?>">
                            <input type="hidden" name="todate" value="<?=$criteria->todate?>">
                        </form>
                        
                        
                        
            <table class="table">
                
                <?php if(!empty($leads)){ ?>
                
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
                                        <option value="Supervision">Supervision</option>
                                        <option value="Failed">Failed</option>  
                                    </select>
                                    <?php if($role == 'Admin') { ?><a class="button" href="#" id="apply">Delete Selected</a> &nbsp;<?php } ?>
                                    <?php if($role == 'Admin' or $role == 'Manager') { ?><a class="button" href="javascript:$('#excelForm').submit()" id="excel">Export To Excel</a><?php } ?>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                <?php } ?>
             
                <tbody>
                    <?php $i = 1; foreach($leads as $c){ ?>
                    <tr data-seen="<?=$c->seen?>" <?php echo ($c->seen == 0 and $role == 'Executive') ? 'style="background-color:paleturquoise"' : ''?>>
                        <td><input type="checkbox" class="checking" id="<?=$c->id?>" /></td>
                        <td><?=$i?></td>
                        <td><?=$c->name?></td>
                        <td><?=$c->email?></td>
                        <td><?=$c->mobile?></td>
                        <?php if($role == 'Admin'){ ?>
                            <td><?=$c->source?></td>
                        <?php } ?>
                        <td><?=nl2br($c->notes)?></td>
                        <td><?=$c->status?></td>
                        <td><?=($c->created_on != "0000-00-00 00:00:00" and $c->created_on != "") ? date('d M Y H:i', strtotime($c->created_on)) : ""?></td>
                        <td><?=$c->modified_by?><?=($c->modified_on != "0000-00-00 00:00:00" and $c->modified_on != "") ? date('d M Y H:i', strtotime($c->modified_on)) : ""?></td>
                        <?php if($role == "Manager" or $role == 'Admin'){ ?>
                            <td><?=($c->assigned) ? $c->assigned : 'N/A'?></td>
                        <?php } ?>
                        <td>
                             <a href="<?=site_url('leads/edit/'.$c->id)?>" style="color:green" title="Edit"><i class="icon-pencil"></i> Edit</a>
                             <?php if($role == 'Admin'){ ?>
                             | 
                             <a href="javascript:void(0)" style="color:red" onclick="conf('<?=site_url('leads/delete/'.$c->id)?>')" title="Delete"><i class="icon-trash"></i> Delete</a> 
                             <?php } ?>
                        </td>
                    </tr>
                    <? $i++; } ?>

                </tbody>
                
                <?php } else { ?>
                	
                    <tr><td align="center"><h3>No Results to display</h3></td></tr>
                 
                 <?php } ?>
                
            </table> 	
	      		
                
						
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
        location.href = '<?php echo site_url('leads/deleteMultiple')?>/'+ids;   
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
        location.href = '<?php echo site_url('leads/updateBulkStatus')?>/'+status+'/'+ids;  
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
</script>
