<?php
require_once(__DIR__ . '/../config/config.php');

echo $_SESSION['me']->name . 'さん、こんにちは';
$app = new \MyApp\Controller\NewPost();
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
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
<header>
  <a href="index.php">ユーザー一覧へ</a>
  <a href="/public_html/logout.php">ログアウトする</a>
</header>
  <h1>投稿</h1>
  <form action="" method="post" enctype="multipart/form-data">
  <textarea name="message" id="" cols="50" rows="7" autofocus><?= h($app->isReply()) ? '@' . h($app->getThisPost()['name']) . '  ' . h($app->getThisPost()['message']) : '' ; ?></textarea>
  <!-- ここで空文字を使うことによってmysqlにNULLでの挿入を防ぐ！！！ -->
<input type="hidden" name="reply_message_id" value="<?= $app->isReply()? h($_GET['res']) :0 ; ?>">
<input type="hidden" name="token" value="<?= h($_SESSION['token']) ; ?>">
<input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE) ; ?>">
<br>
<input type="file" name="image" id="">
<p class="error"><?= h($app->getErrors('post')) ; ?></p>
  <p><input type="submit" value="投稿"></p>
  </form>
  <div>
    <h2>投稿一覧</h2>
    <ul id="posts">
      <?php foreach ($app->getPosts() as $post) : ?>
        <li id="<?= h($post->id) ; ?>">
          <div class="flex-box">
            <img class="user-icon" src="/userPictures/<?= h($post->picture) ; ?>" alt="">
            <div id="" class="text">
              <p><?= h($post->name) ; ?></p>
              <a class="not_blue" href="show.php?id=<?= h($post->id) ; ?>"><?= h($post->message) ; ?></a><br>
              <?php if($post->image) : ?>
              <a href="show.php?id=<?= h($post->id) ; ?>">
                <img class="post_image" src="../<?= h($app->thumbOrImage($post->image)) ; ?>" alt=""></a><br>
                <?php endif ; ?>
              <?= $post->created ; ?>
              
              <div class="like_btn">
                <?php if($app->isLiked($post->id)): ?>
                  <i class="fas fa-thumbs-up fa-red"></i>
                  <?php else: ?>
                    <i class="far fa-thumbs-up fa-opacity"></i>
                <?php endif; ?>
              </div>
              <span class="like_count"><?= $app->likeCount($post->id); ?></span>

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
  $(function(){
    $('#posts').on('click', 'i', function(){

      var id = $(this).parents('li').attr('id');
      //どっちでもできる
      // var id = $(this).parents('li').data('id');
      var this_btn = this;
      $.post('/public_html/_ajax.php', {
        like_id: id
      } ,function(data) {
        //上のthisを変数に代入して使う
        // var count = $('#' . id).find('.like_count').text();
        $(this_btn).parents('li').find('.like_count').text(data.count);
        if (data.action == '登録') {
        $(this_btn).addClass('fas fa-red');
        $(this_btn).removeClass('far fa-opacity');
        } else if (data.action == '解除') {
        $(this_btn).removeClass('fas fa-red');
        $(this_btn).addClass('far fa-opacity');
        }
      })
    })
  })
  </script>
</body>
</html>
