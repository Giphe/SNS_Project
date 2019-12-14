<?php

namespace MyApp\Model;

class User extends \MyApp\Model {
    protected $user = '';

  public function create($values){
    $stmt = $this->db->prepare("insert into t_users (email, password, created,
    modified, user_name) values (:email, :password, now(), now(), :user_name)");
    $res = $stmt->execute([
      ':email' => $values['email'],
      ':user_name' => $values['user_name'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    if($res === false ){
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  public function login($values){
    $stmt = $this->db->prepare("select * from t_users where email = :email");
    $stmt->execute([
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if(empty($user)){
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }
    if(!password_verify($values['password'], $user->password)){
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }
    return $user;
  }

  /*全パラメータ取得
   * selectUser
   * @param
   *
   */
  public function selectUser(){
    $stmt = $this->db->query(sprintf("select * from t_users where id = %d", $_SESSION['me']->id));
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();

  }

  /*管理者フラグ取得
   * select_Su
   * @param $loginId
   *
   */
  public function select_Su($loginId) {
      $this->where = \MyApp\Fw\Sql\Where()->equalTo($loginId);
  }
}
