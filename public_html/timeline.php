<?php
require_once(__DIR__ . '/../config/config.php');

echo $_SESSION['me']->name . 'さん、こんにちは';
$app = new \MyApp\Controller\Timeline();
$app->run();
// var_dump($app->getPosts());
// var_dump($image = $app->getPosts()[1]->image);
// var_dump($app->thumbOrImage($image));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>投稿</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
<div>
<a href="index.php">ユーザー一覧へ</a>
<a href="/public_html/newPost.php">投稿する</a>
</div>
<div>
<a href="/public_html/logout.php">ログアウトする</a>
</div>
</header>
  <h1>タイムライン</h1>
    <ul>
      <?php foreach ($app->getPosts() as $post) : ?>
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
</body>
</html>
