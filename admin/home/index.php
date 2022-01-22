<?php
$current_page="home";
include_once '../inc/header.php';
include_once '../inc/sidebar.php';
include_once '../inc/middle.php';
include_once '../inc/database.php';
?>

  <div class="container">
    <?php
      $ap=$an=$bp=$bn=$op=$on=$abp=$abn=$total=$ready=$not_ready=$upcoming=$rmc=0;
      $sql = "SELECT * FROM donar_list WHERE muted=0 AND del=0";
      $result = mysqli_query($conn, $sql);
        $result_check = mysqli_num_rows($result);
        if( $result_check > 0 ){
          while ($row = mysqli_fetch_assoc($result)) {
            // donate day count
            $array = explode('/', $row['last_donate_date']);
            $day = $array[0];
            $month = $array[1];
            $year = $array[2];
            $last_donated = $year.'-'.$month.'-'.$day;
            $today = date('Y-m-d');
            $date1 = date_create($last_donated);
            $date2 = date_create($today);

            $diff = date_diff($date1,$date2);

            if ($row['rmc']==1) {
              $rmc++;
            }

            $days = $diff->format("%a");
            if($days>=120){
              $ready++;
              if($row['blood_group']=='A+'){
                $ap++;
              } else if($row['blood_group']=='A-'){
                $an++;
              } else if($row['blood_group']=='B+'){
                $bp++;
              } else if($row['blood_group']=='B-'){
                $bn++;
              } else if($row['blood_group']=='O+'){
                $op++;
              } else if($row['blood_group']=='O-'){
                $on++;
              } else if($row['blood_group']=='AB+'){
                $abp++;
              } else if($row['blood_group']=='AB-'){
                $abn++;
              }
            } else if($days>=113 && $days<120){
              $upcoming++;
            } else{
              $not_ready++;
            }
            $total++;
            // donate day count
          }
        }
     ?>
    <!-- top tiles -->
    <div class="row tile_count">
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> A+ dnonor</span>
        <div class="count green"><?php echo $ap; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> A- dnonor</span>
        <div class="count green"><?php echo $an; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> B+ dnonor</span>
        <div class="count green"><?php echo $bp; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> B- dnonor</span>
        <div class="count green"><?php echo $bn; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> O+ dnonor</span>
        <div class="count green"><?php echo $op; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> O- dnonor</span>
        <div class="count green"><?php echo $on; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
    </div>

    <div class="row tile_count">
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> AB+ dnonor</span>
        <div class="count green"><?php echo $abp; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> AB- dnonor</span>
        <div class="count green"><?php echo $abn; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available to donate </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-graduation-cap green" style="padding-right: 5px"></i> RMC donors</span>
        <div class="count blue"><?php echo $rmc; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> All blood group </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> Total donor</span>
        <div class="count blue"><?php echo $total; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> Available & not available </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> Available donor</span>
        <div class="count blue"><?php echo $ready; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> All blood group </i></span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-tint" style="padding-right: 5px; color: rgb(249, 25, 11)"></i> Upcoming donor</span>
        <div class="count red"><?php echo $upcoming; ?></div>
        <span class="count_bottom"><i class="green"></i> <i> All blood group </i></span>
      </div>
    </div>
    <!-- /top tiles -->

    <!-- home section -->
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="jumbotron">
        <h3><strong style="color: rgb(249, 25, 11)"> সন্ধানী </strong> <text class="text-primary"> রাজশাহী মেডিকেল কলেজ ইউনিট </text> </h3>
        <hr>
        <p>
          ব্লাড ডোনেশন এবং মনিটরিং অনলাইন সিস্টেম এ আপনাকে স্বাগতম! এই সিস্টেমটি সঠিক ভাবে পরিচালনা করার জন্য পূর্ব বর্ণিত ধাপ এবং পদ্ধতি গুলো অনুসরণ করুন। <br>
          <i class="text-danger" style="font-size: 15px"> <i class="fa fa-warning"></i> দায়িত্বপ্রাপ্ত এডমিন ছাড়া অন্য কেউ এখানে কাজ করার জন্য অনুমতি প্রাপ্ত নয়।</i></i>
        </p>
      </div>
    </div>
    <!-- home section -->
  </div>


<?php
include_once '../inc/footer.php';
?>
</body>
</html>
