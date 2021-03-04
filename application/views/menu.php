<?php 
  $module = $this->uri->segment(1);
  $action = $this->uri->segment(2);
?>

<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        
        <?php if($role != 'Head' and $role != 'Influencer'){ ?>

          <li class="<?=selected($module, 'home')?>"><a href="<?php echo site_url('home')?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>

          <li class="<?=selected($module, 'leads')?>"><a href="<?php echo site_url('leads/index/All')?>"><i class="icon-list"></i><span>Leads</span> </a> </li>
          
  		    <?php if($role == "Manager"){ ?>
            <li class="<?=selected($module, 'dist')?>"><a href="<?php echo site_url('dist/add')?>"><i class="icon-share"></i><span>Leads Distribution</span> </a> </li>
              <!--<li class="<?=selected($module, 'message')?>"><a href="<?php echo site_url('message')?>"><i class="icon-envelope"></i><span>Public / Private Message</span> </a> </li>-->
  		    <?php } ?>

          <?php if($role == "Admin" or $role == "Manager"){ ?>  
            <li class="<?=selected($module, 'users')?>"><a href="<?php echo site_url('users')?>"><i class="icon-user"></i><span>Users</span> </a> </li>
          <?php } ?>

          <?php if($role == "Admin" or ($role == 'Manager' and $this->session->userdata('user')->source == 'Influencer')){ ?>
            <li class="dropdown <?=selected($module, 'influencer')?>"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-facetime-video"></i><span>Influencer</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?=site_url('influencer/summary')?>">Dashboard</a></li>
                <li><a href="<?=site_url('influencer/payouts')?>">Payouts</a></li>
              </ul>
            </li>
          <?php } ?>

          <li class="<?=selected($module, 'search')?>"><a href="<?php echo site_url('search')?>"><i class="icon-search"></i><span>Search</span> </a> </li>

        <?php } else if($role == 'Head') { ?>

          <li class="<?=selected($module, 'home')?>"><a href="<?php echo site_url('home')?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
          <li class="<?=selected($module, 'influencer')?>"><a href="<?php echo site_url('influencer/summary')?>"><i class="icon-facetime-video"></i><span>Influencer</span> </a> </li>

        <?php } else if($role == 'Influencer') { ?>

          <li class="<?=selected($action, 'index')?>"><a href="<?php echo site_url('influencer')?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
          <li class="<?=selected($action, 'my_payouts')?>"><a href="<?php echo site_url('influencer/my_payouts')?>"><i class="icon-dollar"></i><span>Payouts</span> </a> </li>
          
        <?php } ?>  
        
        <!--<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Drops</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="icons.html">Icons</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <li><a href="pricing.html">Pricing Plans</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="signup.html">Signup</a></li>
            <li><a href="error.html">404</a></li>
          </ul>
        </li>-->
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>