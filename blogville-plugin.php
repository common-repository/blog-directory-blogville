<?php
/*
Plugin Name: blogville-directory-plugin
Plugin URI: http://blogville.us/plugin/
Description: This plugin will update the blogville directory to display when your blog was updated.
Version: 0.1
Author: Blogville
Author URI: http://blogville.us/
*/

/*
	POST VARIABLES:
	$_POST['blog_url']  -  url of the blog
	$_POST['post_time']  - post publish time stamp  (php function time() used) 
*/

/*
	Set external page url
 */
$hivista_post_url = 'http://blogville.us/plugin/p.php';

add_action('publish_post', 'send_hivista_post_data');

/*
	If You want to use this plugin for Pages too (not only for Posts)  uncomment next line
*/ 
//add_action('publish_page', 'send_hivista_post_data');


function send_hivista_post_data($post){
	global $hivista_post_url;

	// publish post ID
	$post_id = $post;	
	// get post
	$this_post = get_post($post_id); 
	
	$post_date = $this_post->post_date;
	$post_modified = $this_post->post_modified;
	
	// checking if it is first publish
	if($post_date != $post_modified){
		return;
	}
	
	$blog_url = get_option('siteurl');
	$post_time = time();

	
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $hivista_post_url);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  
  // our variables
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'blog_url='.$blog_url.'&post_time='.$post_time);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

  $data = curl_exec($ch);
  curl_close($ch);	
}

?>