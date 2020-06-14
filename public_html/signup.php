<?php 

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Signup();

$app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規登録</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <div class="success"><?= $app->getValues('delete') ; ?></div>
  </header>
  <h1>新規登録</h1>
  <a href="login.php">ログイン画面へ</a>
  <div class="form">
    <form action="" method="post" enctype="multipart/form-data">
  <p>
   <input type="text" name="name" placeholder="name" value="<?= h($app->getValues('name')) ; ?>">
  </p>
  <p>
    <input type="email" name="email" placeholder="email" value="<?= h($app->getValues('email')) ; ?>">
  </p>
  <p class="error"><?= h($app->getErrors('email')) ; ?></p>
  <p>
    <input type="password" name="password" placeholder="password">  
  </p>
  <p class="error"><?= h($app->getErrors('all')) ; ?></p>
  <p class="error"><?= h($app->getErrors('password')) ; ?></p>
  <p>画像
    <input type="file" name="image">  
  </p>
  <p class="error"><?= h($app->getErrors('image')) ; ?></p>
    <input type="submit" value="新規登録">
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