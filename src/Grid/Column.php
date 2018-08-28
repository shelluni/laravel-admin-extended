<?php

namespace Shelluni\Admin\Grid;

use Closure;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Column extends Grid\Column
{
    /**
     * Fill all data to every column.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function fill(array $data)
    {
        foreach ($data as $key => &$row) {

            // $row 是某一行数据
            // $this->name 是方法column($field, $label)中的第一个参数$field
            if (array_key_exists($this->name, $row))
            {
                // 如果row数据中包含name
                $this->original = $value = is_null(array_get($row, $this->name)) ? "" : array_get($row, $this->name);
            }
            else
            {
                // 如果row数据中不包含name 则将整个数据结构斗给出去
                $this->original = $value = $row;
            }

            $value = $this->htmlEntityEncode($value);

            array_set($row, $this->name, $value);

            if ($this->isDefinedColumn()) {
                $this->useDefinedColumn();
            }

            if ($this->hasDisplayCallbacks()) {
                $value = $this->callDisplayCallbacks($this->original, $key);
                array_set($row, $this->name, $value);
            }
        }

        return $data;
    }
}
