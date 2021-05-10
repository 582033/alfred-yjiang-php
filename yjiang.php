<?php
require 'vendor/autoload.php';
require 'libs/Apater.php';

use libs\Apater;
use Alfred\Workflows\Workflow;

class yjiang {

    public function __construct(){
        $this->workflow = new Workflow;
    }

    private function _piper($input){
        $regexArr = [
            '/\d+/' => 'timestamp',
            '/\d{4}-\d{1,2}-\d{1,2}/' => 'timestamp',
            '/now/' => 'timestamp',
            '/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/' => 'ip',
        ];
        $output = "未匹配的数据类型";
        foreach($regexArr as $regex => $action){
            if( preg_match($regex, $input) ){
                $Apater = new Apater();
                $output = call_user_func([$Apater, $action], $input);
            }
        }
        return $output;
    }

    public function run($input){
        $output = $this->_piper($input);
        $this->workflow->result()
                    ->uid('com.alfred.yjiang')
                    ->title($output)
                    ->subtitle($input)
                    ->valid(true)
                    ->icon('icon.png')
                    ->mod('ctrl', "对 '{$input}' 进行搜索", 'search')
                    ->mod('cmd', "复制结果:{$output}", 'copy')
                    ->copy($output);

        echo $this->workflow->output();
        $this->workflow->result()->copy($output);
    }
}
