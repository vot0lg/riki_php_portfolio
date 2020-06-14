<?php 

namespace MyApp\Model;

class Relation extends \MyApp\Model {
  
  public function follow($follow_id, $follower_id) {
    $stmt = $this->db->prepare('INSERT INTO relation SET follow_id=?, follower_id=?, created=now()');
    $res = $stmt->execute(array($follow_id, $follower_id));
    // var_dump($follow_id, $follower_id);
  }

  public function isFollowed($follow_id, $follower_id) {
    $stmt = $this->db->prepare('SELECT * FROM relation WHERE follow_id=?AND follower_id=?');
    $stmt->execute(array($follow_id, $follower_id));
    if($stmt->fetch()) {
      return true;
    } else {
      return false;
    }
  }

  public function followAction($sql, $follow_id, $follower_id) {
    $stmt = $this->db->prepare($sql);
    $res = $stmt->execute(array($follow_id, $follower_id));
  }

  public function followedUsers($currentUserId) {
    $stmt = $this->db->prepare('SELECT follow_id FROM relation WHERE follower_id=?');
    $stmt->execute(array($currentUserId));
    //一元配列じゃないとあとでexecute()できない
    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
  }

  public function followerCount($user_id) {
    $stmt = $this->db->prepare('SELECT count(*) FROM relation WHERE follow_id=?');
    $stmt->execute(array($user_id));
    return $stmt->fetch()['count(*)'];
  }

  public function ranking($id) {
    // $stmt = $this->db->prepare('
    // select ranking
    // from
    //   (select u.id, count(follower_id), rank()over(order by count(follower_id) desc) as ranking
    //   from users u
    //   left outer join relation r
    //   on u.id=r.follow_id
    //   group by u.id) as t
    // where t.id=?
    // ');
    $stmt = $this->db->prepare('
SELECT FIND_IN_SET(
  c.count, (
    SELECT GROUP_CONCAT(
      c.count ORDER BY c.count DESC
    )
    FROM (select u.id, count(follow_id) as count
          from users u
          left join relation r
          on u.id=r.follow_id
          group by u.id) as c
          )
) AS ranking
FROM (select u.id, count(follow_id) as count
      from users u
      left join relation r
      on u.id=r.follow_id
      group by u.id) as c
WHERE c.id=?;
    ');
    $stmt->execute(array($id));
    return $stmt->fetch()['ranking'];
  }

  }