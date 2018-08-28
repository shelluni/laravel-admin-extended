<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Column;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class ExpandRow extends AbstractDisplayer
{
    public function display(\Closure $callback = null, $btn = '')
    {
        $callback = $callback->bindTo($this->row);

        list($start, $html) = call_user_func($callback, $this->value);

        $script = <<<EOT

$('.grid-expand').on('click', function () {
    if ($(this).data('inserted') == '0') {
        var key = $(this).data('key');
        var row = $(this).closest('tr');
        var html = $('template.grid-expand-'+key).html();
        
        var length = row.find('td').length;
        var start  = $start - 1;
        
        if (start <= 0 || start > length)
        {
            row.after("<tr><td colspan='" + length + "' style='padding:0 !important; border:0px;'>"+html+"</td></tr>");
        }
        else
        {
            row.after("<tr><td colspan='" + start + "' style='padding:0 !important; border:0px;'></td><td colspan='" + (length - start) + "' style='padding:0 !important; border:0px;'>"+html+"</td></tr>");
        }

        $(this).data('inserted', 1);
    }

    $("i", this).toggleClass("fa-caret-right fa-caret-down");
});
EOT;
        Admin::script($script);

        $btn = $btn ?: $this->column->getName();

        $key = $this->getKey();

        return <<<EOT
<a class="btn btn-xs btn-default grid-expand" data-inserted="0" data-key="{$key}" data-toggle="collapse" data-target="#grid-collapse-{$key}">
    <i class="fa fa-caret-right"></i> $btn
</a>
<template class="grid-expand-{$key}">
    <div id="grid-collapse-{$key}" class="collapse">$html</div>
</template>
EOT;
    }
}