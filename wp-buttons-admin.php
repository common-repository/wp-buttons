<?php
// create custom plugin settings menu
add_action('admin_menu', 'wpbuttons_create_menu');
add_filter('plugin_action_links', 'plugin_links', 10, 2 );


function register_wpbuttons() {

register_setting( 'wpbuttons', 'wpbuttons_version');
register_setting( 'wpbuttons', 'wpbuttons_buttons' );
register_setting( 'wpbuttons', 'wpbuttons_template');
register_setting( 'wpbuttons', 'wpbuttons_display' );
register_setting( 'wpbuttons', 'wpbuttons_styles');
register_setting( 'wpbuttons', 'wpbuttons_cloak');
register_setting( 'wpbuttons', 'wpbuttons_ajax');
register_setting( 'wpbuttons', 'wpbuttons_0_likes'); 
register_setting( 'wpbuttons', 'wpbuttons_like_width');
register_setting( 'wpbuttons', 'wpbuttons_twitter_username');
register_setting( 'wpbuttons', 'wpbuttons_thanks');

if (!get_option('wpbuttons_version') || get_option('wpbuttons_version')<1.1)
  wpbuttons_register();
add_option( 'wpbuttons_buttons', array('like'=>1, 'tweet'=>2, 'link'=>3) );
add_option( 'wpbuttons_template', 0 );
add_option( 'wpbuttons_display', array('post'=>1, 'home'=>1) );
add_option( 'wpbuttons_display_where', 'bottom' );
add_option( 'wpbuttons_styles', '.wpbuttons li{margin-right:20px;}' );
add_option( 'wpbuttons_cloak', 1 );
add_option( 'wpbuttons_0_likes', 0 );
add_option( 'wpbuttons_like_width', 80 );
add_option( 'wpbuttons_twitter_username', '' );
add_option( 'wpbuttons_thanks', 0 );

update_option( 'wpbuttons_version', wpbuttons_INIT );
}


function wpbuttons_admin(){

$buttons = get_option('wpbuttons_buttons');
$display = get_option('wpbuttons_display');
?>
<style type="text/css">
#wpbody-content{position:relative;}
#donate-wrap{float:right;width:30%;min-height:100px;padding:15px 1.5%;border:1px solid #ddd;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;}
#support-wpbuttons{font-size:1.4em;font-weight:700;margin-bottom:15px;}
#donate-wrap p{line-height:1.5em;text-indent:15px;}
#paypal{margin:15px 0;width:100%;text-align:center;}
input[type="image"]{width:92px;margin:0 auto;}
.follow{width:100%;list-style-type:none;overflow:hidden;height:21px;padding:0 10px;}
.follow li{width:49%;float:left;}
ul.links{margin:2em 10px;}

#button-table-wrap{border:1px solid #ddd;margin:0 2% 40px 1px;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;}
#button-table{margin:0;}
#button-table tr{border-top:1px solid #eee;max-width:100%;}
#button-table tr,#button-table td{height:30px;overflow:hidden;}
#button-table .th{background:#d9d9d9;background:-moz-linear-gradient(bottom,#d7d7d7,#efefef);background:-webkit-gradient(linear,left bottom,left top,from(#d7d7d7),to(#efefef));font-weight:700;-webkit-border-top-left-radius:11px;-webkit-border-top-right-radius:11px;-moz-border-radius-topleft:11px;-moz-border-radius-topright:11px;border-top-left-radius:11px;border-top-right-radius:11px;}
#button-table th{padding-left:15px;}
#button-table tr td:first-child,#button-table tr th:first-child{width:7em;}
#button-table td{padding:5px 8px;min-width:6em;}
#button-table input[type="text"]{width:5em;text-align:center;}
.spfollow{height:20px;max-width:320px;}
.splike{border:none;overflow:hidden;width:78px;height:21px;}
.splink{border:none;overflow:hidden;width:79px;height:20px;}
.spsend{border:none;width:78px;height:21px;}
.spstumble{border:none;overflow:hidden;width:74px;height:18px;}
.spretweet{width:90px;height:20px;}
.sptweet{width:110px;height:20px;}
#plusone iframe{top:0 !important;left:0 !important;position:static !important;}

#bottom-wrap td{padding-bottom:50px;}
.info{font-size:11px;color:#555;}
.code{background-color:#dedede;}
#wpbuttons_styles{width:80%;height:200px;padding:5px;line-height:1.3em;font-size:1.1em;font-family:arial;}
.js{color:red;}
.jquery{color:blue;}
.html{color:green;}
.glitch{color:brown;}
</style>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<h2>WP Buttons Options</h2>
<span class="info">If you don&#39;t know what to do, simply keep the default settings.</span>

<div style="min-width:500px;overflow:hidden;max-width:100%;margin-top:1em;padding-right:10px;">
<div id="donate-wrap">
  <div id="support-wpbuttons">Support WP Buttons</div>
  <p>Hello WP Buttons user, thank you for choosing WP Buttons!</p>
  <p>My name is Leo Jiang and I am a 15 year developer. If WP Buttons helped you to improve your blog, please donate! <img src="../wp-includes/images/smilies/icon_smile.gif" alt=":)" width="15px" height="15px" /></p>
  <?php if(time()<1309478400){ ?><p><b>June 24: My server is no longer able to handle all the traffic from this plugin. I am temporarily using my laptop as a backup server. If you like this plugin, please help me get a new server!</b></p><?php } ?>
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal">
  <div>
    <input type="hidden" name="cmd" value="_donations" />
    <input type="hidden" name="business" value="leojiang000@gmail.com" />
    <input type="hidden" name="lc" value="US" />
    <input type="hidden" name="item_name" value="Linksku" />
    <input type="hidden" name="no_note" value="0" />
    <input type="hidden" name="currency_code" value="USD" />
    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest" />
    <input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />
    <img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/scr/pixel.gif" width="1" height="1" />
  </div>
  </form>
  <ul class="follow">
    <li><iframe class="splike" src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fpages%2FLinksku%2F102422753142997&amp;layout=button_count&amp;show_faces=false&amp;width=78&amp;action=like&amp;colorscheme=light&amp;font=arial" scrolling="no" frameborder="0" allowtransparency="true"></iframe></li>
    <li><iframe class="spfollow" src="http://platform.twitter.com/widgets/follow_button.html?screen_name=LinksKu&amp;bg=light&amp;show_count=false" allowtransparency="true" frameborder="0" scrolling="no" class="twitter-follow-button"></iframe></li>
  </ul>
  <ul class="links">
    <li><a href="http://dev.linksku.com/sharepost/">Plugin page</a></li>
    <li><a href="http://dev.linksku.com/sharepost/faq.htm">FAQ</a></li>
    <li><a href="http://dev.linksku.com/sharepost/support.htm">Support</a></li>
    <li><a href="http://linksku.com/">My homepage</a></li>
  </ul>
  <iframe src="http://www.facebook.com/plugins/recommendations.php?site=linksku.com&amp;width=300&amp;height=300&amp;header=false&amp;colorscheme=light&amp;font&amp;border_color=%23dddddd" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:300px;" allowTransparency="true"></iframe>
</div>

<form method="post" action="options.php" style="width:66%;float:left;">
<?php wp_nonce_field('update-options'); ?>
<div id="button-table-wrap">
  <table class="form-table" id="button-table">
    <tbody>
      <tr valign="top" class="th">
        <th scope="row">#</th>
        <th scope="row">Button</th>
        <th scope="row">Demo</th>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[addthis]" value="<?php if(intval($buttons['addthis'])>0) echo $buttons['addthis'] ?>" />
        </td>
        <td>AddThis <span class="js">*</span> <span class="html">*</span> <span class="glitch">*</span></td>
        <td>
          <div class="addthis_toolbox addthis_default_style">
            <a class="addthis_counter addthis_pill_style" addthis:url="http%3A%2F%2Flinksku.com"></a>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[buzz]" value="<?php if(intval($buttons['buzz'])>0) echo $buttons['buzz'] ?>" />
        </td>
        <td>Buzz <span class="js">*</span></td>
        <td>
          <a title="Post to Google Buzz" class="google-buzz-button" href="http://www.google.com/buzz/post" data-button-style="small-count" data-url="http://linksku.com"></a>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[delicious]" value="<?php if(intval($buttons['delicious'])>0) echo $buttons['delicious'] ?>" />
        </td>
        <td>Delicious <span class="js">*</span> <span class="jquery">*</span></td>
        <td>
          <a class="delicious-button" href="http://delicious.com/save"><!-- {url:"http://linksku.com",title:"Linksku :: Share links online",button:"wide"} -->Delicious</a>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[digg]" value="<?php if(intval($buttons['digg'])>0) echo $buttons['digg'] ?>" />
        </td>
        <td>Digg <span class="js">*</span></td>
        <td>
          <span class="digg-button">
            <a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=http%3A%2F%2Flinksku.com"></a>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[follow]" value="<?php if(intval($buttons['follow'])>0) echo $buttons['follow'] ?>" />
        </td>
        <td>Follow <span class="glitch">*</span></td>
        <td>
          <iframe class="spfollow" src="http://platform.twitter.com/widgets/follow_button.html?screen_name=LinksKu&amp;bg=light&amp;show_count=true" allowtransparency="true" frameborder="0" scrolling="no" class="twitter-follow-button"></iframe>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[like]" value="<?php if(intval($buttons['like'])>0) echo $buttons['like'] ?>" />
        </td>
        <td>Like</td>
        <td>
          <iframe class="splike" src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Flinksku.com&amp;layout=button_count&amp;show_faces=false&amp;width=78&amp;action=like&amp;colorscheme=light&amp;font=arial" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[link]" value="<?php if(intval($buttons['link'])>0) echo $buttons['link'] ?>" />
        </td>
        <td>Link</td>
        <td>
          <iframe class="splink" src="http://linksku.com/button.php?url=http%3A%2F%2Flinksku.com" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[linkedin]" value="<?php if(intval($buttons['linkedin'])>0) echo $buttons['linkedin'] ?>" />
        </td>
        <td>LinkedIn <span class="js">*</span> <span class="html">*</span></td>
        <td>
          <script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-url="http://linksku.com" data-counter="right"></script>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[plusone]" value="<?php if(intval($buttons['plusone'])>0) echo $buttons['plusone'] ?>" />
        </td>
        <td>Google +1 <span class="js">*</span> <span class="glitch">*</span></td>
        <td style="position:relative;" id="plusone">
          <g:plusone href="http://linksku.com" size="medium" count="true"></g:plusone>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[reddit]" value="<?php if(intval($buttons['reddit'])>0) echo $buttons['reddit'] ?>" />
        </td>
        <td>Reddit <span class="html">*</span></td>
        <td>
          <iframe src="http://www.reddit.com/static/button/button1.html?width=120&amp;url=http%3A%2F%2Flinksku.com" height="22" width="120" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[retweet]" value="<?php if(intval($buttons['retweet'])>0) echo $buttons['retweet'] ?>" />
        </td>
        <td>ReTweet</td>
        <td>
          <iframe class="spretweet" src="http://api.tweetmeme.com/button.js?url=http%3A%2F%2Flinksku.com&amp;style=compact&amp;o=<?php echo urlencode(wpbuttons_url()); ?>&amp;b=1" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        </td>
      </tr>
      <tr style="overflow:visible;">
        <td>
          <input type="text" name="wpbuttons_buttons[send]" value="<?php if(intval($buttons['send'])>0) echo $buttons['send'] ?>" />
        </td>
        <td>Send <span class="js">*</span> <span class="html">*</span> <span class="glitch">*</span></td>
        <td style="overflow:visible;">
          <fb:send href="http://linksku.com" font="arial" class="spsend"></fb:send>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[share]" value="<?php if(intval($buttons['share'])>0) echo $buttons['share'] ?>" />
        </td>
        <td>Share <span class="js">*</span> <span class="html">*</span></td>
        <td>
          <a share_url='http%3A%2F%2Flinksku.com' href='http://www.facebook.com/sharer.php' name='fb_share' type='button_count'>Share</a>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[sharethis]" value="<?php if(intval($buttons['sharethis'])>0) echo $buttons['sharethis'] ?>" />
        </td>
        <td>Sharethis <span class="js">*</span> <span class="html">*</span> <span class="glitch">*</span></td>
        <td>
          <span class="st_sharethis_hcount" displayText="Share" st_url="http%3A%2F%2Flinksku.com"></span>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[stumble]" value="<?php if(intval($buttons['stumble'])>0) echo $buttons['stumble'] ?>" />
        </td>
        <td>Stumble</td>
        <td>
          <iframe class="spstumble" src="http://www.stumbleupon.com/badge/embed/1/?url=http%3A%2F%2Flinksku.com" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="wpbuttons_buttons[tweet]" value="<?php if(intval($buttons['tweet'])>0) echo $buttons['tweet'] ?>" />
        </td>
        <td>Tweet</td>
        <td>
          <iframe class="sptweet" src="http://platform0.twitter.com/widgets/tweet_button.html?_=1298252536917&amp;count=horizontal&amp;lang=en&amp;text=Linksku%20%3A%3A%20Share%20links%20online&amp;via=Linksku&amp;url=http%3A%2F%2Flinksku.com" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <span class="info">
            Leave the buttons that you don&#39;t want blank.
            <br />
            <span class="js">*</span> requires Javascript
            <br />
            <span class="jquery">*</span> requires JQuery
            <br />
            <span class="html">*</span> breaks HTML validation
            <br />
            <span class="glitch">*</span> possibly glitchy
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div id="bottom-wrap">
  <table class="form-table">
     <tr valign="top">
       <th scope="row">Pages to display on</th>
       <td>
        <input type="checkbox" value="1" name="wpbuttons_display[post]"<?php if($display['post']) echo ' checked="checked"'; ?> /> Post
        <br />
        <input type="checkbox" value="1" name="wpbuttons_display[page]"<?php if($display['page']) echo ' checked="checked"'; ?> /> Page
        <br />
        <input type="checkbox" value="1" name="wpbuttons_display[home]"<?php if($display['home']) echo ' checked="checked"'; ?> /> Homepage
        <br />
        <input type="checkbox" value="1" name="wpbuttons_display[category]"<?php if($display['category']) echo ' checked="checked"'; ?> /> Category
        <br />
        <input type="checkbox" value="1" name="wpbuttons_display[search]"<?php if($display['_search']) echo ' checked="checked"'; ?> /> Search
        <br />
        <input type="checkbox" value="1" name="wpbuttons_display[archive]"<?php if($display['archive']) echo ' checked="checked"'; ?> /> Archive
        <br />
        <input type="checkbox" value="1" name="wpbuttons_display[all]"<?php if($display['all']) echo ' checked="checked"'; ?> /> All Pages
       </td>
     </tr>
     <tr valign="top">
       <th scope="row">Where to display</th>
       <td>
        <input type="radio" value="top" name="wpbuttons_display_where"<?php if(get_option('wpbuttons_display_where')=='top') echo ' checked="checked"'; ?> /> Top of post
        <br />
        <input type="radio" value="bottom" name="wpbuttons_display_where"<?php if(get_option('wpbuttons_display_where')=='bottom') echo ' checked="checked"'; ?> /> Bottom of post
       </td>
     </tr>
     <tr valign="top">
        <th scope="row">Custom styles</th>
        <td><textarea name="wpbuttons_styles" id="wpbuttons_styles" cols="50" rows="8"><?php echo (get_option('wpbuttons_styles') ? get_option('wpbuttons_styles') : ''); ?></textarea>
        <br />
       <span class="info">Use <span class="code">#wpbuttons</span> for the container of the buttons, <span class="code">#wpbuttons li</span> for each button, and <span class="code">#wpbuttons li.sp[buttonname]</span> for specific buttons.</span>
       </td>
     </tr>
     <tr valign="top">
        <th scope="row">Specific button options</th>
        <td>
        Like button 0 Likes feature: <input type="checkbox" value="1" name="wpbuttons_0_likes"<?php if(get_option('wpbuttons_0_likes')) echo ' checked="checked"'; ?> />
        <br />
        Like button width (if your blog isn&#39;t in English): <input type="text" value="<?php echo (get_option('wpbuttons_like_width') ? get_option('wpbuttons_like_width') : ''); ?>" name="wpbuttons_like_width" style="width:3em;" />px
        <br />
        Twitter username: @<input type="text" value="<?php echo (get_option('wpbuttons_twitter_username') ? get_option('wpbuttons_twitter_username') : ''); ?>" name="wpbuttons_twitter_username" />
       </td>
     </tr>     
     <tr valign="top">
       <th scope="row">Manually insert buttons in template</th>
       <td>
         <input type="checkbox" value="1" name="wpbuttons_template"<?php if(get_option('wpbuttons_template')) echo ' checked="checked"'; ?> /> Enable
         <br />
         <span class="info">If you would like to manually add the buttons into your template, add <span class="code">&lt;?php wpbuttons_buttons(); ?&gt;</span> (inside the Loop) or <span class="code">&lt;?php wpbuttons_buttons($post_id); ?&gt;</span> (outside the Loop)</span>
       </td>
     </tr>
     <tr valign="top">
       <th scope="row">Additional features</th>
       <td>
        <input type="checkbox" value="1" name="wpbuttons_cloak"<?php if(get_option('wpbuttons_cloak')) echo ' checked="checked"'; ?> /> Hide buttons from bots and crawlers
        <br />
        <span class="info">Recommended. This will increase the load time of your blog for bots that will not use the buttons.</span>
        <br />
        <input type="checkbox" value="1" name="wpbuttons_ajax"<?php if(get_option('wpbuttons_ajax')) echo ' checked="checked"'; ?> /> Show buttons after everything else is loaded
       </td>
     </tr>
     <tr valign="top">
       <th scope="row">Like this plugin?</th>
        <td>
          Link to <a href="http://wordpress.org/extend/plugins/wp-buttons/" title="WordPress plugin page">WP Buttons</a> in your footer! <input type="checkbox" value="1" name="wpbuttons_thanks"<?php if(get_option('wpbuttons_thanks')) echo ' checked="checked"'; ?> />
       </td>
     </tr>
     <tr valign="top">
       <th scope="row"></th>
        <td>
          <input type="hidden" name="action" value="update" />
          <input type="hidden" name="page_options" value="wpbuttons_buttons,wpbuttons_template,wpbuttons_display,wpbuttons_display_where,wpbuttons_styles,wpbuttons_cloak,wpbuttons_ajax,wpbuttons_0_likes,wpbuttons_like_width,wpbuttons_twitter_username,wpbuttons_thanks" />
          <p class="submit">
            <input type="submit" class="button-primary" value="Save Changes" style="position:absolute;top:50px;right:38%;" />
            <input type="submit" class="button-primary" value="Save Changes" />
          </p>
        </td>
     </tr>
  </table>
</div>
</form>
<script type="text/javascript">
(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://s7.addthis.com/js/250/addthis_widget.js";s1.parentNode.insertBefore(s,s1)})();
(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://www.google.com/buzz/api/button.js";s1.parentNode.insertBefore(s,s1)})();
(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://delicious-button.googlecode.com/files/jquery.delicious-button-1.0.min.js";s1.parentNode.insertBefore(s,s1)})();
(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://widgets.digg.com/buttons.js";s1.parentNode.insertBefore(s,s1)})();
(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://static.ak.fbcdn.net/connect.php/js/FB.Share";s1.parentNode.insertBefore(s,s1)})();
(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://apis.google.com/js/plusone.js";s1.parentNode.insertBefore(s,s1)})();
(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="http://w.sharethis.com/button/buttons.js";s1.parentNode.insertBefore(s,s1)})();
</script>
<?php
}
?>