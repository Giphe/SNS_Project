<?php

namespace MyApp\Model;

class Follow extends \MyApp\Model {
    protected $follow = '';

    //TODO:followボタン製造後製造開始
    public function create_follow ($values) {
        $stmt = $this->db->prepare("insert into t_follow (user_id, follower_id, created)
        values (:user_id, :follower_id, now())");
        $res = $stmt->execute([
            ':user_id' => $values['id'],
            ':follower_id' => $values['follower_id']
        ]);
        if($res === false ){
            throw new \MyApp\Exception\DuplicateEmail();
        }
    }

    //TODO:delete_follow

    public function delete_follow() {
        $stmt = $this->db->prepare(sprintf("delete from t_follow where follow_id = %d", $_SESSION['me']->id));
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $user = $stmt->fetch();
        $_db->commit();

        if(empty($user)){
            throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        if(!password_verify($values['password'], $user->password)){
            throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        return $user;
    }

    /*フォロー取得
     * get_follow
     * @param
     *
     */
    public function get_follow(){

        $sql = sprintf("select * from t_follow where user_id = %d", $_SESSION['me']->id);
        $stmt = $this->db->query($sql);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $res = $stmt->fetchAll();

        return $res;
    }

    /*フォロワー取得
     * get_follower
     * @param
     *
     */
    public function get_follower(){

        $sql = sprintf("select * from t_follow where follower_id = %d", $_SESSION['me']->id);
        $stmt = $this->db->query($sql);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $res = $stmt->fetchAll();

        return $res;

    }


}
