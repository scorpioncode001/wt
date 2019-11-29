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
              <i class="fa fa-cloud"></i>
              <span>Investments</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="./invest-history.php"><i class="fa fa-plus"></i>Re Assign Wallet</a></li>
              <li><a href="./accept-inv-pay.php"><i class="fa fa-check"></i> Confirm Wallet Pay</a></li>
              <li><a href="./invest-log.php"><i class="fa fa-history"></i> History</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bank"></i>
              <span>Withdrawals</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="./withdraw-history.php"><i class="fa fa-check"></i> Confirm Withdrawal</a></li>
              <li><a href="./withdraw-log.php"><i class="fa fa-history"></i> History</a></li>
            </ul>
          </li>
          <li>
            <a href="./manage-users.php">
              <i class="fa fa-users"></i> <span>Manage Users</span>
            </a>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-sticky-note"></i>
              <span>Agents</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="./agent-pay.php"><i class="fa fa-bank"></i> Payment Requests</a></li>
              <li><a href="./agent-pay-hostory.php"><i class="fa fa-history"></i> Payment History</a></li>
              <li><a href="./manage-agents.php"><i class="fa fa-adjust"></i> Manage Agents</a></li>
            </ul>
          </li>

          <li>
              <a href="./messages.php">
                <i class="fa fa-envelope-open-o"></i> <span>Messages</span>
              </a>
            </li>
            <li class="treeview">
            <a href="#">
              <i class="fa fa-sticky-note"></i>
              <span>News</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="./add-news.php"><i class="fa fa-plus-circle"></i> Add News</a></li>
              <li><a href="./manage-news.php"><i class="fa fa-adjust"></i> Manage News</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bank"></i>
              <span>Accounts</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="./links.php"><i class="fa fa-plus"></i> Add Link</a></li>
              <li><a href="./wallets.php"><i class="fa fa-plus"></i> Add Wallets</a></li>
              <li><a href="./manage_accounts.php"><i class="fa fa-key"></i> Links & Wallets Settings</a></li>
            </ul>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>