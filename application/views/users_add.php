<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-user"></i>
						<h3><?php echo strtoupper($this->uri->segment(2))?> USERS</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
                    
                    	<?php if($this->session->flashdata('error') != ''){ ?>
                            <div class="alert">
                              <strong>ERROR!</strong> <?php echo $this->session->flashdata('error')?>
                            </div>
                        <?php } ?>

						
						<form action="<?=site_url('users/save')?>" onSubmit="return verify()" class="form-horizontal" method="post">
    
                            <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
                                <input value="<?php echo $user->id?>" type="hidden" name="id" />

                                <!--<div class="control-group">											
                                    <label class="control-label" for="username">Employee Id</label>
                                    <div class="controls">
                                    <input type="text" name="emp_id" class="span3" id="emp_id" value="<?php echo $user->emp_id?>">
                                    </div>				
                                </div>-->
                                
                                <div class="control-group">											
                                    <label class="control-label" for="username">Name <font color="red">*</font></label>
                                    <div class="controls">
                                    <input type="text" name="name" class="span3" id="name" value="<?php echo $user->name?>">
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <div class="control-group">											
                                    <label class="control-label" for="username">Username <font color="red">*</font></label>
                                    <div class="controls">
                                    <input type="text" class="span3" name="username" placeholder="xyz@choicebroking.net" id="username" <?php if($this->uri->segment(2) == 'edit') echo 'disabled'?> value="<?php echo $user->username?>">
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->

                                <div class="control-group">											
                                    <label class="control-label" for="username">Password <font color="red">*</font></label>
                                    <div class="controls">
                                    <input type="password" class="span3" name="password" id="password" value="<?php echo $user->password?>">
                                    </div> <!-- /controls -->				
                                </div> <!-- /control-group -->
                                
                                <?php if($role == 'Admin'){ ?>
                                    <div class="control-group">											
                                        <label class="control-label" for="username">Role <font color="red">*</font></label>
                                        <div class="controls">
                                        <select class="span3" name="role" id="role" onchange="roleFields(this.value)">
                                            <option value="Executive" <?php echo ($user->role == 'Executive') ? 'selected' : ''?>>Executive</option>
                                        	<option value="Manager" <?php echo ($user->role == 'Manager') ? 'selected' : ''?>>Manager</option>
                                            <option value="Influencer" <?php echo ($user->role == 'Influencer') ? 'selected' : ''?>>Influencer</option>
                                            <option value="Head" <?php echo ($user->role == 'Head') ? 'selected' : ''?>>Head of Department</option>
                                        </select>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->

                                    <div class="control-group <?=($user->role != 'Manager') ? 'hide' : ''?>" id="sourceHolder">
                                        <label class="control-label" for="username">Source <font color="red">*</font></label>
                                        <div class="controls">
                                        <input type="text" class="span3" name="source" placeholder="choicebroking" id="source" value="<?php echo $user->source?>">
                                        </div>
                                    </div>    
                                    
                                    <div class="control-group">											
                                        <label class="control-label" for="username">Reporting Manager (Only required for Executive)</label>
                                        <div class="controls">
                                        <select class="span3" name="parent_id" id="parent">
                                        	<option value="0">-- Select Reporting Manager --</option>
                                        		<optgroup label="Manager">
                                                <?php foreach($users as $val){ ?>
                                                    <option value="<?=$val->id?>"  <?php echo ($user->parent_id == $val->id) ? 'selected' : ''?>><?=$val->name?></option>
                                                 <?php } ?>   
    	                                        </optgroup>
                                        </select>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                <?php } else if($role == 'Manager') { ?>
                                    <input type="hidden" name="parent_id" value="<?=$this->session->userdata('user')->id?>" />
                                    <input type="hidden" name="role" value="Executive" />
                                <?php } ?> 

                                <div class="control-group">                                         
                                    <label class="control-label" for="username">Email Address</label>
                                    <div class="controls">
                                    <input type="email" class="span3" name="email" placeholder="xyz@choicebroking.net" id="email" value="<?php echo $user->email?>">
                                    </div> <!-- /controls -->               
                                </div> <!-- /control-group -->

                                <div class="control-group">                                         
                                    <label class="control-label" for="username">Mobile Number</label>
                                    <div class="controls">
                                    <input type="text" class="span3" maxlength="15" name="mobile" placeholder="+91 9876432105" id="mobile" value="<?php echo $user->mobile?>">
                                    </div> <!-- /controls -->               
                                </div> <!-- /control-group -->

                                <div class="control-group">                                         
                                    <label class="control-label" for="username">Address</label>
                                    <div class="controls">
                                    <textarea rows="4" class="span3" name="address" placeholder="GB Road, Thane." id="address"><?php echo $user->address?></textarea>
                                    </div> <!-- /controls -->               
                                </div> <!-- /control-group -->

                                <div id="influencer" class="<?=($user->role != 'Influencer') ? 'hide' : ''?>">
                                    <div class="control-group">                                         
                                        <label class="control-label" for="username">Channel URL</label>
                                        <div class="controls">
                                        <textarea class="span6" rows="6" name="channel_url" placeholder="https://www.youtube.com/channel/UCNJcSUSzUeFm8W9P7UUlSeQ" id="channel_url"><?php echo $user->channel_url?></textarea>
                                        </div> <!-- /controls -->               
                                    </div> <!-- /control-group -->

                                    <div class="control-group">                                         
                                        <label class="control-label" for="username">GA Code <font color="red">*</font></label>
                                        <div class="controls">
                                        <input type="text" class="span3" name="ga_code" placeholder="G-ZFSGTKKXMS" id="ga_code" value="<?php echo $user->ga_code?>">
                                        </div> <!-- /controls -->               
                                    </div> <!-- /control-group -->

                                    <div class="control-group">                                         
                                        <label class="control-label" for="username">Bank Account Details</label>
                                        <div class="controls">
                                        <textarea rows="4" class="span3" name="bank_details" placeholder="Name: Suresh Goyal&#10;A/c No : 01234560009&#10;Bank : Standard Chartered&#10;IMEI : SBIC0000415&#10;MMID : 123456789" id="bank_details"><?php echo $user->bank_details?></textarea>
                                        </div> <!-- /controls -->               
                                    </div> <!-- /control-group -->

                                    <div class="control-group">                                         
                                        <label class="control-label" for="username">Cost Per Click <font color="red">*</font></label>
                                        <div class="controls">
                                        <input type="number" class="span3" name="cpc" step=".01" placeholder="2.00" id="cpc" value="<?php echo $user->cpc?>">
                                        </div> <!-- /controls -->               
                                    </div> <!-- /control-group -->

                                    <div class="control-group">                                         
                                        <label class="control-label" for="username">Cost Per Lead <font color="red">*</font></label>
                                        <div class="controls">
                                        <input type="number" class="span3" name="cpl" step=".01" placeholder="5.00" id="cpl" value="<?php echo $user->cpl?>">
                                        </div> <!-- /controls -->               
                                    </div> <!-- /control-group -->

                                    <div class="control-group">                                         
                                        <label class="control-label" for="username">Cost Per App Install <font color="red">*</font></label>
                                        <div class="controls">
                                        <input type="number" class="span3" name="cpa" step=".01" placeholder="10.00" id="cpa" value="<?php echo $user->cpa?>">
                                        </div> <!-- /controls -->               
                                    </div> <!-- /control-group -->

                                    <div class="control-group">                                         
                                        <label class="control-label" for="username">Cost Per Account Open <font color="red">*</font></label>
                                        <div class="controls">
                                        <input type="number" class="span3" name="cpo" step=".01" placeholder="25.00" id="cpo" value="<?php echo $user->cpo?>">
                                        </div> <!-- /controls -->               
                                    </div> <!-- /control-group -->

                                </div>   
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Save</button> 
                                    <button type="button" class="btn" onclick="location.href='<?php echo site_url('users')?>'">Cancel</button>
                                </div> <!-- /form-actions -->
                                
                            </fieldset>
                            
                            <div class="clear"></div><!-- End .clear -->
                            
                        </form>
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	
	      </div> <!-- /row -->
	
	    </div>

<script type="text/javascript">
$(document).ready(function(){
	$('#name, #username, #password, #source, #ga_code, #cpa, #cpc, #cpo, #cpl').focus(function(){
		if ($(this).hasClass("needsfilled")) {
		$(this).val("");
		$(this).removeClass("needsfilled");
	   }		
	});
});
function verify(){
	if($('#name').val() == "" || $('#name').val() == 'Required!')
	{
		$('#name').addClass('needsfilled');
		$('#name').val('Required!');
		$('#error').fadeIn(1500);
		return false;			
	}
	if($('#username').val() == "" || $('#username').val() == 'Required!')
	{
		$('#username').addClass('needsfilled');
		$('#username').val('Required!');
		$('#error').fadeIn(1500);
		return false;			
	}
	if($('#password').val() == "" || $('#password').val() == 'Required!')
	{
		$('#password').addClass('needsfilled');
		$('#password').val('Required!');
		$('#error').fadeIn(1500);
		return false;			
	}
    if(!$('#sourceHolder').hasClass('hide') && ($('#source').val() == "" || $('#source').val() == 'Required!'))
    {
        $('#source').addClass('needsfilled');
        $('#source').val('Required!');
        $('#error').fadeIn(1500);
        return false;           
    }
    if(!$('#influencer').hasClass('hide') && ($('#ga_code').val() == "" || $('#ga_code').val() == 'Required!'))
    {
        $('#ga_code').addClass('needsfilled');
        $('#ga_code').val('Required!');
        $('#error').fadeIn(1500);
        return false;           
    }
    if(!$('#influencer').hasClass('hide') && ($('#cpc').val() == "" || $('#cpc').val() == 'Required!'))
    {
        $('#cpc').addClass('needsfilled');
        $('#cpc').val('Required!');
        $('#error').fadeIn(1500);
        return false;           
    }
    if(!$('#influencer').hasClass('hide') && ($('#cpl').val() == "" || $('#cpl').val() == 'Required!'))
    {
        $('#cpl').addClass('needsfilled');
        $('#cpl').val('Required!');
        $('#error').fadeIn(1500);
        return false;           
    }
    if(!$('#influencer').hasClass('hide') && ($('#cpa').val() == "" || $('#cpa').val() == 'Required!'))
    {
        $('#cpa').addClass('needsfilled');
        $('#cpa').val('Required!');
        $('#error').fadeIn(1500);
        return false;           
    }
    if(!$('#influencer').hasClass('hide') && ($('#cpo').val() == "" || $('#cpo').val() == 'Required!'))
    {
        $('#cpo').addClass('needsfilled');
        $('#cpo').val('Required!');
        $('#error').fadeIn(1500);
        return false;           
    }
}
function roleFields(val){
    if(val == 'Manager'){
        $('#sourceHolder').removeClass('hide')
    } else {
        $('#sourceHolder').addClass('hide')
    }

    if(val == 'Influencer'){
        $('#influencer').removeClass('hide')
    } else {
        $('#influencer').addClass('hide')
    }
}
</script>