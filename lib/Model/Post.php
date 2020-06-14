<?php 


namespace MyApp\Model;

class Post extends \MyApp\Model {

  public function newPost($message, $image, $reply_message_id, $user_id) {
    // var_dump($message, $image, $reply_message_id, $user_id);
    // exit;
    $stmt = $this->db->prepare('INSERT INTO posts SET user_id=?, message=?, image=?, reply_message_id=?, created=NOW(), modified=NOW()');
    $res = $stmt->execute(array($user_id, $message, $image, $reply_message_id)); 
    // var_dump($stmt);
    // exit;
  }

  public function findAllPosts() {
    //ハマったポイント　
  //usersとpostsテーブル両方に同じpictureカラムを作ったらなぜか正しく処理されなかった
    $stmt = $this->db->query('SELECT u.name, u.picture, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY id DESC');
    // var_dump($stmt->errorCode());
    // var_dump($stmt->errorInfo());

    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    // var_dump($stmt->fetchAll());
    return $stmt->fetchAll();
  }

  public function whoPost($post_id) {
    $stmt = $this->db->prepare('SELECT user_id FROM posts WHERE id=?');
    $stmt->execute(array($post_id));
    // var_dump($stmt->fetch()['user_id']);
    return $stmt->fetch()['user_id'];
  }

  public function delete($post_id) {
    $del = $this->db->prepare('DELETE FROM posts WHERE id=?');
    return $del->execute(array($post_id));
  }

  public function getPost($post_id) {
    $stmt = $this->db->prepare('SELECT u.name, u.picture, p.* FROM users u, posts p WHERE u.id=p.user_id AND p.id=?');
    $stmt->execute(array($post_id));
    // var_dump($stmt->fetch());
    return $stmt->fetch();
  }

  public function editPost($post_id, $message) {
    // var_dump($post_id);
    $stmt = $this->db->prepare('UPDATE posts SET message=?, modified=now() WHERE id=? ');
    return $res = $stmt->execute(array($message, $post_id));
  }

  public function postsThisUser($user_id) {
    $stmt = $this->db->prepare('SELECT u.name, u.picture, p.* FROM users u, posts p WHERE p.user_id=? AND u.id=p.user_id ORDER BY id DESC');
    $stmt->execute(array($user_id));
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function findReplys($id) {
    $stmt = $this->db->prepare('SELECT u.name, u.picture, p.* FROM users u, posts p WHERE p.reply_message_id=? AND u.id=p.user_id ORDER BY id DESC');
    $stmt->execute(array($id));
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    // var_dump($stmt->fetchAll());
    return $stmt->fetchAll();
  }

  public function postsByFollowedUsers($users) {
    // 配列分の　?,?,?... 作る
    $place_holders = implode(',', array_fill(0, count($users), '?'));
    $stmt = $this->db->prepare("SELECT u.name, u.picture, p.* FROM users u, posts p WHERE u.id=p.user_id AND u.id IN ($place_holders) ORDER BY id DESC");
    // var_dump($users);
    $stmt->execute($users);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
     return $stmt->fetchAll();
  }


}
