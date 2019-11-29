<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_GET['activate_w'])){
  $wallet_id = $_GET['activate_w'];
  $query = User::find_sql("UPDATE wallets SET status=0");
  if($query){
    $query = User::find_sql("UPDATE wallets SET status=1 WHERE id='{$wallet_id}'");
    echo "<script> window.location='manage_accounts.php'; </script>";
  }
}
if(isset($_GET['activate_l'])){
  $link_id = $_GET['activate_l'];
  $query = User::find_sql("UPDATE links SET status=0");
  if($query){
    $query = User::find_sql("UPDATE links SET status=1 WHERE id='{$link_id}'");
    echo "<script> window.location='manage_accounts.php'; </script>";
  }
}

?>
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Upload News
          <small>Western Trade | Admin</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Accounts & Settings</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="box">
<?php
$query = User::find_sql("SELECT * FROM links ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
            <div class="box-header">
              <h3 class="box-title">Activate / Set Links</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                <th>#</th>
                  <th>Title</th>
                  <th>Link</th>
                  <th>Date</th>
                  <th>Control</th>
                </tr>
<?php
$counter=1;
  while($row=$db_init->fetch_array($query)){
    $title = $row['title'];
    $link = $row['link'];
  ?>
                <tr>
                <td><?php echo $counter; ?></td>
                  <td><?php echo $title; ?></td>
                  <td><?php echo $link; ?></td>
                  <td><?php echo $row['date']; ?></td>
                  <?php if($row['status']==0){ ?>
                  <td><a href="?activate_l=<?php echo $row['id']; ?>" class="btn btn-block btn-warning btn-flat">Activate <i class="fa fa-plus"></i></a></td>
                  <?php }else{ ?>
                    <td><a href="#" class="btn btn-block btn-success btn-flat">Active <i class="fa fa-check"></i></a></td>
                  <?php } ?>
                </tr>
  <?php 
  $counter++;
  }  
?>
              </tbody></table>
            </div>
<?php 
  }  
?>  
            <!-- /.box-body -->
          </div>
          </div>

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>

        </div>
        <!-- /.row -->

        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="box">
<?php
$query = User::find_sql("SELECT * FROM wallets ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
            <div class="box-header">
              <h3 class="box-title">Activate / Set Wallets</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                <th>#</th>
                  <th>Name</th>
                  <th>Wallet Id</th>
                  <th>Date</th>
                  <th>Control</th>
                </tr>
<?php
$counter=1;
  while($row=$db_init->fetch_array($query)){
  ?>
                <tr>
                <td><?php echo $counter; ?></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['wallet_id']; ?></td>
                  <td><?php echo $row['date']; ?></td>
                  <?php if($row['status']==0){ ?>
                  <td><a href="?activate_w=<?php echo $row['id']; ?>" class="btn btn-block btn-warning btn-flat">Activate <i class="fa fa-plus"></i></a></td>
                  <?php }else{ ?>
                    <td><a href="#" class="btn btn-block btn-success btn-flat">Active <i class="fa fa-check"></i></a></td>
                  <?php } ?>
                </tr>
  <?php 
  $counter++;
  }  
?>
              </tbody></table>
            </div>
<?php 
  }  
?>  
            <!-- /.box-body -->
          </div>
          </div>

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>

        </div>
        <!-- /.row -->

        <!-- /.row -->
      </section>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->



<?php require_once('joins/footer.php'); ?>