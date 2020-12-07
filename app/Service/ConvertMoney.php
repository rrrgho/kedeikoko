<?php

namespace App\Service;

Class ConvertMoney{
    public function convert($data){
        $result = "";
        for($i=0; $i<strlen($data); $i++){
            if($data[$i]!='.')
                $result.=$data[$i];
        }
        return floatval($result);
    }
}
