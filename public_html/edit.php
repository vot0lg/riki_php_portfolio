<?php
require_once(__DIR__ . '/../config/config.php');

echo $_SESSION['me']->name . 'さん、こんにちは';
$app = new \MyApp\Controller\Edit();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>投稿編集</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
<a href="/public_html/logout.php">ログアウトする</a>
</header>
  <h1>投稿編集</h1>
  <form action="" method="post">
    <textarea name="message" id="" cols="50" rows="7" autofocus><?=  h($app->getThisPost()['message']) ; ?></textarea>
    <p><input type="submit" value="投稿"></p>
  </form>
</body>
</html>

