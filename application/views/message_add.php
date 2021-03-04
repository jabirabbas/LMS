<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-share"></i>
						<h3>Public / Private Message</h3>
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
						
						<form action="<?=site_url('message/save')?>" class="form-horizontal" method="post">
                        	<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                               	
                                <div class="control-group">											
                                    <label class="control-label" for="username">Select User</label>
                                    <div class="controls">
                                    <select class="span3" name="user_id" id="user_id">
                                    	<option value="">-- Select User --</option>
                                    	<?php foreach($users as $key=>$u){ ?>
                                        	<optgroup label="<?=$key?>">
                                            <?php foreach($u as $val){ ?>
                                                <option value="<?=$val['id']?>"  <?php echo ($user->parent_id == $val['id']) ? 'selected' : ''?>><?=$val['name']?></option>
                                             <?php } ?>   
	                                        </optgroup>
                                         <?php } ?>
                                    </select>
                                    <p> (Leave blank in case of public message)</p>
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
                                            <label class="control-label" for="username" required>Type your Message</label>
                                            <div class="controls">
                                            	<textarea class="span4" rows="5" name="message" required></textarea>
                                            </div> <!-- /controls -->				
                                        </div> <!-- /control-group -->
                                        
                                        <div class="form-actions" align="right">
                                            <button type="submit" class="btn btn-primary">Send</button>                                     
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
