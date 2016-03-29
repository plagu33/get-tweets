<?php
//define('WP_DEBUG', true);

require "libraries/twitter/twitteroauth.php";

$consumer_key        = '';
$consumer_secret     = '';
$access_token	     = ''; // Optional
$access_token_secret = ''; // Optional

$connection = new TwitterOAuth($consumer_key,$consumer_secret, $access_token, $access_token_secret);

$exclude = '-filter:retweets'; /*no retweets*/

/*THIS*/
$params  = array('screen_name' =>'mmerino');
$statuses = $connection->get("statuses/user_timeline", $params);

/*OR*/
$params  = array('q' =>'#hashtag');
$statuses = $connection->get("search/tweets", $params);

echo "<pre>";
print_r($statuses);

foreach ($statuses as $key)
{

	$type              = @$key->entities->media[0]->type;
	$profile_image_url = $key->user->profile_image_url_https;
	$image             = @$key->entities->media[0]->media_url;

	if( is_null($type) ) $type = "text";
	if( is_null($profile_image_url) ) $profile_image_url = "";
	if( is_null($image) ) $image = "";

	//$created_at      = $key->created_at;
	$id_str            = $key->id_str;
	$text              = $key->text;
	$username          = $key->user->name;
	$screen_name       = $key->user->screen_name;

	//saveTweets($screen_name,$profile_image_url,$text,$id_str,$username,$image,$type);

}

/*
function saveTweets($screen_name,$profile_image_url,$text,$id_str,$username,$image,$type)
{
	global $wpdb;

	$cantidad = $wpdb->get_var( "SELECT COUNT('id') FROM {$wpdb->prefix}tweets where tw_id_tweet=".$id_str );

	if( $cantidad==0 && $screen_name!="" )
	{

		$wpdb->insert( 
			$wpdb->prefix.'tweets', 
			array( 
				'tw_usuario' => "@".$screen_name,
				'tw_texto' => $text,
				'tw_tipo' => $type,
				'tw_id_tweet' => $id_str,
				'tw_imagen_usuario' => $profile_image_url,
				'tw_url_imagen' => $image,
				'tw_estado' => 0,
				'tw_origen' => "tw"
			), 
			array( 
				'%s', 
				'%s', 
				'%s', 
				'%s', 
				'%s', 
				'%s', 
				'%d',
				'%s'
			) 
		);

	}

}
*/

?>
