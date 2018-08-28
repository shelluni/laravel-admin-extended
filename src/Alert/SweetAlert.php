<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Alert;

use Encore\Admin\Facades\Admin;

class SweetAlert
{
    protected $elementId;

    protected $url = "";
    protected $data = [];
    protected $alertTitle = "";
    protected $buttonText = "";
    protected $buttonTextColor = "";
    protected $buttonIconClass = "";


    /**
     * SweetAlertLink constructor.
     * @param $url
     * @param $alertTitle
     * @param $buttonText
     * @param $buttonIconClass
     */
    public function __construct($url, $alertTitle = "", $buttonText = "", $buttonIconClass = "", $buttonTextColor = "")
    {
        $this->elementId = uniqid();

        $this->url = $url;
        $this->alertTitle = $alertTitle;
        $this->buttonText = $buttonText;
        $this->buttonTextColor = $buttonTextColor;
        $this->buttonIconClass = $buttonIconClass;

        $this->data(['_token' => csrf_token()]);
    }

    /**
     * 设定数据
     *
     * @param $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * 渲染
     *
     * @return string
     */
    public function render()
    {
        $confirm = trans('admin.confirm');
        $cancel = trans('admin.cancel');

        $data = json_encode($this->data);

        $script = <<<SCRIPT
$('.sweet-alert-$this->elementId').unbind('click').click(function() {
    swal({
      title: "$this->alertTitle",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "$confirm",
      closeOnConfirm: false,
      cancelButtonText: "$cancel"
    },
    function(){
        $.ajax({
            method: 'post',
            url: '$this->url',
            data: $data,
            success: function (data) {
                $.pjax.reload('#pjax-container');
                if (typeof data === 'object') {
                    if (data.status) {
                        swal(data.message, '', 'success');
                    } else {
                        swal(data.message, '', 'error');
                    }
                }
            }
        });
    });
});
SCRIPT;
        // 将脚本传递给框架
        Admin::script($script);

        return <<<EOT
<a href='javascript:void(0);' class='sweet-alert-$this->elementId margin-r-5' style="color:$this->buttonTextColor;"><i class='fa $this->buttonIconClass'></i> $this->buttonText</a>
EOT;
    }

    public function __toString()
    {
        return $this->render();
    }
}