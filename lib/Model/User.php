<?php 

namespace MyApp\Model;

class User extends \MyApp\Model {
   
  public function create($values) {
    $stmt = $this->db->prepare('INSERT INTO users SET name=?, email=?, password=?, created=now(), modified=now(), picture=?');
    $res = $stmt->execute(array(
      $values['name'],
      $values['email'],
      password_hash($values['password'], PASSWORD_DEFAULT),
      $values['picture']
    ));
    if($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  public function login($email, $password) {
    $stmt = $this->db->prepare('SELECT * FROM users WHERE email=?');
    $stmt->execute(array($email));
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if(empty($user)) {
      throw new \MyApp\Exception\UnmatchedEmail();
    }
    
    if(!password_verify($password, $user->password)) {
      throw new \MyApp\Exception\UnmatchedPassword();
    }
    return $user;
  }

  public function findUsers() {
    $users = $this->db->query('SELECT * FROM users ORDER BY id DESC');
    $users->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $users->fetchAll();
  }
  // ローカル
  // public function followerRanking() {
  //   $stmt = $this->db->query('
  //   select u.*, count(*) as count,rank()over(order by count(*) desc) as ranking
  //   from users u
  //   left outer join relation r
  //   on u.id=r.follow_id
  //   group by u.id
  //   order by count(*) desc');
  //   $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
  //   return $stmt->fetchAll();
  // }

  // public function followerRanking() {
  //   $stmt = $this->db->query('
  //   select u.*, count(*) as count,rank()over(order by count(*) desc) as ranking
  //   from users u
  //   left outer join relation r
  //   on u.id=r.follow_id
  //   group by u.id
  //   order by count(*) desc');
  //   $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
  //   return $stmt->fetchAll();
  // }
  public function followerRanking() {
    $stmt = $this->db->query('
    SELECT c.id, c.name, c.count, c.picture, FIND_IN_SET(
      c.count, (
        SELECT GROUP_CONCAT(
          c.count ORDER BY c.count DESC
        )
        FROM (select u.id, u.name, u.picture, count(follow_id) as count
    from users u
    left join relation r
    on u.id=r.follow_id
    group by u.id) as c
      )
    ) AS rank
    FROM (select u.id, u.name, u.picture, count(follow_id) as count
    from users u
    left join relation r
    on u.id=r.follow_id
    group by u.id) as c
    order by count desc;');
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function findUser($id) {
    $stmt = $this->db->prepare('SELECT * FROM users WHERE id=?');
    $stmt->execute(array($id));
    // var_dump($stmt->fetch());
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetch();
  }

  public function userDelete($id) {
    $stmt = $this->db->prepare('DELETE FROM users WHERE id=?');
    return $stmt->execute(array($id));    
  }


}

