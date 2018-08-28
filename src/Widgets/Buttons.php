<?php
/**
 * Created by PhpStorm.
 * User: renyi
 * Date: 2017/10/13
 * Time: 下午20:19
 */

namespace Shelluni\Admin\Widgets;

use Encore\Admin\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class Buttons extends Widget implements Renderable
{
    // 模板
    protected $view = 'admin_extended::widgets.buttons';

    // 数据
    protected $data = [
        'id'           => '',
        'title'        => '',
        'group_class'  => 'btn-group',
        'button_style' => '',
        'buttons'      => [],
    ];

    public function setGroupClass($name = "")
    {
        $this->data['group_class'] = $name;
    }

    public function setView($view)
    {
        $this->view = $view;
    }

    public function setButtonStyle($style)
    {
        $this->data['button_style'] = $style;
    }

    public function add($title, $url = "", $class = "btn-default", $style = "", $enable)
    {
        $this->data['buttons'][] = [
            'id'        => mt_rand(),
            'title'     => $title,
            'url'       => $enable ? $url : "",
            'class'     => $class,
            'style'     => $this->data['button_style'] . " " . $style,
            'disable'   => !$enable,
        ];

        return $this;
    }

    /**
     * 根据active和enable确定按钮的颜色
     *
     * @param $active
     * @param $enable
     * @return array
     */
    public static function guessButtonClassStyle($active, $enable)
    {
        $ret = [
            "class" => "btn-default",
            "style" => ""
        ];

        if ($enable)
        {
            $ret["class"] = "btn-success";
            $ret["style"] = "background-color: #74ba5e;";
        }

        if ($active)
        {
            $ret["class"] = "btn-primary";
            $ret["style"] = "";
        }

        return array_values($ret);
    }

    public static function guessButtonStyle($active, $enable)
    {
        $class = "btn-default";

        if ($enable)
        {
            $class = "btn-success";
        }

        if ($active)
        {
            $class = "btn-primary";
        }

        return $class;
    }

    /**
     * 渲染
     *
     * @return mixed
     */
    public function render()
    {
        $variables = array_merge($this->data, ['attributes' => $this->formatAttributes()]);

        $content = view($this->view, $variables)->render();

        return $content;
    }

    /**
     * 返回内容
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->render();
    }
}