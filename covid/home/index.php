<?php
$current_page="home";
include_once '../inc/header.php';
include_once '../inc/sidebar.php';
include_once '../inc/middle.php';
include_once '../../admin/inc/database.php';
?>

  <div class="container">
    <?php
      $ap=$an=$bp=$bn=$op=$on=$abp=$abn=$total=$ready=$not_ready=$upcoming=$rmc=0;
      $sql = "SELECT * FROM codiv_plasma_donor_list WHERE muted=0 AND del=0";
      $result = mysqli_query($conn, $sql);
        $result_check = mysqli_num_rows($result);
        if( $result_check > 0 ){
          while ($row = mysqli_fetch_assoc($result)) {
            // donate day count
            $array = explode('/', $row['record_date']);
            $day = $array[0];
            $month = $array[1];
            $year = $array[2];
            $last_donated = $year.'-'.$month.'-'.$day;
            $today = date('Y-m-d');
            $date1 = date_create($last_donated);
            $date2 = date_create($today);

            $diff = date_diff($date1,$date2);

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

    <!-- home section -->
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="jumbotron" style="background-color: white">
        <h1>
          COVID-19 Alert!
        </h1>
        <hr>
        <p>
          এই সেকশন টি শুধু মাত্র COVID-19 প্লাজমা ডোনারদের তথ্য সংগ্রহে ব্যাবহার করা হবে। সাধারন blood collection/donation এর জন্য পুর্বের মূল সেকশন টি ব্যাবহার করুন।
        </p>
        <a href="<?php echo ADMIN_URL; ?>/home" class="btn btn-md btn-success"> <i class="fa fa-tint" style="margin-right: 10px;"></i> Return to Blood Donation Section</a>
        <hr>
        <i class="text-danger" style="font-size: 15px"> <i class="fa fa-warning"></i> দায়িত্বপ্রাপ্ত এডমিন ছাড়া অন্য কেউ এখানে কাজ করার জন্য অনুমতি প্রাপ্ত নয়।</i></i>
      </div>
    </div>
    <!-- home section -->
  </div>


<?php
include_once '../inc/footer.php';
?>
</body>
</html>
