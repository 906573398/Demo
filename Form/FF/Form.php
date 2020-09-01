<?php

namespace form;

class FormBuilder
{


    public  static  function  text($name = "", $value = "", $option = [])
    {

        $str = '<input type="text" name="row[' . $name . ']" value="' . $value . '"  ' . self::attrProperty($option) . '>';

        return $str;
        # code...
    }

    public  static function password($name = "", $value = "", $option = [])
    {

        $str = '<input type="password" name=row[' . $name . '] value=' . $value . ' ' . self::attrProperty($option) . '>';
        return $str;
        # code...
    }

    public static function radio($name = "", $arr = [], $value = "", $option = [])
    {
        $str = "";
        if (!empty($arr)) {
            foreach ($arr as $k => $v) {

                if ($k == $value) {
                    $str .= '<label><input type="radio"  checked   ' . self::attrProperty($option) . ' name=row[' . $name . '] value=' . $k .   '>' . $v . '</lable>';
                } else {
                    $str .= '<label><input type="radio"    ' . self::attrProperty($option) . '  name=row[' . $name . '] value=' . $k    .   '>' . $v . '</lable>&nbsp;&nbsp;';
                }
            }
        }
        return $str;

        # code...
    }

    public  static function select($name = "", $arr = [], $value = "", $option = [])
    {
        if (!empty($arr)) {
            $str = '<select name="row[' . $name . ']" data-ratio="true">';
            foreach ($arr as $k => $v) {
                if ($k == $value) {
                    $str .= '	<option value="' . $k . '" selected   ' . self::attrProperty($option) . ' >' . $v . '</option>';
                } else {
                    $str .= '	<option value="' . $k . '"  ' . self::attrProperty($option) . '>' . $v . '</option>';
                }
            }

            $str .= '</select>';
            return $str;
        }
        # code...
    }

    public static function checkbox($name = "", $arr = [], $value = [], $option = [])
    {
        $str = "";
        if (!empty($arr)) {
            foreach ($arr as $k => $v) {

                if (in_array($k, $value)) {
                    $str .= '<label><input type="checkbox"  checked   ' . self::attrProperty($option) . ' name=row[' . $name . '] value=' . $k .   '>' . $v . '</lable>&nbsp;&nbsp;';
                } else {
                    $str .= '<label><input type="checkbox"    ' . self::attrProperty($option) . '  name=row[' . $name . '] value=' . $k    .   '>' . $v . '</lable>&nbsp;&nbsp;';
                }
            }
        }
        return $str;
        # code...
    }
    public static function textarea($name = "",  $value = "", $option = [])
    {

        $str = '<textarea type="text" name="row[' . $name . ']" value="' . $value . '"  ' . self::attrProperty($option) . '></textarea>';
        return $str;
        # code...
    }

    public static function selects($name = "", $arr = [], $value = "", $option = [])
    {
        $str = '<select name="row[' . $name . ']" data-ratio="true">';
        if (!empty($arr)) {
            foreach ($arr as $k => $v) {
                if (isset($v['label'])) {
                    $str .= '<optgroup label="' . $v['label'] . '">';
                    foreach ($v['child'] as $k => $item) {
                        if ($k == $value) {
                            $str .= '<option selected value="' . $k . '">' . $item . '</option>';
                        } else {
                            $str .= '<option value="' . $k . '">' . $item . '</option>';
                        }
                    }
                    $str .= "</optgroup>";
                } else {
                    if ($k == $value) {
                        $str .= '<option selected value="' . $k . '">' . $v . '</option>';
                    } else {
                        $str .= '<option  value="' . $k . '">' . $v . '</option>';
                    }
                }
            }

            $str .= "</select>";
            return $str;
        }

        # code...
    }

    public  static function attrProperty($option)
    {
        $str = "";
        foreach ($option as $k => $v) {
            $str .= $k . '=' . $v;
        }
        return $str;
        # code...
    }

    public  static function images($name = "", $value = "", $option = [])
    {
        $str  = ' <div class="case">';
        $str .= '   <div class="upload" action="upload.html" data-value="' . $value . '"  id="case3" ' . self::attrProperty($option) . '></div>';
        $str .= '   </div>';
        return $str;
        # code...
    }

    public static function  selectPage($name = "", $value = "", $option = [])
    {
        $str = '<input type="text" name="row[' . $name . ']" value="' . $value . '"  ' . self::attrProperty($option) . '  id="selectPage" style="width: 500px;">';
        return $str;
        # code...
    }
}
