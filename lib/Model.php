<?php 
namespace MyApp;

// 開発用

// class Model {
//   protected $db;

//   public function __construct() {
//     try {
//       $this->db = new \PDO('mysql:dbname=original_app;host=localhost;charset=utf8','riki','#iq-tuftG9>=<');
//       $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);

//     } catch (\PDOException $e) {
//       echo $e->getMessage();
//       exit;
//     }
//   }
// }


// 本番用
class Model {
  protected $db;
  public function __construct() {
    try {
      // var_dump(parse_url($_SERVER['CLEARDB_DATABASE_URL']));
      // exit;
      $url = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
      $dbname = substr($url["path"], 1);
      $host = $url["host"];
      $user = $url["user"];
      $password = $url["pass"];
      $this->db = new \PDO('mysql:dbname='.$dbname.';host='.$host.';charset=utf8', $user, $password);
      $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);

    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
}

