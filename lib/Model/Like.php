<?php 

namespace MyApp\Model;

class Like extends \MyApp\Model {
  
  public function follow($follow_id, $follower_id) {
    $stmt = $this->db->prepare('INSERT INTO relation SET follow_id=?, follower_id=?, created=now()');
    $res = $stmt->execute(array($follow_id, $follower_id));
    // var_dump($follow_id, $follower_id);
  }

  public function isliked($post_id, $user_id) {
    $stmt = $this->db->prepare('SELECT * FROM likes WHERE post_id=? AND user_id=?');
    $stmt->execute(array($post_id, $user_id));
    if($stmt->fetch()) {
      return true;
    } else {
      return false;
    }
  }

  public function likeAction($sql, $post_id, $user_id) {
    $stmt = $this->db->prepare($sql);
    $res = $stmt->execute(array($post_id, $user_id));
  }

  public function followedUsers($currentUserId) {
    $stmt = $this->db->prepare('SELECT follow_id FROM relation WHERE follower_id=?');
    $stmt->execute(array($currentUserId));
    //一元配列じゃないとあとでexecute()できない
    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
  }

  public function likeCount($post_id) {
    $stmt = $this->db->prepare('SELECT count(id) FROM likes WHERE post_id=?');
    $stmt->execute(array($post_id));
    return $stmt->fetch()['count(id)'];
  }

  }