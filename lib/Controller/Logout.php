<?php

namespace MyApp\Controller;

class Logout extends \MyApp\Controller {

  public function __construct() {

  //   $_SESSION = [];
  //   if(isset($_COOKIE[session_name()])) {
  //     setcookie(session_name(), '', time() - 86400, '/');
  //   }

  //   session_destroy();
  // }


  // var_dump($_SESSION);
  $_SESSION = array();
    // var_dump($_SESSION);
    // var_dump(ini_get("session.use_cookies"));
  if(ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    // var_dump($params);
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
  }
  session_destroy();
}

}
