<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class CommonValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'name'  => 'require|max:25',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
//        'name.require' => '名称必须',
        'name.require' => 'name-require',
//        'name.max'     => 'name_max',
//        'age.number'   => 'age_number',
//        'age.between'  => 'age_between',
//        'email'        => 'email_error',
    ];

    protected $scene = [
        'edit'  =>  ['name'],
    ];
}
