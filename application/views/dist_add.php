<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-share"></i>
						<h3>Assign Leads</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    
                    	<?php if($this->session->flashdata('error') != ''){ ?>
                            <div class="alert">
                              <strong>ERROR!</strong> <?php echo $this->session->flashdata('error')?>
                            </div>
                        <?php } ?>
                        
                        <?php if($this->session->flashdata('message') != ''){ ?>
                            <div class="alert alert-success">
                              <strong>Success!</strong> <?php echo $this->session->flashdata('message')?>
                            </div>
                        <?php } ?>
						
						<form action="<?=site_url('dist/save')?>" class="form-horizontal" onsubmit="return validate()" method="post">
                        	<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                               	
                                <div class="control-group">											
                                    <label class="control-label" for="username">Select User</label>
                                    <div class="controls">
                                    <select class="span3" required name="user_id" id="user_id">
                                    	<option value="">-- Select User --</option>
                                		<optgroup label="Executive">
                                        <?php foreach($users as $val){ ?>
                                            <option value="<?=$val->id?>"><?=$val->name?></option>
                                         <?php } ?>   
                                        </optgroup>
                                    </select>
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                        
                                <div class="control-group">											
                                    <label class="control-label" for="username" required>Select Leads</label>
                                    <div class="controls">
                                    	<select multiple="multiple" class="span5" style="height:200px" id="leads" name="lead_id[]">
                                        	<?php foreach($leads as $lead){ ?>
                                            	<option <?=($lead->user_id != "") ? 'selected' : ''?> value="<?=$lead->id?>"><?=$lead->name.' - ('.$lead->mobile.')'?></option>
                                            <?php } ?>   
                                        </select>
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="form-actions" align="left">
                                    <button type="submit" class="btn btn-primary">SAVE</button>                                     
                                </div> <!-- /form-actions -->
                            </fieldset>
                        </div>
                               
                    </div>       
                    <div class="clear"></div><!-- End .clear -->
                            
                        </form>
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	
	      </div> <!-- /row -->
	
	    </div>
<script type="text/javascript">
	function validate(){
		if($("#leads option:selected").length < 1){
			$("#leads").css('border','1px solid red');
			return false;
		} else {
			return true;	
		}
	}
</script>
