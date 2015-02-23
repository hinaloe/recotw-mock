<?php
error_reporting(E_ALL);
  require_once(__DIR__."/inc.php");
  $uri = strtok($_SERVER['REQUEST_URI'],'?');
  
  
  switch ($uri) {
    case '/1/tweet/get_tweet_all':
      RecoTwPlaceholder::get_tweet_all();
      break;
      
    case '/1/tweet/user_tweet':
      RecoTwPlaceholder::user_tweet();
      break;
      
    case '/1/tweet/record_tweet':
      RecoTwPlaceholder::record_tweet();
      break;
      
    case '/1/tweet/count':
      RecoTwPlaceholder::count_tweet();
      break;
    
    default:
      RecoTwPlaceholder::not_found();
      break;
  }