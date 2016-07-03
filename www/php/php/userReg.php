<?php
require_once './DBCommands.php';
require_once './UserAccount.php';
include './header.php';
include_once './basePage.php';

if ($_POST['register'] != null) {
  $conn = createConnection();

  $username = $_POST['username'];
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];

  if ($pass1 != $pass2) {
    $message = "The entered passwords did not match. Please try
                <a href='./register'>again.</a>";
  } else {
      $newUser = new UserAccount($username, $pass1);
      $result = $newUser->insertIntoDB($conn);

      if ($result === TRUE) {
        $heading = "Registration successful.";
        $para = "Test out your credentials <a href='/login'>here</a>.";
        basePage($heading, $para);
        $success = TRUE;
      } elseif ($result === "F1062") {
        $message = "That username has already been registered.";
        $para = "Please try again <a href='/register'>here</a>.";
        $success = FALSE;
        basePage($heading, $para);
      } else {
        $message = "Something went wrong!";
        $para = "Contact the site's administrators.";
        $success = FALSE;
        basePage($heading, $para);
      }
  }
}
?>
