<?php

namespace MyApp\Model;

class Topics extends \MyApp\Model {

    public function create($values){
        $stmt = $this->db->prepare("insert into topics (id, category_id, category_name,
    koukai_date, start_date, end_date) values (:id, :category_id, :category_name,
    :start_date, :end_date)");
        $res = $stmt->execute([
            ':id' => $values['id'],
            ':category_id' => $values['category_id'],
            ':category_name' => $values['category_name'],
            ':koukai_date' => $values['koukai_date'],
            ':start_date' => $values['start_date'],
            ':end_date' => $values['end_date']
        ]);
        if($res === false ){
            throw new \MyApp\Exception\NoCategory();
        }
    }

    public function select($values){
        $stmt = $this->db->prepare("select * from topics where id = :id");
        $stmt->execute([
            ':id' => $values['id'],
            ':category_id' => $values['category_id'],
            ':category_name' => $values['category_name'],
            ':koukai_date' => $values['koukai_date'],
            ':start_date' => $values['start_date'],
            ':end_date' => $values['end_date']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $topics = $stmt->fetch();

        if(empty($topics)){
            throw new \MyApp\Exception\UnmatchId();
        }
        if(!password_verify($values['id'], $topics->id)){
            throw new \MyApp\Exception\UnmatchId();
        }
        return $topics;
    }

    public function findAll(){
        $stmt = $this->db->query("select * from topics order by id");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();

    }
}
