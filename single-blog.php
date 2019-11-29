<?php require_once('includes/header.php'); ?>
<?php
echo "
<link href='vendor/sweetalert2/sweetalert2.min.css' rel='stylesheet'>
<script src='vendor/sweetalert2/sweetalert2.all.min.js'></script>
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
    <!--Blog-->


    <!--Breadcrumb-->
    <section id="breadcrumb" class="space">

        <div class="container">

            <div class="row">

                <div class="col-sm-6 breadcrumb-block">

                    <h2>News</h2>

                </div>

                <div class="col-sm-6 breadcrumb-block text-right">

                    <ol class="breadcrumb">

                        <li><a href="index.php">Home</a></li>

                        <li class="active">News</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>
    <?php
    if(isset($_GET['key']) && isset($_GET['tk']) && isset($_GET['news_token'])){
        $end = $db_init->escape($_GET['key']);
        $start = $db_init->escape($_GET['tk']);
        $news_token = $db_init->escape($_GET['news_token']);

        $explode1 = explode($end, $news_token);
        $explode2 = explode($start, $explode1[1]);
        $news_id = $explode2[0];

        if(isset($_SESSION['news_id'])){
            if($news_id != $_SESSION['news_id']){
                unset($_SESSION['limit']);
                $_SESSION['news_id'] = $news_id;
            }
        }else{
            $_SESSION['news_id'] = $news_id;
        }
        if($_SESSION['news_id'] != $news_id){
            unset($_SESSION['limit']);
        }
    ?>
    <?php
    $query_news = User::find_sql("SELECT * FROM wt_news WHERE status='1' AND id='$news_id' LIMIT 1");
    if(mysqli_num_rows($query_news)>0){
        while($news_rows=mysqli_fetch_assoc($query_news)){
            $title = $news_rows["title"];
            $picture = $news_rows["picture"];
            $details = $news_rows["details"];
            $date = date('F j, Y', strtotime($news_rows["date"]));
        }
        
    ?>
    <section id="blog" class="space-100 single-blog">

        <div class="container">

            <div class="row">

                <div class="col-sm-8 blog-base">

                    <div class="col-sm-12 no-padding">

                        <article class="col-sm-12 no-padding blog-block">

                            <img src="newsphotos/<?php echo $picture; ?>" alt="blog">

                            <div class="blog-content">

                                <div class="blog-info">

                                    <ul class="meta">

                                        <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Written by">

                                            <i class="fa fa-user"></i>Wetsern Trade Admin

                                        </li>

                                        <li>

                                            <a data-toggle="tooltip" data-placement="top" title="" href="#" data-original-title="Article Category">

                                                <i class="fa fa-folder-open-o"></i>News Details</a>

                                        </li>

                                        <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Published date">

                                            <i class="fa fa-calendar-o"></i><?php echo $date; ?>

                                        </li>

                                    </ul>

                                    <h2><a href="#"><?php echo $title; ?></a> </h2>

                                </div>

                                <p>
                                    <?php echo $details; ?>  
                                </p>

                            </div>
<?php
  }else{
      echo "<script> alert_func('warning', 'Content unavailable!', 'index.php'); </script>";
  }
?>
                           

                        </article>

                    </div>

                </div>

                <aside class="col-sm-4 sidebar">

    

    <?php
$news_id;
$query = User::find_sql("SELECT * FROM wt_news WHERE id!='{$news_id}'  ORDER BY id DESC LIMIT 10");
if($db_init->num_rows($query)>0){
    ?>
                    <div class="widget post">

                        <h3 class="module-title">Latest News</h3>
<?php
    while($col=$db_init->fetch_array($query)){
        $date_array=string_to_time($col['date']);
        $created_date_string = $date_array[0];
        $id = $col["id"];
        $explode = uniqid('', true);
        $exp = explode('.', $explode);
        $end = end($exp);
        $start = $exp[0];
?>
                        <div class="latestnews">

                            <div class="recent-post">

                                <a href="single-blog.php?news_token=<?php echo $end . $id . $start; ?>&tk=<?php echo $start; ?>&key=<?php echo $end; ?>" target="_parent"><?php echo $col['title']; ?></a>

                                <i class="fa fa-calendar"></i><?php echo $created_date_string; ?>

                            </div>

                        </div>
<?php
    }
?>

                    </div>
 <?php
}
?>
                </aside>

            </div>

        </div>

    </section>
<?php }else{
    echo "<script> alert_func('warning', 'Invalid Response!', 'index.php'); </script>";
}
?>



<?php require_once('includes/footer.php'); ?>