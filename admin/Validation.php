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
            if (count($two_arr) == 1) {
                $rule_arr[ $two_arr[0] ] = true;
            }
            $rule_arr[ $two_arr[0] ] = $two_arr[1];
        }
        return $rule_arr;
    }

    //在这里进行拆分  和调用
    public function validation_rule($user_val, $rule_val, &$msg = null)
    {
        $rule_arr = $this->rule_arr($rule_val);
        foreach ($rule_arr as $key => $val) {
            $method = 'valid_' . $key;
            $r = $this->$method($user_val, $val);
            if (!$r) {
                $msg = 'invalid_' . $key;
                return false;
            }
        }
        return true;
    }

    public function valid_integer($user_val, $val = null)
    {
        //判断数量是不是整数
        if (!is_numeric($user_val)) return false;
        $user_val = (string)$user_val;
        if (strpos($user_val, '.') === false)
            return true;
    }

    public function valid_numeric($user_val, $val = null)
    {
        return is_numeric($user_val);
    }

    public function valid_positive($user_val, $val = null)
    {
        $user_val = (float)$user_val;
        return $user_val >= 0;
    }

    public function valid_u_max_length($user_val, $max)
    {
        $user_val = (string)$user_val;
        return strlen($user_val) <= $max;
    }

    public function valid_u_min_length($user_val, $min)
    {
        $user_val = (string)$user_val;
        return strlen($user_val) >= $min;
    }

    public function valid_p_max_length($user_val, $max)
    {
        $user_val = (string)$user_val;
        return strlen($user_val) <= $max;
    }

    public function valid_p_min_length($user_val, $min)
    {
        $user_val = (string)$user_val;
        return strlen($user_val) >= $min;
    }
}

