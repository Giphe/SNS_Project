<?php
namespace MyApp\Fw\Sql;

class Where {
    protected $where;

    public function equalTo($param) {
        if($param == '' || $param == null) {
            $res = $param;
            return $res;
        }
    }
}