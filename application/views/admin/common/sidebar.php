
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url('assets/')?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
			<?php   $segment1=$this->uri->segment(1);
							$segment2=$this->uri->segment(2);
							$segment3=$this->uri->segment(3);
							
							if($segment2=='user'){
									$usermenu=" active menu-open";
							}else{
								$usermenu='';
							}
							?>
			
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree" style="font-weight: bold;font-family: cursive;">
        <li class="header">MAIN NAVIGATION</li>
         <li><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        
			  
         
        <li class="treeview <?=$usermenu?>">
          <a href="#">
            <i class="fa fa-users"></i> <span>Manage Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($segment3=='userList'){ echo "active"; } ?>" ><a href="<?=base_url('admin/user/userList')?>"><i class="fa fa-circle-o"></i>User List</a></li> 
          </ul>
        </li>
         
       <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>