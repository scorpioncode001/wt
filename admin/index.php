<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          <small>Western Trade | Admin</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Registered Users</span>
                <span class="info-box-number"><?php echo $total_regs_counter; ?> <small><i class="fa fa-users"></i></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-binoculars"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Investments Made</span>
                <span class="info-box-number"><i class="fa fa-usd"></i><?php echo $total_investments; ?><small></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-maroon-active"><i class="ion ion-ios-cart-outline"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Withdrawal</span>
                <span class="info-box-number"><i class="fa fa-usd"> </i><?php echo $total_withdrawals; ?><small></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Bitcoin Live Status</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                      class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="btcwdgt-chart" bw-cash="true" bw-noshadow="true"></div>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <div class="btcwdgt-news" bw-entries="15" bw-theme="light"></div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./box-body -->
              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-3 col-xs-6">
                    <div class="btcwdgt-price" bw-cash="true" bw-theme="light"></div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-xs-6">
                    <div class="btcwdgt-price" bw-cash="true" bw-theme="light" bw-cur="eur"></div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6 col-xs-12">
                    <div class="description-block border-right">
                      <div class="btcwdgt-news-ticker"></div>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->

                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require_once('joins/footer.php'); ?>