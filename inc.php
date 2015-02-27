<?php

class RecoTwPlaceholder
{
  static public function get_tweet_all ()
  {
    $ins = new self;
    
  }
  
  static public function user_tweet ()
  {
    $ins = new self;

  }
  
  static public function record_tweet ()
  {
    
  }
  
  static public function count_tweet ()
  {
    $ins = new self;

  }
  
  static public function not_found ()
  {
    $ins = new self;

  }
  
  private function __construct ()
  {
    
  }

  private function is_post ()
  {
    if ( $_SERVER["REQUEST_METHOD"] === 'POST' )
      return true;
    return false;
  }

  private function get_query_item ($name, $default = null)
  {
    if( isset( $_GET[$name]) )
      return $_GET[$name];
    return $default;
  }
  
  private function get_post_item ($name, $default = null)
  {
    if( isset( $_POST[$name] ))
      return $_POST[$name];
    return $default;
  }

  private function is_ssl ()
  {
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on')
      return true;
    // if your server isn't set ENV[HTTPS], you must override this method!
    // 
    return false;
  }
    

  
}