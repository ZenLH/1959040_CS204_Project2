<?php
    $USER_AVA = "images/users/anonymousUser.png";
    $errors = [];
    if(isset($_POST['login'])) {
        // process the login form, pass the post, errors (by ref) and db CONN
        $username = $_POST['name'];
        $pass = $_POST['pass'];
        checkLogin($errors, $conn, $username, $pass);
      } 
    else if (isset($_POST['signup'])) {
          // process the create form, pass the post, errors (by ref) and db CONN
          $username = $_POST['name'];
          $email = $_POST['email'];
          $pass = $_POST['pass'];
          $pass1 = $_POST['pass1'];
        checkCreate($errors, $conn, $username, $email, $pass, $pass1);
    }

function checkCreate(&$errors, $conn, $username, $email, $pass, $pass1){
    // $username = $_POST['name'];
    // $email = $_POST['email'];
    // $pass = $_POST['pass'];
    // $pass1 = $_POST['pass1'];
    if(!minmaxChars($username, 5, 20)) {
        $errMsg = "Username must be between 5-20 characters long!";
        $errors['signup_username'] = $errMsg;
      }
    else if (checkUsername($username, $conn) == 1) {
        $errMsg = "Username already take!";
        $errors['signup_username'] = $errMsg;
    }

    // validate email, should add sanitation as well
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errMsg = "Invalid email!";
    $errors['signup_email'] = $errMsg;
  }
  // check pw length and matching
  if(!minmaxChars($pass, 5)) {
    $errMsg = "Password is too short";
    $errors['signup_pass'] = $errMsg;
  }
  else if($pass1 != $pass){
    $errMsg = "Passwords do not match!";
    $errors['sigup_pass1'] = $errMsg;
  }

  // if there are no errors, insert the user into the db and login
  if(empty($errors)) {
    $user_id = createUser($conn, $username, $email, $pass);
    $user_ava = "images/users/anonymousUser.png";
    if($user_id != 0) {
      loginUser($username, $user_id, 2, $user_ava, $email);
    }
  }
}

function createUser($conn, $user_name, $user_email, $user_password) {
    $user_hash = password_hash($user_password, PASSWORD_DEFAULT);
    $user_ava = "images/users/anonymousUser.png";
    $sql = "INSERT INTO users (user_ava, user_name, user_email, user_hash) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss",$user_ava, $user_name, $user_email, $user_hash);
    $stmt->execute();
    //var_dump($stmt);
    if($stmt->affected_rows == 1) {
      return $stmt->insert_id;
    } else {
      return 0;
    }
  }

function minmaxChars($string, $min, $max = 1000) {
    if(strlen($string)< $min || strlen($string) > $max) {
      return false;
    } else {
      return true;
    }
  }


function checkLogin(&$errors, $conn, $userName, $pass){
    // $userName = $_POST['name'];
    // $pass = $_POST['password'];
    if(checkUsername($userName, $conn) != 1){
        $errMsg = "User not found!";
        $errors['login_username'] = $errMsg;
    }
    else{
        $user_info = getUserInfo($userName, $conn);
        if(!password_verify($pass, $user_info['user_hash'])){
            $errMsg = "Incorrect password";
            $errors['login_password'] = $errMsg;
        }
    }

    if(empty($errors)) {
        loginUser($user_info['user_name'], $user_info['ID'], $user_info['user_role'], $user_info['user_ava'], $user_info['user_email']);
      }
}

function checkUsername($name, $conn){
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}

function getUserInfo($name, $conn){
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}



function loginUser($user_name, $user_id, $user_role, $user_ava, $user_email) {
    //1 for admin; 2 for user
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_role'] = $user_role;
    $_SESSION['user_ava']  = $user_ava;
    $_SESSION['user_email'] = $user_email;

    header("Location: index.php?login=success");
}
?>