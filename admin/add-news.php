<?php
echo "
<link href='../vendor/sweetalert2/sweetalert2.min.css' rel='stylesheet'>
<script src='../vendor/sweetalert2/sweetalert2.all.min.js'></script>
<script>
function alert_func(type, message, loc) {
    Swal.fire({
        position: 'center',
        type: type,
        title: message,
        showConfirmButton: false,
        timer: 3000
    }).then(function(){
        if(loc!=''){
            window.location=loc;
        }
    });
    
}
</script>
";
?>
<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_POST['send_news'])){
  // $title = $_POST['title'];
  // $content = $_POST['content'];
  // $file = $_FILES['file']['name'];
  // if(!empty($title) && !empty($content) && !empty($file)){

  // }
  $file = $_FILES['file']['name'];
    $title = htmlentities($_POST['title']);
    $news_content = htmlentities($_POST['content']);
    
    $fileName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
                $fileExt = explode('.',$fileName);
                    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpeg','jpg','png');
    if (!in_array($fileActualExt, $allowed)){
        //MAKE POP UP
      echo "<script> alert_func('warning', 'Another file type used in Image Slot!', 'add-news.php'); </script>";
      // die();
    }
        if(!empty($title) && !empty($news_content) && !empty($fileName)){
       // if(count($errors)==0){
            $img_type = 'jpg';
            $current_year = date('Y'); $current_month = date('m'); $current_day = date('d'); $current_hour = date('H'); $current_min = date('i'); 
            if(strlen($current_month)==1){
                $current_new_month = '0'.$current_month;
            }else{
                $current_new_month = $current_month;
            }
                $current_sec = date('s');
                $generate = uniqid('', true);
                $explode = explode('.', $generate);
                $array1 = $explode[0];
                $array2 = $explode[1];
                $img_initial = "IMG-".$current_year.$current_new_month.$current_day.$current_hour.$current_min.$current_sec."-";
                $main_picture = $img_initial.$array2.".".$img_type;
                
                move_uploaded_file($_FILES["file"]["tmp_name"],"../newsphotos/".$main_picture);

            $myfiles1 = $main_picture;
            $sql = User::find_sql("INSERT INTO wt_news SET title='$title', details='$news_content', picture='$myfiles1', status=1, date=NOW() ");
            if($sql) {
             ?>
               <script type="text/javascript">
            alert_func('success', 'Uploaded Successfully!', '');
                </script>
            <?php

                    }else{
                        ?>
               <script type="text/javascript">
               alert_func('warning', 'Unable to Upload!', '');
                </script>
            <?php
            // die();
                    }
	   }else{
            echo "<script> alert_func('warning', 'All fields must be filled correctly!', ''); </script>";
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
          <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">News</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Upload</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Title</label>
                  <input type="text" name="title" class="form-control" id="news-head" placeholder="Enter title here">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Upload News Preview Image</label>
                  <input name="file" type="file" id="exampleInputFile" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Content</label>
                  <textarea name="content" class="form-control" placeholder="news content goes here" style="resize:none" rows="10"></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="send_news" class="btn btn-danger">Upload <i class="fa fa-upload"></i></button>
              </div>
            </form>
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