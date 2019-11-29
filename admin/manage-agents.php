<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_GET['activate'])){
  $user_id = $_GET['activate'];
  $query=User::find_sql("UPDATE agents SET status=1 WHERE id='{$user_id}'");
}
if(isset($_GET['deactivate'])){
  $user_id = $_GET['deactivate'];
  $query=User::find_sql("UPDATE agents SET status=0 WHERE id='{$user_id}'");
}
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Manage Agents
        </h1>
        <ol class="breadcrumb">
          <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Manage agents</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="box">
<?php
$query=User::find_sql("SELECT *, (SELECT CONCAT(fname, ' ',lname) FROM users WHERE id=(user_id) LIMIT 1) AS full_name FROM agents ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
              <div class="box-header">
                <h3 class="box-title">Agent Logs</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <!-- History headings-->
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th><i class="fa fa-facebook" style="color:blue"></i> Facebook</th>
                      <th><i class="fa fa-whatsapp" style="color:green"></i> WhatsApp</th>
                      <th><i class="fa fa-twitter" style="color:blue"></i> Twitter</th>
                      <th>Members</th>
                      <th>Date</th>
                      <th>Control</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Loop the row-->
    <?php
    $counter=1;
      while($row=$db_init->fetch_array($query)){
    ?>
                    <!-- First row-->

                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td>
                        <?php echo $row['full_name']; ?>
                        </td>
                        <td><?php echo $row['fb']; ?></td>
                        <td><?php echo $row['wa']; ?></td>
                        <td><?php echo $row['tw']; ?></td>
                        <td><?php echo $row['members']; ?></td>
                        <td><?php echo $row['created']; ?></td>
                        <?php if($row['status']==0){ ?>
                          <td><a href="?activate=<?php echo $row['id']; ?>" class="btn btn-success btn-flat btn-block">Activate</a></td>
                        <?php }else{ ?>
                          <td><a href="?deactivate=<?php echo $row['id']; ?>" class="btn btn-danger btn-flat btn-block">De-activate</a></td>
                        <?php } ?>
                        
                    </tr>

                    <!-- End of first row-->
    <?php 
    $counter++;
    } 
    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
  <?php 
    }else{
      echo "No investment logs!";
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