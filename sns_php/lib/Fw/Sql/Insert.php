<?php
namespace MyApp\Fw\Sql;

class Insert {

    public function equalTo($column, $param) {
        if($param == '' || $param == null) {
            $res = trim($column);
            $res = sprintf('where {$column} = {$param}', $column, '$param');
            return $res;
            //return 'where A = B';
        } else {
            return;
        }
    }

    public function equalIn ($column, $param = array()) {
        $column = trim($column);
        $res = implode(',', $param);

        $res = sprintf('where {$column} = ({$res})', $column, $res);
        return $res;

        //return whwre column ('A', 'B');

    }
}