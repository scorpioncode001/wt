<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_GET['remove'])){
  $img_id = $_GET['remove'];
  $query = User::find_sql("UPDATE wt_news SET status=0 WHERE id='{$img_id}'");
}
if(isset($_GET['add'])){
  $img_id = $_GET['add'];
  $query = User::find_sql("UPDATE wt_news SET status=1 WHERE id='{$img_id}'");
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
          <li class="active">News</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="box">
<?php
$query = User::find_sql("SELECT * FROM wt_news ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
            <div class="box-header">
              <h3 class="box-title">Delete / Update News</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                <th>#</th>
                  <th>News Heading</th>
                  <th>Preview image</th>
                  <th>Control</th>
                </tr>
<?php
$counter=1;
  while($row=$db_init->fetch_array($query)){
    $title = $row['title'];
    $img_news = "../newsphotos/".$row['picture'];
  ?>
                <tr>
                <td><?php echo $counter; ?></td>
                  <td><?php echo $title; ?></td>
                  <td><img src="<?php echo $img_news; ?>" class="img-circle" alt="News Image" style="width:70px;height:50px"></td>
                  <?php if($row['status']==0){ ?>
                  <td><a href="?add=<?php echo $row['id']; ?>" class="btn btn-block btn-warning btn-flat">Add <i class="fa fa-close"></i></a></td>
                  <?php }else{ ?>
                    <td><a href="?remove=<?php echo $row['id']; ?>" class="btn btn-block btn-danger btn-flat">Remove <i class="fa fa-close"></i></a></td>
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