  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $picture; ?>" class="img-circle" alt="User Image" style="width:50px;height:50px">
        </div>
        <div class="pull-left info">
          <p><?php echo $full_name; ?></p>
          <!-- change to 'text-danger' for offline use -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="menu-open">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="profile.php">
            <i class="fa fa-user-circle"></i> <span>Profile</span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-bank"></i>
            <span>Manage Investments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="invest.php"><i class="fa fa-plus"></i> Make new invest</a></li>
            <li><a href="invest-history.php"><i class="fa fa-calendar-times-o"></i> Invest History</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bank"></i>
            <span>Withdrawal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="withdrawal.php"><i class="fa fa-money"></i> Withdraw</a></li>
            <li><a href="withdraw-log.php"><i class="fa fa-history"></i> History</a></li>
          </ul>
        </li>

        <li>
            <a href="message-admin.php">
              <i class="fa fa-mail-forward"></i> <span>Send message to admin</span>
            </a>
          </li>
          <li>
            <a href="apply_agent.php">
              <i class="fa fa-user-secret"></i> <span><?php if($agent_applied){ echo 'Check Agent Status'; }else{echo 'Apply for an Agent';} ?></span>
            </a>
          </li>
          <li>
            <a href="messages.php">
              <i class="fa fa-envelope"></i> <span>My Mails</span>
            </a>
          </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>