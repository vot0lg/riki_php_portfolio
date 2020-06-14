<?php
require_once(__DIR__ . '/../config/config.php');

echo $_SESSION['me']->name . 'さん、こんにちは';
$app = new \MyApp\Controller\UserShow();
$app->run();
$currentUser = $_SESSION['me'];
$user = $app->getValues('user');
// var_dump();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー詳細</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <div></div>
  <div>
    <a href="/public_html/logout.php">ログアウト</a>
  </div>
</header>
  <h1>ユーザー詳細</h1>

  <div class="flex-box">
        <img class="user-icon" src="<?= '../userPictures/' . h($user->picture) ; ?>" alt="<?= h($user->name) ; ?>" width="100" height="100">
        <div>
          <h2 id="user-show-name"><?= h($user->name) ; ?></h2>
        </div>
          <div class="btnBox" data-id="<?= h($user->id); ?>">
          <?php if ($user != $currentUser) : ?>
          <?php if ($app->isFollowed($user->id)) : ?>
            <div class="follow_btn followed">フォロー中</div>
          <?php else : ?>  
            <div class="follow_btn">フォローする</div>
          <?php endif ; ?>
          <?php endif ; ?>
          </div>
  </div>


    <ul>
      <?php foreach ($app->getPosts() as $post) : ?>
        <li>
        <h4><a class="not_blue" href="show.php?id=<?= h($post->id) ; ?>"><?= h($post->message) ; ?></a></h4>
        <span><?= h($post->created) ; ?></span>
        <a href="newPost.php?res=<?= h($post->id) ; ?>">返信</a>
        <?php if($post->user_id === $_SESSION['me']->id) : ?>
        <a href="edit.php?id=<?= h($post->id) ; ?>">編集</a>
        <a href="../lib/Controller/Delete.php?id=<?= h($post->id) ; ?>">削除</a>
        <?php endif ; ?>
        <?php if($post->reply_message_id >= 1) : ?>
        <a href="show.php?id=<?= h($post->reply_message_id) ; ?>">返信先のメッセージ</a>
        <?php endif ; ?>
        </li>
      <?php endforeach ; ?>
    </ul>
  <p><a href="newPost.php">戻る</a></p>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
    $(function() {

      $('.btnBox').on('click', '.follow_btn', function() {
        var id = $(this).parent().data('id');
        var this_btn = this;
        //ajax処理
<<<<<<< HEAD
        $.post('/public_html/_ajax.php', {
          follow_id: id
        }, function(data) {
          if(data.action === "登録") {
=======
        $.post('_ajax.php', {
          id: id
        }, function(data) {
          // $(this_btn).parents('li').find('.result').text(data);
          if(data === "登録") {
>>>>>>> origin/master
            $(this_btn).toggleClass('follow').text('フォロー中');
            $(this_btn).addClass('followed').text('フォロー中');
            

          } else {
            $(this_btn).removeClass('followed').text('フォローする')

          }
        });
      });

    });

  </script>
</body>
</html>
