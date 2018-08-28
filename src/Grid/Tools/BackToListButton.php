<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Tools;

use Encore\Admin\Grid\Tools\AbstractTool;
use Shelluni\Admin\Grid;

class BackToListButton extends AbstractTool
{
    protected $url;

    /**
     * Create a new Print button instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    public function setURL($url)
    {
        $this->url = $url;
    }

    /**
     * Render Print button.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->allowBackToList()) {
            return '';
        }

        $text = trans('admin.back_to_list');

        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="$this->url" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;$text</a>
</div>
EOT;
    }
}
