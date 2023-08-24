<?php

namespace app\admin\model;

use think\Model;


class Sell extends Model
{

    

    

    // 表名
    protected $name = 'sell';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'bank_type_text'
    ];
    

    
    public function getBankTypeList()
    {
        return ['1' => __('Bank_type 1'), '2' => __('Bank_type 2')];
    }


    public function getBankTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['bank_type']) ? $data['bank_type'] : '');
        $list = $this->getBankTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
