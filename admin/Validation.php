<?php

class Validation
{
    //首先解开调用的规则
    public function rule_arr($rule)
    {
        $one_arr = explode('|', $rule);
        $rule_arr = [];
        foreach ($one_arr as $rule) {
            $two_arr = explode(':', $rule);
            $rule_arr[$two_arr[0]] = $two_arr[1];
        }
        return $rule_arr;
    }

    //在这里进行拆分  和调用
    public function validation_rule($user_val, array $rule_arr, &$msg = null)
    {
        foreach ($rule_arr as $key => $val) {
            $method = 'valid_' . $key;
            $r = $this->$method($user_val, $val);
            if (!$r) {
                $msg = 'invalid' . $key;
                return false;
            }
        }
        return true;
    }

    public function valid_max_length($user_val, $max)
    {
        $user_val = (string)$user_val;
        return strlen($user_val) <= $max;
    }

    public function valid_min_length($user_val, $min)
    {
        $user_val = (string)$user_val;
        return strlen($user_val) >= $min;
    }
}