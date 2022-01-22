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

      <li><a href="<?php echo COVID_URL."/home" ?>" <?php if($current_page=="home"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> > <i class="fa fa-home"></i> Home </a>
      </li>

      <li><a href="<?php echo COVID_URL."/add_doner" ?>" <?php if($current_page=="add"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-plus-square"></i> Add new donor </a>
      </li>

		</ul>
		<hr style="margin-top: -2px; margin-bottom: -5px; border-color: rgb(140, 138, 138)">
    <ul class="nav side-menu">

      <li><a href="<?php echo COVID_URL."/all_doner" ?>" <?php if($current_page=="all_list"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-list-ol"></i> All donor list </a>
      </li>

      <li><a href="<?php echo COVID_URL."/available_doner" ?>" <?php if($current_page=="available_list"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-bell"></i> Available donor list </a>
      </li>

      <li><a href="<?php echo COVID_URL."/blocked_doner" ?>" <?php if($current_page=="blocked_list"){ echo 'style="background-color: rgb(51, 74, 93)";'; } ?> ><i class="fa fa-bell-slash-o"></i> Muted donor list </a>
      </li>

		</ul>
		<hr style="margin-top: -2px; margin-bottom: -5px; border-color: rgb(140, 138, 138)">
    <ul class="nav side-menu">

      <li><a href="<?php echo ADMIN_URL."/home" ?>" style="background-color: rgb(38, 186, 152);"><i class="fa fa-tint"></i> Blood Section </a>
      </li>

		</ul>
  </div>

</div>
<!-- /sidebar menu -->
