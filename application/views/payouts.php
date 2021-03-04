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
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-dollar"></i>
						<h3>PAYOUTS</h3>
                        
                        <?php if($role == 'Admin' or ($role == 'Manager' and $this->session->userdata('user')->source == 'Influencer')) { ?>
	                        <button class="btn btn-info" onclick="location.href='<?php echo site_url('influencer/payout_add')?>'" style="float:right; margin:6px">Make Payout</button>
	                    <?php } ?>

                        
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
                       <th>Amount</th>
                       <th>Transaction ID</th>
                       <th>Period</th>
                       <?php if($role == 'Admin'){ ?>
	                       <th>User</th>
	                   <?php } ?>
	                   <th>Paid On</th>
                    </tr>
                </thead>
             	<!--<tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="bulk-actions align-left">
                                <a class="button" href="#" id="apply">Delete Selected</a>
                                |
                                <a class="button" href="<?=site_url('users/excel')?>" id="excel">Export To Excel</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>-->
             
                <tbody>
                    <?php $i = 1; foreach($result as $c){ ?>
                    <tr>
                        <td><input type="checkbox" class="checking" id="<?=$c->id?>" /></td>
                        <td><?=$i?></td>
                        <td><?=$c->amount?></td>
                        <td><?=$c->transaction_id?></td>
                        <td><?=$c->period?></td>
                        <?php if($role == 'Admin'){ ?>
	                        <td><?=$c->name?></td>
	                    <?php } ?>
	                    <td><?=date('d M Y',strtotime($c->created_at))?></td>
                    </tr>
                    <? $i++; } ?>
                    <?php if(count($result) == 0) {
                    	echo '<tr><td colspan="7" style="text-align:center" align="center">No Records Found!</td></tr>';
                    } ?>
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