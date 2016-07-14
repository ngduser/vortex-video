<?php
class UserAccount {

  private $username = "";
  private $password = "";
  private $sqlStatement = "INSERT INTO UserAccounts VALUES (NULL, ?, ?)";

  function __construct($uN, $pW) {
    $this->username = $uN;
    $this->password = password_hash($pW, PASSWORD_BCRYPT);
  }

  public function insertIntoDB(&$mysqli) {
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }

    $stmt = $mysqli->prepare($this->sqlStatement);
    if ($stmt === FALSE) {
      return FALSE;
    }

    if ($stmt) {
      $stmt->bind_param("ss", $uN, $pW);
      $uN = $this->username;
      $pW = $this->password;

      if (!$stmt->execute()) {
        if ($mysqli->errno === 1062) {
          return "F1062";
        } else {
          return TRUE;
        }
      }
      $lastID = $mysqli->insert_id;

      $stmt->close();
      return TRUE;
    }
  }
}

?>
