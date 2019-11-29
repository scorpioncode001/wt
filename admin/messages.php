<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Mailbox
      </h1>
      <ol class="breadcrumb">
        <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box">
<?php
$query=User::find_sql("SELECT * FROM contact_admins ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
                <div class="box-header">
                  <h3 class="box-title">Inbox</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                      <!-- History headings-->
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>From <i class="fa fa-user"></i></th>
                      <th>Message <i class="fa fa-envelope"></i></th>
                      <th>Date <i class="fa fa-calendar-check-o"></i></th>
                      <th>Status</th>
                      <th>Control <i class="fa fa-industry"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Loop the row-->
    <?php
    $msg_counter=1;
      while($row=$db_init->fetch_array($query)){
        $msg_id = $row['id'];
        $created = $row['created'];
        $trunc_msg = wordwrap($row['message'], 40, "[{@}]");
        $exp = explode("[{@}]",$trunc_msg);
        $msg=$exp[0]."...";
    ?>
                        <!-- First row-->
                    <tr>
                      <td><?php echo $msg_counter; ?></td>
                      <td><?php echo $row['sender']; ?></td>
                      <td><?php echo $msg; ?></td>
                      <td><?php echo $created; ?></td>
                      <?php if($row['status']==0){ ?>
                        <td><span class="text-danger"><i class="fa fa-circle"></i> unread</span></td>
                      <?php }else{ ?>
                        <td><span class="text-success"><i class="fa fa-circle"></i> read</span></td>
                      <?php } ?>
                      <td style="text-align:center"><a href="./read-messages.php?msg_id=<?php echo $msg_id; ?>" class="btn btn-info <?php if($row['status']==1){ echo 'btn-facebook'; } ?> btn-block"><i class="fa fa-envelope-open"></i> Open</a></td>
                    </tr>
                    <!-- End of first row-->
    <?php 
    $msg_counter++;
    } 
    ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
  <?php 
    }else{
      echo "No message logs!";
    } 
  ?>

        </div>
        <!--/.col (left) -->

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    
  <?php require_once('joins/footer.php'); ?>