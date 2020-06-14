<?php
require_once(__DIR__ . '/../config/config.php');

echo $_SESSION['me']->name . 'さん、こんにちは';
$app = new \MyApp\Controller\Show();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>投稿詳細</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
<a href="/public_html/logout.php">ログアウト</a>
</header>
  <h1>投稿詳細</h1>
  <img class="user-icon" src="<?= '../userPictures/' . h($app->getThisPost()['picture']) ; ?>" alt="<?= h($app->getThisPost()['name']) ; ?>" width="100" height="100">
  <a class="not_blue" href="userShow.php?id=<?= h($app->getThisPost()['user_id']) ; ?>"><h3>ユーザー : <?= h($app->getThisPost()['name']) ; ?></h3></a>
  <h3>投稿 : <?= h($app->getThisPost()['message']) ; ?></h3>
  <?php if($app->getThisPost()['image']) : ?>
  <img src="../postImages/<?= h($app->getThisPost()['image']) ; ?>" alt="" width="500">
  <?php endif ; ?>  
  <p>投稿日時 : <?= h($app->getThisPost()['created']) ; ?><p>  
  <a href="newPost.php?res=<?= h($app->getThisPost()['id']) ; ?>">返信</a>
  <?php if($app->getThisPost()['user_id'] === $_SESSION['me']->id) : ?>
  <a href="edit.php?id=<?= h($app->getThisPost()['id']) ; ?>">編集</a>
  <a href="../lib/Controller/Delete.php?id=<?= h($app->getThisPost()['id']) ; ?>">削除</a>
  <?php endif ; ?>
  <div>
    <h2>返信一覧</h2>
    <ul>
      <?php foreach ($app->getValues('replys') as $post) : ?>
        <li>
          <div class="flex-box">
            <img class="user-icon" src="/userPictures/<?= h($post->picture) ; ?>" width="50" height="50" alt="">
            <div class="text">
              <p><?= h($post->name) ; ?></p>
              <a class="not_blue" href="show.php?id=<?= h($post->id) ; ?>"><?= h($post->message) ; ?></a><br>
              <a href="show.php?id=<?= h($post->id) ; ?>"><img class="post_image" src="../<?= h($app->thumbOrImage($post->image)) ; ?>" alt=""></a><br>
              <?= $post->created ; ?>
              <a href="newPost.php?res=<?= h($post->id) ; ?>">返信</a>
              <?php if($post->user_id === $_SESSION['me']->id) : ?>
                <a href="edit.php?id=<?= h($post->id) ; ?>">編集</a>
                <a href="../lib/Controller/Delete.php?id=<?= h($post->id) ; ?>">削除</a>
              <?php endif ; ?>
              <?php if($post->reply_message_id >= 1) : ?>
                <a href="show.php?id=<?= h($post->reply_message_id) ; ?>">返信先のメッセージ</a>
              <?php endif ; ?>
            </div>
          </div>
        </li>
      <?php endforeach ; ?>
    </ul>
  </div>
  <p><a href="newPost.php">戻る</a></p>
</body>
</html>
