<?php

function getDBparams() {
  $trimmed = file('params/dbparams.txt', FILE_IGNORE_NEW_LINES |
                  FILE_SKIP_EMPTY_LINES);
  $key = array();
  $vals = array();
  foreach ($trimmed as $line) {
    $pairs = explode("=", $line);
    $key[] = $pairs[0];
    $vals[] = $pairs[1];
  }
  $mypairs = array_combine($key,$vals);

  $myDBparams = new DbparamsClass($mypairs['username'],$mypairs['password'],
                                  $mypairs['host'], $mypairs['db']);
  return $myDBparams;
}

function createConnection() {
  $myDBparams = getDBparams();

  $mysqli = new mysqli($myDBparams->getHost(), $myDBparams->getUsername(),
                       $myDBparams->getPassword(), $myDBparams->getDB());
  if ($mysqli->connect_error) {
    die("Connect Error (" . $mysqli->connect_errno . ") " .
        $mysqli->connect_error);
  }
  $mysqli->autocommit(TRUE);
  return $mysqli;
}

class DbparamsClass {
  private $username="";
  private $password="";
  private $host="";
  private $db="";

  public function __construct($myusername, $mypassword, $myhost, $mydb) {
    $this->username = $myusername;
    $this->password = $mypassword;
    $this->host     = $myhost;
    $this->db       = $mydb;
  }

  // Getters
  public function getUsername() {
    return $this->username;
  }
  public function getPassword() {
    return $this->password;
  }
  public function getHost() {
    return $this->host;
  }
  public function getDB() {
    return $this->db;
  }

  // Setters
  public function setUsername($myusername) {
    $this->username = $myusername;
  }
  public function setPassword($mypassword) {
    $this->password = $mypassword;
  }
  public function setHost($myhost) {
    $this->host = $myhost;
  }
  public function setDB($mydb) {
    $this->db = $mydb;
  }

}
?>
