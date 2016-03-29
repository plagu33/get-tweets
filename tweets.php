<?php
//define('WP_DEBUG', true);

require "libraries/twitter/twitteroauth.php";

$consumer_key        = 'UzN3pdkkYjcyRal2Z1vrw';
$consumer_secret     = 'x1iLlMdUnngfWjsA950uvq1v3yqMXmoXvWivlQQ';
$access_token	     = '800680400-Hf1zg5pOhXLcLaq2wFkoLpIYArVX9sYna1pTSsWF'; // Optional
$access_token_secret = 'JL4gvW8FY3tDZEqZmzpTWziBU9QXAJjK6a0KEuB1xg8ab'; // Optional

$connection = new TwitterOAuth($consumer_key,$consumer_secret, $access_token, $access_token_secret);

$exclude = '-filter:retweets'; /*no retweets*/
$params  = array('screen_name' =>'mmerino');
//$statuses = $connection->get("search/tweets", $params)->statuses;
$statuses = $connection->get("statuses/user_timeline", $params);

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