<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * logon Template
 * Template Name: Login
 *
 * @file           login.php
 * @package        NotTrips
 * @author         Suniel Sambasivan
 * @copyright      2015 - 2016 Suniel Sambasivan
 */

/*  $client_id = CLIENT_KEY;
 $client_secret = CLIENT_SECRET; */

 $url = site_url() . OAUTH_QUERY_STRING . CLIENT_KEY;

 $code = false;
 if(isset($_GET['code'])) {
     $code = $_GET['code'];
 }
 
 
 // If there is no code present, first get the code by redirecting to login page
 if(!$code) {
  header('Location: ' . $url);
  die();
 
 } else {
     // Encode the client ID and secret with base64 in 
     // order to add it to the Authorization header
     $auth = base64_encode(CLIENT_KEY.':'.CLIENT_SECRET);
     try {
 
         // Making the Call to get the access token
         $args = [
             'headers' => [
                 'Authorization' => 'Basic ' . $auth
             ],
             'body' => [
                 'grant_type'    => 'authorization_code',
                 'code'          => $code
             ],
        ];
 
        // Send the actual HTTP POST with the built-in WordPress HTTP library.
        $json = wp_remote_post( site_url() . '?oauth=token', $args );
        
        if(is_array($json) && isset($json['body'])) {

            $json = json_decode($json['body']);
            
            // Retrieve the access token from the response
            $auth_token = $json->access_token;
            $user_id = get_current_user_id();
        
            // Save the cookie to user meta
            // Can be useful for debugging or if needed to refresh the cookie
            update_user_meta($user_id, 'wordpress_access_token', $auth_token);
        } else {
            print_r($json);
            die();
        }
 
         // All set, redirect to the home page
         header('Location: ' . site_url());
     } catch (Exception $e) {
         var_dump($e);
     }
  }