<?php

class RecoTwPlaceholder
{

  private $headers = [];
  private $body;
  private $response_code;

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

    $ins = new self;
    // if ($ins->is_options() && ! count($_POST) )
    // {
    //   header('Access-Control-Allow-Origin:*');
    //   return;
    // }
    // elseif ($ins->is_post())
    // {
    //   header('Access-Control-Allow-Origin:*');
    //   echo(json_encode($_POST));
    // }
  }

  static public function count_tweet ()
  {
    $ins = new self;

  }

  static public function not_found ()
  {
    $ins = new self;
    $ins -> set_response_code(404);
    $ins -> send(array('type'=>'html'));
    echo "404 Not found";

  }

  static public function tana3n ()
  {
    $ins = new self;
    if( $ins->is_gay ('tana3n') )
    {
      // this attr will be override
      $ins-> add_header("Arrow_GAY","tana3n");
      // this attr will send
      $ins-> add_header("Arrow_GAY","*");
      // header remove
      $ins-> add_header("will_be_remove","yo");
      $ins-> remove_header("will_be_remove");
      $ins-> remove_header("undefined_header");

      // remove only same name
      $ins-> add_header("wont_remove","Live");
      $ins-> add_header("will_remove","die");
      $ins-> remove_header("wont_remove","die");
      $ins-> remove_header("will_remove","die");

      // method chain
      $ins-> add_header("age","17")
        -> add_header("smile","yes")
        -> remove_header("age");

      // when, send multi samename header
      $ins-> add_header("tana3n",["gay","tana3n"]);

      $body = array(
        'type'=>'json',
        'body'=> array(
          'content' => 'tana3n is gay'
        )
      );

      $ins-> send($body);
      // $ins-> send_headers();
      // this is now placeholder for test.
      // @todo response same as other
      // echo "tana3n is gay";
    }
  }

// core


  private function add_header($key, $value)
  {
    $this->headers[$key] = $value;
    return $this;
  }

  private function send_headers($header = null, $replace = true)
  {
    if(is_null($header))
    {
      $header = $this->headers;
      if(is_int($this-> response_code))
      {
        http_response_code ($this-> response_code);
      }
    }
    if(!is_array($header))
      return;
    foreach($header as $key => $value)
    {
      if(is_string($key) && is_string($value) )
      {
        header("${key}: $value", $replace);
      }
      elseif (is_string($key) && is_array($value))
      {
        foreach($value as $v)
        {
          $this->send_headers(array($key=>$v),false);
        }
      }
    }
    return $this;
  }

  private function remove_header($key,$value = null)
  {
    if(is_null($value))
    {
      unset($this->headers[$key]);
    }
    else
    {
      if(!empty($this->headers[$key]) && is_string($this->headers[$key]) && $this->headers[$key] === $value)
      {
        unset($this->headers[$key]);
      }
      elseif(!empty($this->headers[$key]) && is_array($this-> headers[$key]))
      {
        foreach($this-> headers[$key] as $k => $v)
        {
          if($v===$value)unset($this-> headers[$key][$k]);
        }
      }
    }
    return $this;
  }

  private function set_response_code ( $code )
  {
    if (!is_int($code))
    {
      throw new InvalidArgumentException ("Invalid response code");
    }
    $this-> response_code = $code;
    return $this;
  }


  private function send ($options)
  {

    if($options["type"] === 'json' )
    {
      $this-> add_header("Content-Type","application/json; charset=UTF-8");
      $this-> send_headers();
      $this-> render_json($options["body"]);
    }
    else if($options["type"] === 'html')
    {
      $this-> add_header("Content-Type","text/html; charset=UTF-8");
      $this-> send_headers();
      $this-> render_html($options);

    }


  }


  private function render_html ()
  {

  }

  private function render_json ($data)
  {
    echo json_encode($data);
  }



// conditon

  private function is_gay($who)
  {
    if($who === 'tana3n')
      return true;
    return false;
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

  private function is_options ()
  {
    if ( $_SERVER["REQUEST_METHOD"] === 'OPTIONS' )
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
