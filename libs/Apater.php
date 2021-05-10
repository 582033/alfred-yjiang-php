<?php
namespace libs;

date_default_timezone_set('PRC');

class Apater {
    public function ip($input){
        $output = "未获取到IP位置";
        $ipRes = file_get_contents("http://ip-api.com/php/{$input}");
        $ipResArr = unserialize($ipRes);
        if( isset($ipResArr['status']) && $ipResArr['status'] == 'success' ){
            $output = "IP:{$input} 所在地理位置: {$ipResArr['country']} {$ipResArr['regionName']} {$ipResArr['city']}";
        }
        return $output;
    }

    public function timestamp($input){
        $output = "";
        if( is_numeric($input) ){
            $output = date('Y-m-d H:i:s', $input);
        }
        else{
            if( $input == 'now' ){
                $input = date('Y-m-d H:i:s', time());
            }
            $output = strtotime($input);
        }
        if( $output <= 0 ){
            $output = '请检查您输入的时间格式是否正确';
        }
        return $output;
    }

}
