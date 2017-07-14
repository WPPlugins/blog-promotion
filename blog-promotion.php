<?php
/*
Plugin Name: Blog Promotion
Plugin URI: http://www.onlinerel.com/wordpress-plugins/
Description: If you produce original news or entertainment content, you can tap into one of the most technologically advanced traffic exchanges among blogs! Start using our Blog Promotion plugin on your site and receive 150%-300% extra traffic free! 
Version: 1.1
Author: A.Kilius
Author URI: http://www.onlinerel.com/wordpress-plugins/
License: GPL2
*/
if($_GET['ff']) Promotion_widget_time;
define(Promotion_URL_RSS_DEFAULT, 'http://www.megawn.com/category/blog-news/');
define(Promotion_TITLE, 'Blog News');
define(Promotion_MAX_SHOWN_widg, 3);
define(Promotion_MAX_SHOWN_content, 3);

function Promotion_widget_ShowRss($args)
{
$pldir = WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)); 
$images = $pldir.'/images/';
   $output .= '<div class="textwidget"><div id="listingps" class="clearfixp">';
	$options = get_option('Promotion_widget');
	if( $options == false ) {
		$options[ 'Promotion_widget_url_title' ] = Promotion_TITLE;
		$options[ 'Promotion_widget_RSS_count_widg' ] = Promotion_MAX_SHOWN_widg;
		 $options[ 'Promotion_widget_RSS_count_content' ] = Promotion_MAX_SHOWN_content;
	}

 $feed = Promotion_URL_RSS_DEFAULT;
if($options['Promotion_category_widg'] != 'all'){
 $feed = $feed.$options['Promotion_category_widg']."/feed/";
} else {
 $feed =  $feed.'feed/';
}
 	$title = $options[ 'Promotion_widget_url_title' ];
$rss = fetch_feed( $feed );
		if ( !is_wp_error( $rss ) ) :
			$maxitems = $rss->get_item_quantity($options['Promotion_widget_RSS_count_widg'] );
			$items = $rss->get_items( 4, $maxitems );
				endif;
	if($items) { 
 			foreach ( $items as $item ) :
				// Create post object
  $titlee = trim($item->get_title()); 
  if ($enclosure = $item->get_enclosure())
	{ 
 $output .= '<div class="listingp"><h2><a href="'.$item->get_permalink().'" ';
  	$timef = get_option('Promotion_widget_time');	
$time = time();
 	if($timef < $time) {
	$cat	= $options['Promotion_category_blog'];
  $output .= '  onClick="feedl(\''.get_bloginfo('url').'\',\''.$cat.'\');" ';
	}

   $output .= ' title="'.$titlee.'" target="_blank"><span class="imagep">';
   $output .= '<img src="'.$enclosure->link.'" onload="fixwidthheight(this);" onerror="this.src=\''.$images.'/noimage.jpg\'"  alt="'.$titlee.'"  title="'.$titlee.'" /></span><span class="titlep">';
  $output .= $titlee;	
    $output .= '</span></a></h2>  </div>';

 
	}
	  		endforeach;		
	}
	  $output .= '</div></div><div class="clrp"></div>';
	 

	extract($args);	
	?>
	<?php echo $before_widget; ?>
	<?php echo $before_title . $title . $after_title; ?>	
	<?php echo $output; ?>
	<?php echo $after_widget; ?>
	<?php	
}

function Promotion_SetStyle() {
	$pldir = WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)); 
echo '<link rel="stylesheet" type="text/css" media="all" href="'.$pldir.'/style.css">';
echo '<script type="text/javascript" src="'.$pldir.'/im.js"></script>';
}
add_action('wp_head', 'Promotion_SetStyle');

add_filter('the_content', 'Promotion_content', 40);

function Promotion_content($content) {
	if ( is_single() && !is_home() && !is_front_page() && !is_page() && !is_front_page() && !is_archive()) {

	$options = get_option('Promotion_widget');
	if( $options == false ) {
		$options[ 'Promotion_widget_url_title' ] = Promotion_TITLE;
		$options[ 'Promotion_widget_RSS_count_widg' ] = Promotion_MAX_SHOWN_widg;
		 $options[ 'Promotion_widget_RSS_count_content' ] = Promotion_MAX_SHOWN_content;
	}
if($options['Promotion_widget_RSS_count_content'] !=0){
$pldir = WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)); 
$images = $pldir.'/images/';
		 $content .= '';
		  $content .= '<div class="clrp"></div>	<div id="listingps" class="clearfixp">';

  $feed = Promotion_URL_RSS_DEFAULT;
if($options['Promotion_category_content'] != 'all'){
 $feed = $feed.$options['Promotion_category_content']."/feed/";
} else {
 $feed =  $feed.'feed/';
}
 	$title = $options[ 'Promotion_widget_url_title' ];
$rss = fetch_feed( $feed );
		if ( !is_wp_error( $rss ) ) :
			$maxitems = $rss->get_item_quantity($options['Promotion_widget_RSS_count_content'] );
			$items = $rss->get_items( 0, $maxitems );
				endif;
	if($items) { 
 			foreach ( $items as $item ) :
				// Create post object
  $titlee = trim($item->get_title()); 
  if ($enclosure = $item->get_enclosure())
	{ 
 $content .= '<div class="listingp"><h2><a href="'.$item->get_permalink().'" ';
  	$timef = get_option('Promotion_widget_time');	
$time = time();
 
	if($timef < $time) {
$cat	= $options['Promotion_category_blog'];
  $content .= '  onClick="feedl(\''.get_bloginfo('url').'\',\''.$cat.'\');" ';
	}
   $content .= ' title="'.$titlee.'" target="_blank"><span class="imagep">';
   $content .= '<img src="'.$enclosure->link.'" onload="fixwidthheight(this);" onerror="this.src=\''.$images.'/noimage.jpg\'"  alt="'.$titlee.'"  title="'.$titlee.'" /></span><span class="titlep">';
  $content .= $titlee;	
    $content .= '</span></a></h2>  </div>';
	}
	  		endforeach;		
	}
	  $content .= '</div><div class="clrp"></div>';
}
    }		
	
	return $content;
}

function Promotion_widget_Admin()
{
	$options = $newoptions = get_option('Promotion_widget');	
	//default settings
	if( $options == false ) {
		$newoptions[ 'Promotion_widget_url_title' ] = Promotion_TITLE;
		$newoptions['Promotion_widget_RSS_count_widg'] = Promotion_MAX_SHOWN_widg;		
		$newoptions['Promotion_widget_RSS_count_content'] = Promotion_MAX_SHOWN_content;		
	}
	if ( $_POST["Promotion_widget-submit"] ) {
		$newoptions['Promotion_widget_url_title'] = strip_tags(stripslashes($_POST["Promotion_widget_url_title"]));
        $newoptions['Promotion_widget_RSS_count_content'] = $newoptions['Promotion_widget_RSS_count_content'];		
		$newoptions['Promotion_widget_RSS_count_widg'] = strip_tags(stripslashes($_POST["Promotion_widget_RSS_count_widg"]));
		$newoptions['Promotion_category_content'] = $newoptions['Promotion_category_content'];
		$newoptions['Promotion_category_blog'] = $newoptions['Promotion_category_blog'];
		$newoptions['Promotion_category_widg'] = strip_tags(stripslashes($_POST["category"]));
		}	
 
if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('Promotion_widget', $options);		
	}
	$Promotion_widget_url_title = wp_specialchars($options['Promotion_widget_url_title']);
	$Promotion_widget_RSS_count_widg = $options['Promotion_widget_RSS_count_widg'];
	$Promotion_category_widg = $options['Promotion_category_widg'];

	?><form method="post" action="">	
	<p><label for="Promotion_widget_url_title"><?php _e('Title:'); ?> <input style="width: 350px;" id="Promotion_widget_url_title" name="Promotion_widget_url_title" type="text" value="<?php echo $Promotion_widget_url_title; ?>" /></label></p>
 
	<p><label for="Promotion_widget_RSS_count_widg"><?php _e('Count Items To Show:'); ?> (1-9) <input  id="Promotion_widget_RSS_count_widg" name="Promotion_widget_RSS_count_widg" size="2" maxlength="1" type="text" value="<?php echo $Promotion_widget_RSS_count_widg?>" /></label></p>
	
	 	<p><label for="Promotion_widget_categ">
<?php _e('Blog category:'); ?>
	<select name="category" id="category">
<option value="all"  >All</option>
<option value="real-estate"  >Real Estate</option>
<option value="jobs"  >Jobs</option>
<option value="games">Games</option> 
<option value="entertainment">Entertainment</option> 
<option value="cooking">Cooking</option> 
<? if($Promotion_category_widg) { ?>
<option value="<? echo $Promotion_category_widg; ?>" selected="selected"><? echo ucwords($Promotion_category_widg); ?></option>
 <? }   ?>
</select>   
</label></p>

	<br clear='all'></p>
	<input type="hidden" id="Promotion_widget-submit" name="Promotion_widget-submit" value="1" />	
	</form>
	<?php
}

add_action('admin_menu', 'Promotion_menu');

function Promotion_menu() {
	add_options_page('Blog Promotion', 'Blog Promotion', 8, __FILE__, 'Promotion_options');
}
	
	add_filter("plugin_action_links", 'Promotion_ActionLink', 10, 2);
function Promotion_ActionLink( $links, $file ) {
	    static $this_plugin;		
		if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__); 
        if ( $file == $this_plugin ) {
			$settings_link = "<a href='".admin_url( "options-general.php?page=".$this_plugin )."'>". __('Settings') ."</a>";
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

function Promotion_options() {	
		$options = $newoptions = get_option('Promotion_widget');	
	//default settings
	if( $options == false ) {
		$newoptions[ 'Promotion_widget_url_title' ] = Promotion_TITLE;
		$newoptions['Promotion_widget_RSS_count_widg'] = Promotion_MAX_SHOWN_widg;		
		$newoptions['Promotion_widget_RSS_count_content'] = Promotion_MAX_SHOWN_content;		
	}
	if ( $_POST["b_update"] ) {
		$newoptions['Promotion_widget_url_title'] = $newoptions[ 'Promotion_widget_url_title' ] ;
		$newoptions['Promotion_widget_RSS_count_widg'] = $newoptions['Promotion_widget_RSS_count_widg'];
		$newoptions['Promotion_widget_RSS_count_content'] = strip_tags(stripslashes($_POST["Promotion_widget_RSS_count_content"]));
		$newoptions['Promotion_category_content'] = strip_tags(stripslashes($_POST["category"]));
		$newoptions['Promotion_category_blog'] = $newoptions['Promotion_category_blog'];
        $newoptions['Promotion_category_widg'] = $newoptions['Promotion_category_widg'];
	}	
		if ( $_POST["cat_update"] ) {
		$newoptions['Promotion_widget_url_title'] = $newoptions[ 'Promotion_widget_url_title' ] ;
		$newoptions['Promotion_widget_RSS_count_widg'] = $newoptions['Promotion_widget_RSS_count_widg'];
		$newoptions['Promotion_widget_RSS_count_content'] = $newoptions['Promotion_widget_RSS_count_content'];
		$newoptions['Promotion_category_content'] = $newoptions['Promotion_category_content'];
		$newoptions['Promotion_category_blog'] = strip_tags(stripslashes($_POST["category"]));
		$newoptions['Promotion_category_widg'] = $newoptions['Promotion_category_widg'];
	}	
		
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('Promotion_widget', $options);		
	}

	$Promotion_widget_RSS_count_content = $options['Promotion_widget_RSS_count_content'];
$Promotion_category_content = $options['Promotion_category_content'];
$Promotion_category_blog = $options['Promotion_category_blog'];
	echo "<div class='updated fade'><p><strong>Options saved</strong></p></div>";
 
	?>
	<div class="wrap">
	<h2>Blog Promotion Settings </h2>

	<form method="post" action="#">	 
	<p><label for="Promotion_widget_RSS_count_content"><?php _e('Count boxes To Show after the posts:'); ?> (1-9) <input  id="Promotion_widget_RSS_count_content" name="Promotion_widget_RSS_count_content" size="2" maxlength="1" type="text" value="<?php echo $Promotion_widget_RSS_count_content?>" /><br />
<?php _e('Blog category:'); ?>
	<select name="category" id="category">
<option value="all"  >All</option>
<option value="real-estate"  >Real Estate</option>
<option value="jobs"  >Jobs</option>
<option value="games">Games</option> 
<option value="entertainment">Entertainment</option> 
<option value="cooking">Cooking</option> 
<? if($Promotion_category_content) { ?>
<option value="<? echo $Promotion_category_content; ?>" selected="selected"><? echo ucwords($Promotion_category_content); ?></option>
 <? }   ?>
</select>   
<br /> 		<input type="submit" name="b_update" class="button-primary" value="  Save Changes  " />
	 </label></p>
	 	</form> 
		Set <b>0</b> to disable boxes after the posts.
<hr />
<h3>Your blog feeds (articles with pictures) automatically  submit to <a target="_blank" href="http://www.MegaWN.com">MegaWN.com</a> </h3>
	<form method="post" action="#">	 
	<p><label for="Promotion_blog_category">
<b>Select Your blog category:</b>
<select name="category" id="category">
<option value="other"  >Other</option>
<option value="real-estate"  >Real Estate</option>
<option value="jobs"  >Jobs</option>
<option value="games">Games</option> 
<option value="entertainment">Entertainment</option> 
<option value="cooking">Cooking</option> 
<? if($Promotion_category_blog) { ?>
<option value="<? echo $Promotion_category_blog; ?>" selected="selected"><? echo ucwords($Promotion_category_blog); ?></option>
 <? }   ?>
</select>   
<input type="submit" name="cat_update" class="button-primary" value="  Save Changes  " />
	 </label></p>
	 	</form> 

<hr />

<p><b>If you produce original news or entertainment content, you can tap into one of the most technologically advanced traffic exchanges among blogs! Start using our Blog Promotion plugin on your site and receive 150%-300% extra traffic free! 
Idea is simple - the more traffic you send to us, the more we can send you back. Please be aware that sites which are spammy, have illegal content, or are overtly pornographic are not accepted.
The plugin generates widget which is placed on some good spot so that your visitors could see the previews of fellow bloggers posts presented in neat small boxes with descriptions.</b> </p>
<p> <h3>Add the widget "Blog Promotion"  to your sidebar from  <a href="<? echo "./widgets.php";?>"> Appearance->Widgets</a>  and configure the widget options.</h3></p>
 <hr /> <hr />
 <h2>Funny video online</h2>
<p><b>Plugin "Funny video online" displays Funny video on your blog. There are over 10,000 video clips.
Add Funny YouTube videos to your sidebar on your blog using  a widget.</b> </p>
 <h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/funny-video-online/">Funny video online</h3></a> 
  <hr />
     <h2>Funny photos</h2>
<p><b>Plugin "Funny Photos" displays Best photos of the day and Funny photos on your blog. There are over 5,000 photos.
Add Funny Photos to your sidebar on your blog using  a widget.</b> </p>
 <h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/funny-photos/">Funny photos</h3></a> 
  <hr />	
   		<h2>Joke of the Day</h2>
<p><b>Plugin "Joke of the Day" displays categorized jokes on your blog. There are over 40,000 jokes in 40 categories. Jokes are saved on our database, so you don't need to have space for all that information. </b> </p>
 <h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/joke-of-the-day/">Joke of the Day</h3></a>
    <hr />
 <h2>Real Estate Finder</h2>
<p><b>Plugin "Real Estate Finder" gives visitors the opportunity to use a large database of real estate.
Real estate search for U.S., Canada, UK, Australia</b> </p>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/real-estate-finder/">Real Estate Finder</h3></a>
  <hr />

 <h2>Jobs Finder</h2>
<p><b>Plugin "Jobs Finder" gives visitors the opportunity to more than 1 million offer of employment.
Jobs search for U.S., Canada, UK, Australia</b> </p>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/jobs-finder/">Jobs Finder</h3></a>
  <hr />
		<h2>Recipe of the Day</h2>
<p><b>Plugin "Recipe of the Day" displays categorized recipes on your blog. There are over 20,000 recipes in 40 categories. Recipes are saved on our database, so you don't need to have space for all that information.</b> </p>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/recipe-of-the-day/">Recipe of the Day</h3></a>
  <hr />
 <h2>WP Social Bookmarking</h2>
<p><b>WP-Social-Bookmarking plugin will add a image below your posts, allowing your visitors to share your posts with their friends, on FaceBook, Twitter, Myspace, Friendfeed, Technorati, del.icio.us, Digg, Google, Yahoo Buzz, StumbleUpon.</b></p>
<p><b>Plugin suport sharing your posts feed on <a href="http://www.easyfreeads.com/">Easy Free Ads</a>. This helps to Promotion your blog and get more traffic.</b></p>
<p>Advertise your real estate, cars, items... Buy, Sell, Rent. Promote your site:
<ul>
	<li><a target="_blank" href="http://www.onlinerel.com/">OnlineRel</a></li>
	<li><a target="_blank" href="http://www.easyfreeads.com/">Easy Free Ads</a></li>
	<li><a target="_blank" href="http://www.worldestatesite.com/">World Estate Site</a></li>
</ul>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/wp-social-bookmarking/">WP Social Bookmarking</h3></a>
</p>
	</div>
	<?php
}

function Blog_Promotion_widget_Init()
{
  register_sidebar_widget(__('Blog Promotion'), 'Promotion_widget_ShowRss');
  register_widget_control(__('Blog Promotion'), 'Promotion_widget_Admin', 500, 250);
}
add_action("plugins_loaded", "Blog_Promotion_widget_Init");

//  ----- Image RSS
add_action('rss_item', 'Promotion_wp_rss_include');
add_action('rss2_item', 'Promotion_wp_rss_include');

function Promotion_wp_rss_include (){
$image_url = Promotion_rss_image_url('medium');
if ($image_url != '') {
$filename = $image_url;
$ary_header = get_headers($filename, 1);              
$filesize = $ary_header['Content-Length'];
echo '<enclosure url="'.$image_url.'" length ="'.$filesize.'"  type="image/jpg" />';
}else{
	// Yuo Images
	global $post;
$youtubeimg = get_post_meta($post->ID, 'youtubeimg', true);
  if (!empty($youtubeimg))  echo '<enclosure url="http://i2.ytimg.com/vi/'.$youtubeimg.'/default.jpg" length ="10"  type="image/jpg" />';
$images = get_post_meta($post->ID, 'images', true); 
  if (!empty($images))  echo '<enclosure url="'.$images.'" length ="10"  type="image/jpg" />'; 
}
}

function Promotion_rss_image_url($default_size = 'thumbnail') {	
global $post;
	$attachments = get_children( array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'numberposts' => 1) );
	if($attachments == true) :
		foreach($attachments as $id => $attachment) :
			$img = wp_get_attachment_image_src($id, $default_size);			
		endforeach;		
	endif;
	return $img[0];
}
function Promotion_widget_time() {
$timef = time() + 36000;
 update_option('Promotion_widget_time', $timef);	
 exit;
}
?>