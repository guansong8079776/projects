<?php
namespace app\common\validate;

use think\Validate;

class Level extends Validate
{
    protected $rule = [
        "name|等级名称" => "require",
        "money|等级提成比例" => "require",
    ];
}
