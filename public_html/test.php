<?php 

$nums = [1,2,3,4,5];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Test</title>
  <link rel="stylesheet" href="/public_html/styles.css">
</head>
<body>

<ul id="nums">
<?php foreach($nums as $num):?>
<div>
  <li id="num_<?= $num; ?>" data-id="<?= $num; ?>">
  <form action="">
    <div class="follow_btn">フォローする</div>
  </form>
  </li>
</div>
<?php endforeach; ?>  
</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
    $(function() {
     $('#nums').on('click', '.follow_btn', function() {
       $id = $(this).parents('li').data('id');
     })
    });

  </script>


<ul>
  <li>HTML</li>
  <li>PHP</li>
  <li>Ruby</li>
</ul>