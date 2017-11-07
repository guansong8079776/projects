<?php
namespace app\common\validate;

use think\Validate;

class Commission extends Validate
{
    protected $rule = [
        "user_id|用户编号" => "require",
        "level|等级编号" => "require",
        "money|提成金额" => "require",
        "level_value|等级提成比例" => "require",
    ];
}
