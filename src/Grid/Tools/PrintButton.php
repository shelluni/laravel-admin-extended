<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Tools;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Shelluni\Admin\Grid;

class PrintButton extends AbstractTool
{
    /**
     * Create a new Print button instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Set up script for print button.
     */
    protected function setUpScripts()
    {
        $script = <<<'SCRIPT'

$('.print-selected').click(function (e) {
    e.preventDefault();
    
    var rows = selectedRows().join(',');
    if (!rows) {
        return false;
    }
    
    var href = $(this).attr('href').replace('__rows__', rows);
    location.href = href;
});

SCRIPT;

        Admin::script($script);
    }

    /**
     * Render Print button.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->allowPrinter()) {
            return '';
        }

        $this->setUpScripts();

        $print = trans('admin.print');
        $all = trans('admin.all');
        $currentPage = trans('admin.current_page');
        $selectedRows = trans('admin.selected_rows');

        $page = request('page', 1);

        $useRowSelector =  $this->grid->option('useRowSelector');

        if ($useRowSelector)
        {
            return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a class="btn btn-sm btn-tumblr"><i class="fa fa-download"></i> {$print}</a>
    <button type="button" class="btn btn-sm btn-tumblr dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{$this->grid->printUrl('all')}" target="_blank">123{$all}</a></li>
        <li><a href="{$this->grid->printUrl('page', $page)}" target="_blank">{$currentPage}</a></li>
        <li><a href="{$this->grid->printUrl('selected', '__rows__')}" target="_blank" class='print-selected'>{$selectedRows}</a></li>
    </ul>
</div>
EOT;
        }
        else
        {
            return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a class="btn btn-sm btn-tumblr"><i class="fa fa-download"></i> {$print}</a>
    <button type="button" class="btn btn-sm btn-tumblr dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{$this->grid->printUrl('all')}" target="_blank">123{$all}</a></li>
        <li><a href="{$this->grid->printUrl('page', $page)}" target="_blank">{$currentPage}</a></li>
    </ul>
</div>
EOT;
        }
    }
}
