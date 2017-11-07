<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        "level|等级编号" => "require",
        "tel|电话" => "require",
        "referee_id|介绍人编号" => "require",
    ];
}
