<?php
use Alfred\Workflows\Workflow;

require 'vendor/autoload.php';

class yjiang {

    public function __construct(){
        $this->workflow = new Workflow;
    }

    public function timestamp($input){
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
        $this->_output($output, $input);
        $this->workflow->result()->copy($output);
    }

    private function _output($output, $input){
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
    }
}
