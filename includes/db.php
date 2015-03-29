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
    $this-> exec ( sprintf ( 'CREATE TABLE IF NOT EXISTS %s (id INTEGER PRIMARY KEY AUTOINCREMENT,tweet_id TEXT,content TEXT,target_id TEXT,target_sn TEXT,record_user TEXT,record_date TIMESTAMP DEFAULT (DATETIME(\'now\',\'localtime\')))' , $this->name ) );
  }

  function close ()
  {
    $this->db->close();
  }

  private function query_user_tweet ($screen_name)
  {
    $sql = sprintf( 'SELECT * FROM %s where target_sn = :name' ,$this->name);
    $i = 0;
    $res = [];
    $stmt = $this->db-> prepare($sql);
    $stmt-> bindValue(':name',$screen_name);
    $result = $stmt -> execute();
    while($row = $result->fetchArray())
    {
      $res[$i] = $row;
      $i++;
    }
    return $res;
  }

  private function query_all_tweet ()
  {
    $sql = sprintf( 'SELECT * FROM %s ' ,$this->name);
    $i = 0;
    $res = [];
    $stmt = $this->db-> prepare($sql);
    $result = $stmt -> execute();
    while($row = $result->fetchArray())
    {
      $res[$i] = $row;
      $i++;
    }
    return $res;
  }


  private function query_tweet_count ()
  {
    $sql = sprintf( 'SELECT COUNT (*) from %s' , $this->name );
    $stmt = $this->db -> prepare($sql);
    $result = $stmt-> execute();

    return $result->fetchArray(SQLITE3_NUM)[0];

  }

  private function query_insert_content ( $content, $tweet_id, $target_id, $target_sn, $record_user )
  {
    $sql = sprintf( 'INSERT INTO %s (content,tweet_id,target_id,target_sn,record_user) VALUES (:content,:tweet_id,:target_id,:twrget_sn,:record_user)' , $this->name );
    $stmt = $this->db-> prepare($sql);
    $stmt-> bindValue(':content', $content);
    $stmt-> bindValue(':tweet_id', $tweet_id);
    $stmt-> bindValue(':target_id', $target_id);
    $stmt-> bindValue(':target_sn', $target_sn);
    $stmt-> bindValue(':record_user', $record_user);

    $stmt-> execute ();
  }

  private function query_search_by_tweet_id ($tweet_id)
  {
    $sql = sprintf( 'SELECT * FROM %s where tweet_id = :tweet_id' ,$this->name );
    $stmt = $this->db-> prepare($sql);
    $stmt-> bindValue(':tweet_id', $tweet_id);

    $stmt-> execute ();
    return $result->fetchArray();

  }

  private function query_delete_by_id ($id)
  {
    if(filter_var($id,FILTER_VALIDATE_INT) === false)
    {
      throw new InvalidArgumentException('the ID is not int.');
    }
    $sql = printf ( 'DELETE FROM %s where id = :id' , $this->name);
    $stmt = $this->db-> prepare($sql);
    $stmt-> bindValue (':id', $id, SQLITE3_INTEGER);
    $stmt-> execute();
    return;
  }
}
