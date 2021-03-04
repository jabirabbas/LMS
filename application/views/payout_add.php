<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-dollar"></i>
						<h3>Make Payout</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    
                    	<?php if($this->session->flashdata('error') != ''){ ?>
                            <div class="alert">
                              <strong>ERROR!</strong> <?php echo $this->session->flashdata('error')?>
                            </div>
                        <?php } ?>

						
						<form action="<?=site_url('influencer/save')?>" onSubmit="return verify()" class="form-horizontal" method="post">
    
                            <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

                                <div class="control-group">                                         
                                    <label class="control-label" for="username">Influencer</label>
                                    <div class="controls">
                                    <select class="span3" name="user_id" id="user">
                                        <option value="">-- Select Influencer --</option>
                                        <?php foreach($users as $val){ ?>
                                            <option value="<?=$val->id?>"><?=$val->name?></option>
                                         <?php } ?>
                                    </select>
                                    </div>
                                </div>


                                <div class="control-group">                                         
                                    <label class="control-label" for="username">Period</label>
                                    <div class="controls">
                                    <select class="span3" name="period" id="period">
                                        <option value="">-- Select Payment Period --</option>
                                        <?php foreach($period as $val){ ?>
                                            <option value="<?=$val?>"><?=$val?></option>
                                         <?php } ?>
                                    </select>
                                    </div> <!-- /controls -->               
                                </div>

                                <div class="control-group">											
                                    <label class="control-label" for="username">Amount <font color="red">*</font></label>
                                    <div class="controls">
                                    <input type="number" step=".01" name="amount" class="span3" id="amount" />
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="control-group">											
                                    <label class="control-label" for="username">Transaction ID <font color="red">*</font></label>
                                    <div class="controls">
                                    <input type="text" class="span3" name="transaction_id" placeholder="AXRTVTR876MBNGUT" id="transaction_id" />
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Save</button> 
                                    <button type="button" class="btn" onclick="location.href='<?php echo site_url('influencer/payouts')?>'">Cancel</button>
                                </div> <!-- /form-actions -->
                                
                            </fieldset>
                            
                            <div class="clear"></div><!-- End .clear -->
                            
                        </form>
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	
	      </div> <!-- /row -->


          <div class="row">
          <div class="span12">
                  <div class="widget widget-nopad">
                    <div class="widget-header"> <i class="icon-list-alt"></i>
                      <h3>Click sources</h3>
                    </div>  
                    <div class="widget-content">
                      <div class="widget big-stats-container">
                          <div class="widget-content">
                            <div class="table-responsive" id="sourceTable"></div>  
                          </div>
                      </div>      
                    </div>
                </div>
            </div>
        </div> 


	
	    </div>

<script type="text/javascript">
$(document).ready(function(){
	$('#amount, #transaction_id').focus(function(){
		if ($(this).hasClass("needsfilled")) {
		$(this).val("");
		$(this).removeClass("needsfilled");
	   }		
	});
});
function verify(){
	if($('#amount').val() == "" || $('#amount').val() == 'Required!')
	{
		$('#amount').addClass('needsfilled');
		$('#amount').val('Required!');
		$('#error').fadeIn(1500);
		return false;			
	}
	if($('#transaction_id').val() == "" || $('#transaction_id').val() == 'Required!')
	{
		$('#transaction_id').addClass('needsfilled');
		$('#transaction_id').val('Required!');
		$('#error').fadeIn(1500);
		return false;			
	}
}

$("#user").change(function(){
    var val = $(this).val();
    $.ajax({
        url: '<?=site_url('influencer/get_period')?>/'+val,
        success: function(response){
            $('#period').html(response);
        }
    })
})

$("#period").change(function(){
    var val = $(this).val();
    var user_id = $('#user').val();
    $.ajax({
        url: '<?=site_url('influencer/get_amount')?>/'+user_id+"/"+val,
        success: function(response){
            var response = response.split('~');
            $('#amount').val(response[0]);
            $('#sourceTable').html(response[1]);
        }
    })
})

</script>