<?php
function check_https() {
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
		return 'https';
	}
	return 'http';
}

function app_url() {
	return check_https() . '://' . $_SERVER['HTTP_HOST'];
}

define('BASE_URL', app_url() . '/sandhani');
define('ADMIN_URL', BASE_URL . '/admin');
define('COVID_URL', BASE_URL . '/covid');

 ?>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>Options</h3>
    <ul class="nav side-menu">

			<li><a href="<?php echo COVID_URL."/home" ?>" style="background-color: rgb(255, 0, 0);" > <i class="fa fa-exclamation-circle"></i> COVID-19 </a>
      </li>

      <li><a href="<?php echo ADMIN_URL."/home" ?>" <?php if($current_page=="home"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> > <i class="fa fa-home"></i> Home </a>
      </li>

      <li><a href="<?php echo ADMIN_URL."/add_doner" ?>" <?php if($current_page=="add"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-plus-square"></i> Add new donor </a>
      </li>

		</ul>
		<hr style="margin-top: -2px; margin-bottom: -5px; border-color: rgb(140, 138, 138)">
    <ul class="nav side-menu">

      <li><a href="<?php echo ADMIN_URL."/all_doner" ?>" <?php if($current_page=="all_list"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-list-ol"></i> All donor list </a>
      </li>

			<li><a href="<?php echo ADMIN_URL."/rmc_donor" ?>" <?php if($current_page=="rmc"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-graduation-cap"></i> RMC donor list </a>
      </li>

      <li><a href="<?php echo ADMIN_URL."/available_doner" ?>" <?php if($current_page=="available_list"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-bell"></i> Available donor list </a>
      </li>

      <li><a href="<?php echo ADMIN_URL."/upcoming_doner" ?>" <?php if($current_page=="upcomig_list"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-bell-o"></i> Upcoming donor list </a>
      </li>

      <li><a href="<?php echo ADMIN_URL."/blocked_doner" ?>" <?php if($current_page=="blocked_list"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-bell-slash-o"></i> Muted donor list </a>
      </li>

		</ul>
		<hr style="margin-top: -2px; margin-bottom: -5px; border-color: rgb(140, 138, 138)">
		<ul class="nav side-menu">

      <li><a href="<?php echo ADMIN_URL."/top_donor" ?>" <?php if($current_page=="top_donor"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-trophy"></i> Top donor list </a>
      </li>

			<li><a href="<?php echo ADMIN_URL."/custom_top" ?>" <?php if($current_page=="custom_top"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-line-chart"></i> Custom Top donor list </a>
      </li>

		</ul>
		<hr style="margin-top: -2px; margin-bottom: -5px; border-color: rgb(140, 138, 138)">
		<ul class="nav side-menu">

      <li><a href="<?php echo ADMIN_URL."/birthday" ?>" <?php if($current_page=="birthday"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-birthday-cake"></i> Birthday today </a>
      </li>

    </ul>
  </div>

</div>
<!-- /sidebar menu -->
