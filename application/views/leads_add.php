<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-list"></i>
						<h3><?php echo strtoupper($this->uri->segment(2))?> LEAD</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    
                    	<?php if($this->session->flashdata('error') != ''){ ?>
                            <div class="alert">
                              <strong>ERROR!</strong> <?php echo $this->session->flashdata('error')?>
                            </div>
                        <?php } ?>
						
                        <?php
							if($this->nativesession->get('lead') != ''){
								$lead = $this->nativesession->get('lead');
							}
						?>
						
						<form action="<?=site_url('leads/save')?>" class="form-horizontal" enctype="multipart/form-data" method="post">
                        
                        	
                              
                                  <div class="span5">
                                    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                                        <input value="<?php echo $lead->id?>" type="hidden" name="id" />
        
                                        <div class="control-group">											
                                            <label class="control-label" for="username">Customer Name</label>
                                            <div class="controls">
                                                <input type="text" name="name" class="span3" id="name" value="<?php echo $lead->name?>">
                                            </div> <!-- /controls -->				
                                        </div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
                                            <label class="control-label" for="username">Email Address</label>
                                            <div class="controls">
                                                <input type="text" name="email" class="span3" id="email" value="<?php echo $lead->email?>">
                                            </div> <!-- /controls -->				
                                        </div> <!-- /control-group -->
                                        
                                        <div class="control-group">											
                                            <label class="control-label" for="username">Mobile Number</label>
                                            <div class="controls">
                                                <input type="text" name="mobile" class="span3" id="mobile" value="<?php echo $lead->mobile?>">
                                            </div> <!-- /controls -->				
                                        </div> <!-- /control-group -->

                                        <div class="control-group">											
                                            <label class="control-label" for="username">Status</label>
                                            <div class="controls">
                                            	<select name="status" class="span3" id="status">
                                            		<option <?=($lead->status == 'Pending') ? 'selected' : ''?> value="Pending">Pending</option>
                                            		<option <?=($lead->status == 'Assigned') ? 'selected' : ''?> value="Assigned">Assigned</option>
                                            		<option <?=($lead->status == 'In Process') ? 'selected' : ''?> value="In Process">In Process </option>
                                            		<option <?=($lead->status == 'KYC') ? 'selected' : ''?> value="KYC">KYC</option>
                                            		<option <?=($lead->status == 'AC Opened') ? 'selected' : ''?> value="AC Opened">A/c Opened</option>
                                            		<option <?=($lead->status == 'Failed') ? 'selected' : ''?> value="Failed">Failed</option>	
                                            	</select>	
                                            </div> <!-- /controls -->				
                                        </div> <!-- /control-group -->

                                        <div id="kyc" <?=($lead->status != 'KYC') ? 'style="display: none"' : ''?>>
                                            <div class="control-group">                                         
                                                <label class="control-label" for="username">Proof of Identity</label>
                                                <div class="controls">
                                                    <?php 
                                                    $lpoi = explode(',',$lead->poi);
                                                    foreach($poi as $i): ?>
                                                        <span class="span2">
                                                            <input type="checkbox" <?=(in_array($i->name,$lpoi)) ? 'checked' : ''?> name="poi[]" value="<?=$i->name?>"> <?=$i->name?>
                                                        </span>
                                                    <?php endforeach; ?>   
                                                </div> <!-- /controls -->               
                                            </div> <!-- /control-group -->

                                            <div class="control-group">                                         
                                                <label class="control-label" for="username">Proof of Address</label>
                                                <div class="controls">
                                                    <?php
                                                     $lpoa = explode(',',$lead->poa);
                                                     foreach($poa as $i): ?>
                                                        <span class="span2">
                                                            <input type="checkbox" <?=(in_array($i->name,$lpoa)) ? 'checked' : ''?> name="poa[]" value="<?=$i->name?>"> <?=$i->name?>
                                                        </span>
                                                    <?php endforeach; ?>   
                                                </div> <!-- /controls -->               
                                            </div> <!-- /control-group -->
                                        </div> 

                                        <div id="ac" <?=($lead->status != 'AC Opened') ? 'style="display: none"' : ''?>>
                                            <div class="control-group">                                         
                                                <label class="control-label" for="username">Customer ID</label>
                                                <div class="controls">
                                                    <input type="text" name="cust_id" class="span3" id="cust_id" value="<?php echo $lead->cust_id?>">
                                                </div> <!-- /controls -->               
                                            </div> <!-- /control-group -->
                                        </div>       

                                        <?php if($role == 'Executive'){ ?>
                                            <div class="control-group">                                         
                                                <label class="control-label" for="username">Comments (if any)</label>
                                                <div class="controls">
                                                <textarea name="notes" class="span6" id="notes" rows="5"><?php echo $lead->notes?></textarea>
                                                </div> <!-- /controls -->               
                                            </div>
                                        <?php } ?>
                                        
                                    </fieldset>
                               
                               <!-- <div id="uf" class="tab-pane fade">
                               <div class="span12">
                                <fieldset>
                                    <div class="control-group">											
                                        <label class="control-label" for="username">Upload Files</label>
                                        <div class="controls">
                                        	<input type="file" multiple name="files[]" class="span3" id="files" />
                                            <br/><br/>
                                            <ul>
                                            	<?php foreach($files as $f) : ?>
                                                	<li><a href="<?=base_url('files/'.$f->file_name)?>" target="_blank"><?=$f->file_name?></a></li>	
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>				
                                    </div>
                                    <div class="control-group">											
                                        <label class="control-label" for="username">Notes</label>
                                        <div class="controls">
                                            <textarea rows="20" name="notes" class="span9" id="notes"><?php echo $lead->notes?></textarea>
                                        </div>
                                    </div> 
                                </fieldset>
                                </div>
                               </div> -->
                               
                                <div class="form-actions" align="right">
                                    <button type="button" class="btn" onclick="location.href='<?php echo site_url('leads')?>'">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>                                     
                                </div> <!-- /form-actions -->
                                
                            
                            <div class="clear"></div><!-- End .clear -->
                            
                        </form>
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	
	      </div> <!-- /row -->
	
	    </div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#status').change(function(){
            if($(this).val() == 'KYC'){
                $('#kyc').show()
            } else {
                $('#kyc').hide()
            }

            if($(this).val() == 'AC Opened'){
                $('#ac').show()
            } else {
                $('#ac').hide()
            }

        })

        $('#cust_id').keydown(function (e) {
           var k = e.keyCode || e.which;
            var ok = k >= 65 && k <= 90 || // A-Z
                k >= 96 && k <= 105 || // a-z
                k >= 35 && k <= 40 || // arrows
                k == 9 || //tab
                k == 46 || //del
                k == 8 || // backspaces
                (!e.shiftKey && k >= 48 && k <= 57); // only 0-9 (ignore SHIFT options)

            if(!ok || (e.ctrlKey && e.altKey)){
                e.preventDefault();
            }  
        });
    })
    
</script>        