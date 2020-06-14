<?php
require_once(__DIR__ . '/../config/config.php');

echo $_SESSION['me']->name . 'さん、こんにちは';
$app = new \MyApp\Controller\UserDelete();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント削除</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>アカウント削除</h1>
  <p>本当に削除してもよろしいですか？</p>
  <form action="" method="post">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']) ?>">
    <input type="submit" value="削除">
  </form>
  <p><a href="newPost.php">戻る</a></p>
</body>
</html>
