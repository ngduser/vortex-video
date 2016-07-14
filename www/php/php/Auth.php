<?php
include "header.php";
include "basePage.php";
// 30 minute session lengths
$maxSessionLength = 30 * 60;
$now = time();

if ($_POST['logout']) {
    $_SESSION = array();
    session_destroy();
    // Create the appropriate page
    userLogout();
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (validPass($username, $password) == True) {
        $infoArray = retrieveUserInfo($username);

        // Creates session variables from the database
        foreach ($infoArray as $key => $value) {
            $_SESSION[$key] = $value;
        }

        $_SESSION['username'] = $username;
        $_SESSION['discard_after'] = $now + $maxSessionLength;
        // Create the appropriate page
        successfulLogin();
    } else {
        failedLogin();
    }
}

function validPass($username, $pass) {
  include_once 'DBCommands.php';

  $conn = createConnection();
  $passQuery = "SELECT password FROM UserAccounts WHERE username=?";
  $stmt = $conn->prepare($passQuery);

  if ($stmt === FALSE) {
      die ("Mysql Error: " . $conn->error);
  } else {
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->bind_result($hashPass);
      $stmt->fetch();
      $stmt->close();
  }

  if (password_verify($pass, $hashPass)) {
    $conn->close();
    return True;
  } else {
    $conn->close();
    return False;
  }
}

function retrieveUserInfo($username) {
    include_once 'DBCommands.php';

    $conn = createConnection();
    $userQuery = "SELECT id, username FROM UserAccounts WHERE username=?";
    $stmt = $conn->prepare($userQuery);

    if ($stmt === FALSE) {
        die ("Mysql Error: " . $conn->error);
    } else {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($uID, $uN);
        while ($stmt->fetch());
        $stmt->close();

        $userInfo = array("userID" => $uID,
                          "username" => $uN);
    }
    
    return $userInfo;
}

function userLogout() {
    $heading = "Logged out";
    $para = "Thanks for visiting!";
    basePage($heading, $para);
}

function failedLogin() {
    $heading = "Login Unsuccessful";
    $para = "Please try <a href='./login'>again</a>.";
    basePage($heading, $para);

}

function successfulLogin() {
    $heading = "Thanks for logging in, " . $_SESSION['username'];
    $para = "Head over to the <a href='/'>Home Page</a> to check out some videos";
    basePage($heading, $para);
}

?>
