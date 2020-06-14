<?php
require_once(__DIR__ . '/../config/config.php');

$logout = new \MyApp\Controller\Logout();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログアウト</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>ログアウト</h1>
  <p>ログアウトしました</p>
  <a href="login.php">ログイン画面へ</a>
</body>
</html>