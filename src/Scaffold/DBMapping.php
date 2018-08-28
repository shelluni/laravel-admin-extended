<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Scaffold;

use Illuminate\Support\Facades\DB;

class DBMapping
{
    /**
     * 获得当前数据的所有表名
     *
     * @return array
     */
    public static function getTables()
    {
        $fields = DB::select("SHOW TABLE STATUS;");

        // convert object to array
        $result = array_map(function($value) {
            return (array)$value;
        }, $fields);

        // get key 'NAME'
        if (!empty($result))
        {
            $result = array_column($result, "Name");
        }
        else
        {
            $result = [];
        }

        return $result;
    }

    public static function getTableComment($tableName)
    {
        $fields = DB::select("SHOW TABLE STATUS WHERE name = '$tableName';");

        // convert object to array
        $result = array_map(function($value) {
            return (array)$value;
        }, $fields);

        // get comment
        if (!empty($result))
        {
            $result = $result[0]['Comment'];
        }
        else
        {
            $result = "";
        }

        return $result;
    }

    /**
     * 根据表名，获得字段信息
     *
     * @param $tableName
     * @return array
     */
    public static function getFields($tableName)
    {
        $fields = DB::select("SHOW FULL COLUMNS FROM $tableName;");

        // convert object to array
        $result = array_map(function($value) {
            // replace field type length with empty string
            $value->Type = strtoupper(preg_replace("/\((\d+)\)/i", "", $value->Type));
            return (array)$value;
        }, $fields);

        return $result;
    }

    /**
     * 根据字段名称，猜关联表的模型名称
     *
     * @param $fieldName
     * @return string
     */
    public static function getRelationModelName($fieldName)
    {
        $fieldName = preg_replace("/(_id)/i", "", $fieldName);

        return ucfirst(camel_case($fieldName));
    }
}