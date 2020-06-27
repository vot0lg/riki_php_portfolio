<?php 

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();

$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header><div class="success"><?= h($app->getValues('success')) ; ?></div></header>
  <h1>ログイン</h1>
  <a href="signup.php">新規登録へ</a>
  <p>採用者様用アカウント</p>
  <p>Email: test@gmail.com</p>
  <p>Password: tttttt;</p>
  <div class="form">
    <form action="" method="post">
  <p>
    <input type="email" name="email" placeholder="email" value="<?= h($app->getValues('email')) ; ?>">
  </p>
  <p>
    <input type="password" name="password" placeholder="password">  
  </p>
  <p class="error"><?= h($app->getErrors('login')) ; ?></p>
    <input type="submit" value="ログイン">
  </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
    $(function(){
      $('.success').fadeOut(3000);
    });
  </script>
</body>
</html>
