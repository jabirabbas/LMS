<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-pencil"></i>
						<h3>CHANGE PASSWORD</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    
                    	<?php if($this->session->flashdata('message') != ''){ ?>
                            <div class="alert alert-success">
                              <strong>SUCCESS!</strong> <?php echo $this->session->flashdata('message')?>
                            </div>
                        <?php } ?>
                        
                        <?php if($this->session->flashdata('error') != ''){ ?>
                            <div class="alert">
                              <strong>ERROR!</strong> <?php echo $this->session->flashdata('error')?>
                            </div>
                        <?php } ?>

						
						<form action="<?=site_url('profile/save')?>" onSubmit="return verify()" id="profileForm" class="form-horizontal" method="post">
    
                            <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                                
                                <div class="control-group">											
                                    <label class="control-label" for="username">Old Password</label>
                                    <div class="controls">
                                    <input type="password" name="oldpassword" class="span3" id="oldpassword">
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="control-group">											
                                    <label class="control-label" for="username">New Password</label>
                                    <div class="controls">
                                    <input type="password" name="newpassword" class="span3" id="newpassword">
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="control-group">											
                                    <label class="control-label" for="username">Confirm Password</label>
                                    <div class="controls">
                                    <input type="password" name="cpassword" class="span3" id="cpassword">
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Save</button> 
                                    <button type="button" class="btn" onclick="location.href='<?php echo site_url('home')?>'">Cancel</button>
                                </div> <!-- /form-actions -->
                                
                            </fieldset>
                            
                            <div class="clear"></div><!-- End .clear -->
                            
                        </form>
                        
                        
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	
	      </div> <!-- /row -->
	
	    </div>

<script type="text/javascript" src="<?php echo base_url('resources/js/validationProfile.js')?>"></script>