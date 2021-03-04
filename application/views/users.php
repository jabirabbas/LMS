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
<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">

	      		<div class="widget widget-nopad" id="filterWidget" style="<?=(!isset($criteria) or empty(array_filter($criteria))) ? 'display:none' : ''?>">
	            <div class="widget-header"> <i class="icon-list-alt"></i>
	              <h3>Filter Users</h3>
	            </div>
	            <!-- /widget-header -->
	            <div class="widget-content">
                	<form id="filterForm" action="<?=site_url('users/index')?>" style="margin:0" class="form-horizontal" method="post">

                        <fieldset style="padding:15px"> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                            
                            <?php if($role == 'Admin'){ ?>
                                <div class="control-set">                                           
                                    <label class="controlset-label" for="username">Role</label>
                                    <div class="control">
                                        <select class="span3" name="role" id="Role">
                                        <option value="">-- Select Role --</option>
                                        <option <?=('Head' == $criteria['role']) ? 'selected' : ''?> value="Head">Head of Department</option>
                                        <option <?=('Manager' == $criteria['role']) ? 'selected' : ''?> value="Manager">Manager</option>
                                        <option <?=('Executive' == $criteria['role']) ? 'selected' : ''?> value="Ecxecutive">Executive</option>
                                        <option <?=('Influencer' == $criteria['role']) ? 'selected' : ''?> value="Influencer">Influencer</option>
                                    </select>
                                    </div> <!-- /controls -->               
                                </div> <!-- /control-group -->
                            <?php } ?>
                            
                            <div class="control-set">											
                                <label class="controlset-label" for="username">Name</label>
                                <div class="control">
                                	<input type="text" class="span3" id="name" name="name" value="<?=$criteria['name']?>" />
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                            
                            <div class="form-actions" style="margin-top:20px; margin-bottom: 0!important">
                            	<button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" class="btn" onclick="location.href='<?php echo site_url('users')?>'">Reset</button>
                            </div> <!-- /form-actions -->
                        </fieldset>
                    </form>
	            </div>
	        </div>  
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-user"></i>
						<h3>USERS</h3>
                        
                        <button class="btn btn-info" onclick="location.href='<?php echo site_url('users/add')?>'" style="float:right; margin:6px">Add User</button>
                        <button class="btn btn-default" onclick="$('#filterWidget').slideToggle('medium');" style="float:right; margin:6px">Filter</button>

                        
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
                       <th>Username</th>
                       <th>Role</th>
                       <?php if($role == 'Admin'){ ?>
	                       <th>Reporting Manager</th>
	                       <th>Source</th>
	                   <?php } ?>
	                   <th>Created On</th>
                       <th>Action</th>
                    </tr>
                </thead>
             	<tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="bulk-actions align-left">
                                <a class="button" href="#" id="apply">Delete Selected</a>
                                |
                                <a class="button" href="<?=site_url('users/excel')?>" id="excel">Export To Excel</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
             
                <tbody>
                    <?php $i = 1; foreach($users as $c){ ?>
                    <tr>
                        <td><input type="checkbox" class="checking" id="<?=$c->id?>" /></td>
                        <td><?=$i?></td>
                        <td><?=$c->name?></td>
                        <td><?=$c->username?></td>
                        <td><?=$c->role?></td>
                        <?php if($role == 'Admin'){ ?>
	                        <td><?=($c->reporting_manager != "") ? $c->reporting_manager : 'N/A'?></td>
	                        <td><?=($c->role == 'Manager') ? $c->source : 'N/A'?></td>
	                    <?php } ?>
	                    <td><?=date('d M Y',strtotime($c->created_on))?></td>
                        <td>
                        	<?php if($c->role == 'Influencer'){ ?>
                        		<a href="<?=site_url('influencer/view/'.$c->id)?>" title="View"><i class="icon-eye-open"></i> View</a> | 
                        	<?php } ?>	
                             <a href="<?=site_url('users/edit/'.$c->id)?>" title="Edit"><i class="icon-pencil"></i> Edit</a> | 
                             <a href="javascript:void(0)" onclick="conf('<?=site_url('users/delete/'.$c->id)?>')" title="Delete"><i class="icon-trash"></i> Delete</a> 
                        </td>
                    </tr>
                    <? $i++; } ?>
                </tbody>
                
            </table>
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
	
	var c = confirm('Are you sure you want to delete selected users?');
	if(c == true){
		location.href = '<?php echo site_url('users/deleteMultiple')?>/'+ids;	
	} else {
		return false;	
	}
});

	function conf(url){
		var c = confirm('Are you sure you want to delete this user?');
		if(c == true){
			location.href = url;	
		} else {
			return false;	
		}
	}
</script>