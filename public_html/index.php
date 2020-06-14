<?php
require_once(__DIR__ . '/../config/config.php');

$app = new \MyApp\Controller\Index();
$app->run();
$currentUser = $_SESSION['me'];
echo $_SESSION['me']->name . 'さん、こんにちは';
$users = $app->getValues('users');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザーの一覧</title>
  <link rel="stylesheet" href="/public_html/styles.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
<header>
<div>
  <a href="/public_html/newPost.php">投稿する</a>
  <a href="/public_html/timeline.php">タイムラインへ</a>
</div>
  <div>
    <a href="/public_html/logout.php">ログアウト</a>
    <a href="/public_html/userDelete.php">アカウント削除</a>
  </div>
</header>
  <h1>フォローワーランキング</h1>
  <ul id="users">
    <?php foreach ($users as $user) : ?>
    <li id="user_<?= h($user->id); ?>" data-id="<?= h($user->id); ?>">
      <div class="flex-box">
        <div class="ranking"><i class="fas fa-crown <?= $app->whoChampion($user->id); ?>"></i></div>
        <img class="user-icon" src="<?= '/userPictures/' . h($user->picture) ; ?>" alt="<?= h($user->name) ; ?>" width="50" height="50">
        <div class="name">
          <a class="not_blue" href="/public_html/userShow.php?id=<?= h($user->id) ; ?>"><?= h($user->name) ; ?></a>
        </div>
        <i class="fas fa-male"></i>
        <span class="follower_count">x<?= h($app->followerCount($user->id)); ?></span>
        <form id='form' action="" method="post">
        <?php if ($user->id != $currentUser->id) : ?>
          <?php if ($app->isfollowed($user->id)) : ?>
            <div class="follow_btn followed">フォロー中</div>
          <?php else : ?>  
            <div class="follow_btn">フォローする</div>
          <?php endif ; ?>
        <?php endif ; ?>       
        </form>
        </>
          <p id="result_<?= h($user->id) ; ?>" class="result"></p>
    </li>
    <?php endforeach ; ?>
  </ul>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
    $(function() {

      $('#users').on('click', '.follow_btn', function() {
        var id = $(this).parents('li').data('id');
        var this_btn = this;
        //ajax処理
        $.post('/public_html/_ajax.php', {
          follow_id: id
        }, function(data) {
          // alert(data.ranking);
          switch(data.ranking) {
            case '1':
            var color = 'fa-gold';
            break;
            case '2':
            var color = 'fa-silver';
            break;
            case '3':
            var color = 'fa-bronze';
            break;
            default:
            var color = 'none';
            break;
          }
          $(this_btn).parents('li').find('.ranking > i').removeClass().addClass('fas fa-crown ' + color,1000);
          $(this_btn).parents('li').find('.follower_count').text('x' + data.count);
          if(data.action === "登録") {
            // $(this_btn).removeClass('follow').text('フォロー中');
            $(this_btn).addClass('followed').text('フォロー中');
            

          } else {
            $(this_btn).removeClass('followed').text('フォローする')

          }
        //   if (res.action === '解除'){

        //   } else {

        //   }
        // });
        });
      });

    });

  </script>
</body>
</html>
