<?php
if(!defined('TANA3NISGAY'))
{
  http_response_code( 403 );
  echo 'Forbidden';
}

class RecoTwEntritesModel
{

  private  $db;

  private  $db_path;
  private  $name = 'tweets';

  function __construct ()
  {
    $db_path = TANA3NISGAY . '/../data/tweets.db';


    $this-> db = new SQLite3( $db_path );
    // migrate
    $this-> exec ( sprintf ( 'CREATE TABLE IF NOT EXISTS %s (id INTEGER PRIMARY KEY,tweet_id TEXT,content TEXT,target_id TEXT,target_sn TEXT,record_date TEXT)' , $this->name ) );
  }

  function close ()
  {
    $this->db->close();
  }

  private function query_user_tweet ($screen_name)
  {
    $sql = sprintf( 'SELECT * FROM %s where target_sn = :name' ,$this->name);
    $stmt = $this->db-> prepare($sql);
    $stmt-> bindValue(':name',$screen_name);
    $result = $stmt -> execute();
    return $result->fetchArray();
  }

  private function query_tweet_count ()
  {
    $sql = sprintf( 'SELECT COUNT (*) from %s' , $this->name );
    $stmt = $this->db -> prepare($sql);
    $result = $stmt-> execute();
    return $result->fetchArray(SQLITE3_ASSOC)['COUNT (*)'];

  }
}
