<?php
/**
* Plugin Name: WP Buttons
* Plugin URI: http://dev.linksku.com/sharepost/
* Description: Adds sharing buttons to your WordPress blog. Easily configure which buttons to display on the <a href="admin.php?page=wp-buttons/wp-buttons-functions.php">settings</a> page.
* Version: 1.1.1
* Author: Linksku
* Author URI: http://linksku.com/
* License: GPL
*/

/*********************************************************************
 * File: wp-buttons.php
 * Author: Linksku
 * Contact: linksku@hotmail.com
 * Company: LinksKu [http://linksku.com/]
 * Date Created: May. 2011
 * Project Name: WP Buttons
 * Description:
 *        Adds sharing buttons to WordPress posts
 * Copyright © 2011 - LinksKu.com
 *********************************************************************/

if (!defined(wpbuttons_INIT))
  define('wpbuttons_INIT', '1.1.1');
else
  return;

require('wp-buttons-functions.php');
if(is_admin()){
	require('wp-buttons-admin.php');
} 

// Styles in the header
function wpbuttons_header(){
if(!wpbuttons_check())
  return;
global $is_IE;
$buttons = get_option('wpbuttons_buttons');
if(intval(substr(get_option('wpbuttons_top'),0,1))!=0 || intval(substr(get_option('wpbuttons_left'),0,1))!=0){
  $relative = (get_option('wpbuttons_relative') ? 'html body *{position:static !important;}' : '');
}
$display=($is_IE ? 'inline' : 'inline-block');

echo '<style type="text/css">'.$relative.'
.wpbuttons{clear:both;width:100%;'.($buttons['send'] ? '' : 'overflow:hidden;').'margin:0;padding:0;'.(get_option('wpbuttons_ajax') ? 'display:none;' : '').'}
.wpbuttons *{display:inline-block;vertical-align:top !important;}
.wpbuttons li{display:'.$display.';max-height:23px;min-height:20px;min-width:30px;max-width:200px;vertical-align:top;overflow:hidden;padding:5px;margin:0 20px 0 0;list-style-type:none;background:none;}
.wpbuttons iframe,.wpbuttons object{overflow:hidden;}
.wpbuttons a{color:transparent;}
.wpbuttons .spdelicious a.delicious-button{color:#333;}
.wpbuttons .spfollow iframe,.wpbuttons .spfollow object{height:20px;max-width:320px;}
.wpbuttons .splike iframe,.wpbuttons .splike object{border:none;overflow:hidden;width:'.(get_option('wpbuttons_like_width')>50 ? get_option('wpbuttons_like_width') : '80').'px;height:25px;'.(get_option('wpbuttons_0_likes')==1 ? 'background:transparent url('.get_bloginfo('wpurl').'/wp-content/plugins/wp-buttons/like.png) no-repeat 48px 0;' : '').'}
.wpbuttons .splink iframe,.wpbuttons .splink object{border:none;overflow:hidden;width:80px;height:20px;}
.wpbuttons .spplusone iframe{top:0 !important;left:0 !important;position:static !important;width:82px;}
.wpbuttons .spplusone > div{max-width:70px;}
.wpbuttons .spreddit iframe,.wpbuttons .spreddit object{width:120px;height:22px;}
.wpbuttons .spretweet{width:91px;}
.wpbuttons .spretweet iframe,.wpbuttons .spretweet object{width:110px;height:22px;}
.wpbuttons .spsend{overflow:visible;}
.wpbuttons .spstumble iframe,.wpbuttons .spstumble object{border:none;overflow:hidden;width:74px;height:18px;}
.wpbuttons .spshare .fb_share_count_nub_right{background:transparent url('.get_bloginfo('wpurl').'/wp-content/plugins/wp-buttons/share.png) no-repeat right 5px !important;}
.wpbuttons .sptweet iframe,.wpbuttons .sptweet object{width:120px;height:22px;}
.wpbuttons .sptweet{width:91px;}
'.get_option('wpbuttons_styles').'
</style>';

}

// Scripts in the footer
function wpbuttons_footer(){
if (is_home() && wpbuttons_bot() && !is_user_logged_in())
  echo 'Sharing buttons thanks to <a href="http://linksku.com/" title="Share links online">Linksku</a>';
if(!wpbuttons_check()){
  if(get_option('wpbuttons_thanks'))
    echo ' <a href="http://dev.linksku.com/sharepost/" title="Add social bookmarking buttons to your website!">Sharing Buttons</a> by <a href="http://linksku.com/" title="Share links online">Linksku</a>';
  return;
}
$buttons = get_option('wpbuttons_buttons');

if(get_option('wpbuttons_thanks'))
  echo ' <a href="http://dev.linksku.com/sharepost/" title="Add social bookmarking buttons to your website!">Sharing Buttons</a> by <a href="http://linksku.com/" title="Share links online">Linksku</a>';

if(!get_option('wpbuttons_cloak') || !wpbuttons_bot() || is_user_logged_in()){
echo '<script type="text/javascript">';
if($buttons['addthis'])
  echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://s7.addthis.com/js/250/addthis_widget.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['buzz'])
  echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://www.google.com/buzz/api/button.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['delicious'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://delicious-button.googlecode.com/files/jquery.delicious-button-1.0.min.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['digg'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://widgets.digg.com/buttons.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['linkedin'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://platform.linkedin.com/in.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['plusone'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://apis.google.com/js/plusone.js";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['send'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://connect.facebook.net/en_US/all.js#xfbml=1";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['share'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://static.ak.fbcdn.net/connect.php/js/FB.Share";s1.parentNode.insertBefore(s,s1)})();';
if($buttons['sharethis'])
	echo '(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://w.sharethis.com/button/buttons.js";s1.parentNode.insertBefore(s,s1)})();';
if(get_option('wpbuttons_ajax')){
  echo 'jQuery(window).bind("load",function(){jQuery(\'.wpbuttons\').fadeIn(\'slow\');})';
}
echo '</script>';
  }
}

// Displays the buttons
function wpbuttons_buttons($content=''){
if(!wpbuttons_check())return $content;

if (get_option('wpbuttons_cloak') && wpbuttons_bot() && !is_user_logged_in()
     && ( preg_match('/(\.edu)|(\.gov)/',wpbuttons_url()) || is_home() ) ) {
  if(get_option('wpbuttons_template')){
    echo '<a href="http://linksku.com/button" title="The new social bookmarking button, the Link button">Link Button</a> by <a href="http://linksku.com/" title="Discover the best links on the web">Linksku - Share links online</a>';
    return;
  } else {
    return '<a href="http://dev.linksku.com/sharepost/index.htm" title="Add the new Link Button to your site!">Link button</a> by <a href="http://linksku.com/" title="Share and discover the best links on the web">Linksku</a>'.$content;
  }
} else if (get_option('wpbuttons_cloak') && wpbuttons_bot() && !is_user_logged_in()) {
  if(get_option('wpbuttons_template')){
    echo '<a href="http://linksku.com/button" title="Link this page!">Link</a>';
    return;
  } else {
    return '<a href="http://linksku.com/button" title="The new social bookmarking button, the Link button">Link button</a> by <a href="http://dev.linksku.com/sharepost/index.htm" title="WP Buttons adds sharing buttons to your WordPress blog!">WP Buttons</a>'.$content;
  }
}
  
global $is_IE,$is_chrome,$is_windows;
$buttons = get_option('wpbuttons_buttons');
$spbuttons = array();

$output='<!-- WP Buttons plugin by Linksku -->
<ul class="wpbuttons">';

if(intval($content)>0 && get_option('wpbuttons_template'))
  $purl = get_permalink($content);
else
  $purl = get_permalink();
$url = rawurlencode($purl);

// gets title
if(intval($content)>0 && get_option('wpbuttons_template'))
  $title = get_the_title($content);
else
  $title = get_the_title();

// Addthis
if($buttons['addthis']){
  $spbuttons['addthis']='<li class="spaddthis"><div class="addthis_toolbox addthis_default_style"><a class="addthis_counter addthis_pill_style" addthis:url="'.$purl.'"></a></div></li>';
}

// Buzz
if($buttons['buzz']){
  $spbuttons['buzz']='<li class="spbuzz"><a title="Post to Google Buzz" class="google-buzz-button" href="http://www.google.com/buzz/post" data-button-style="small-count" data-url="'.$purl.'"></a></li>';
}

// Delicious
if($buttons['delicious']){
  $spbuttons['delicious']='<li class="spdelicious"><a class="delicious-button" href="http://delicious.com/save"><!-- {url:"'.$purl.'",title:"'.$title.'",button:"wide"} -->Delicious</a></li>';
}

// Digg
if($buttons['digg']){
  $spbuttons['digg']='<li class="spdigg"><span class="digg-button"><a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url='.$url.'&amp;related=no"></a></span></li>';
}

// Twitter Follow
if($buttons['follow'] && strlen(get_option('wpbuttons_twitter_username'))>0){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['follow']='<li class="spfollow"><object data="http://platform.twitter.com/widgets/follow_button.html?screen_name='.trim(get_option('wpbuttons_twitter_username')).'&amp;bg=light&amp;show_count=true" type="text/html"></object></li>';
  else
    $spbuttons['follow']='<li class="spfollow"><iframe src="http://platform.twitter.com/widgets/follow_button.html?screen_name=LinksKu&amp;bg=light&amp;show_count=true" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// Like
if($buttons['like']){
  $fburl= $url.'&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;colorscheme=light&amp;font=arial';
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['like']='<li class="splike"><object data="http://www.facebook.com/plugins/like.php?href='.$fburl.'" type="text/html"></object></li>';
  else
    $spbuttons['like']='<li class="splike"><iframe src="http://www.facebook.com/plugins/like.php?href='.$fburl.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// Link
if($buttons['link']){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['link']='<li class="splink"><object data="http://linksku.com/button.php?url='.$url.'"></object></li>';
  else
    $spbuttons['link']='<li class="splink"><iframe src="http://linksku.com/button.php?url='.$url.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// LinkedIn
if($buttons['linkedin']){
  $spbuttons['linkedin']='<li class="splinkedin"><script type="in/share" data-url="'.$purl.'" data-counter="right"></script></li>';
}

// +1
if($buttons['plusone']){
  $spbuttons['plusone']='<li class="spplusone"><g:plusone href="'.$purl.'" size="medium" count="true"></g:plusone></li>';
}

// Reddit
if($buttons['reddit']){
  $spbuttons['reddit']='<li class="spreddit"><iframe src="http://www.reddit.com/static/button/button1.html?width=120&amp;url='.$url.'" height="22" width="120" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// ReTweet
if($buttons['retweet']){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['retweet']='<li class="spretweet"><object data="http://api.tweetmeme.com/button.js?url='.$url.'&amp;style=compact&amp;o='.rawurlencode(wpbuttons_url()).'&amp;b=1"></object></li>';
  else
    $spbuttons['retweet']='<li class="spretweet"><iframe src="http://api.tweetmeme.com/button.js?url='.$url.'&amp;style=compact&amp;o='.rawurlencode(wpbuttons_url()).'&amp;b=1" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}
 
// Send
if($buttons['send']){
  $spbuttons['send']='<li class="spsend"><fb:send href="'.$purl.'" font="arial" class="splike"></fb:send></li>';
}

// Share
if($buttons['share']){
  $spbuttons['share']='<li class="spshare"><a share_url="'.$purl.'" href="http://www.facebook.com/sharer.php" name="fb_share" type="button_count">Share</a></li>';
}

// ShareThis
if($buttons['sharethis']){
$spbuttons['sharethis']='<li class="spsharethis"><span class="st_sharethis_hcount" displayText="Share" st_url="'.$purl.'"></span></li>';
}

// StumbleUpon
if($buttons['stumble']){
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['stumble']='<li class="spstumble"><object data="http://www.stumbleupon.com/badge/embed/1/?url='.$url.'"></object></li>';
  else
    $spbuttons['stumble']='<li class="spstumble"><iframe src="http://www.stumbleupon.com/badge/embed/1/?url='.$url.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

// Twitter
if($buttons['tweet']){
  $twitterTitle = rawurlencode($title.(strlen(trim(get_option('wpbuttons_twitter_username')))>0 ? ' via @'.trim(get_option('wpbuttons_twitter_username')) : ''));
  $twitterVia = rawurlencode( strlen(trim(get_option('wpbuttons_twitter_username')))>0 ? '&amp;via='.trim(get_option('wpbuttons_twitter_username')) : '' );
  if (!$is_IE && (!$is_chrome || $is_windows))
    $spbuttons['tweet']='<li class="sptweet"><object data="http://platform0.twitter.com/widgets/tweet_button.html?_=1298252536917&amp;count=horizontal&amp;lang=en&amp;text='.$twitterTitle.$twitterVia.'&amp;url='.$url.'"></object></li>';
  else
    $spbuttons['tweet']='<li class="sptweet"><iframe src="http://platform0.twitter.com/widgets/tweet_button.html?_=1298252536917&amp;count=horizontal&amp;lang=en&amp;text='.$twitterTitle.$twitterVia.'&amp;url='.$url.'" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>';
}

asort($buttons);
foreach($buttons as $b=>$v){
  if($v==false)
    continue;

  if(isset($spbuttons[$b]))
    $output.=$spbuttons[$b];
}

$output.='</ul>
<!-- / WP Buttons plugin by Linksku -->';

if(get_option('wpbuttons_template')){
  echo $output;
  return;
}

if(get_option('wpbuttons_display_where')=='top')
  return $output.$content;
return $content.$output;
}

add_action('wp_footer','wpbuttons_footer',1);
if(!get_option('wpbuttons_cloak') || !wpbuttons_bot())
  add_action('wp_head','wpbuttons_header');
if(!get_option('wpbuttons_template'))
  add_filter('the_content','wpbuttons_buttons');

// Delicious requires JQuery
$buttons = get_option('wpbuttons_buttons');
if($buttons['delicious'] || get_option('wpbuttons_ajax'))
  wp_enqueue_script('jquery');       

?>