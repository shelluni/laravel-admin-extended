<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Form;

use Illuminate\Support\Str;

class Tools extends \Encore\Admin\Form\Tools
{
    // **************************************************
    // 重新命名列表按钮
    // **************************************************

    public function listButton()
    {
        if (empty($this->listButtonURL))
        {
            // 分析列表地址
            $slice = Str::contains($this->form->getResource(0), '/edit') ? null : -1;
            $resource = $this->form->getResource($slice);
        }
        else
        {
            // 直接使用外部设定的返回地址
            $resource = $this->listButtonURL;
        }

        $text = trans('admin.back_to_list');

        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="$resource" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;$text</a>
</div>
EOT;
    }

    // **************************************************
    // 设定列表按钮的返回地址
    // **************************************************
    protected $listButtonURL = "";

    public function setListButtonURL($url)
    {
        $this->listButtonURL = $url;
    }
}