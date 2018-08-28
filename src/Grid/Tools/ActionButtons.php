<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Tools;

use Encore\Admin\Facades\Admin;

trait ActionButtons
{
    protected function groupAction($resource, $id, $title_edit, $title_delete, $class_edit, $class_delete, $append = "")
    {
        $content = "<div class='btn-group'>".
            $append.
            $this->editAction($resource, $id, $title_edit, $class_edit).
            $this->deleteAction($resource, $id, $title_delete, $class_delete).
            "</div>";

        return $content;
    }

    /**
     * Built edit action.
     *
     * @param $resource
     * @param $id
     * @param $title
     * @param $class
     * @return string
     */
    protected function editAction($resource, $id, $title, $class)
    {
        return <<<EOT
<a class="btn $class" href="$resource/$id/edit">$title</a>
EOT;
    }

    /**
     * Built delete action.
     *
     * @param $resource
     * @param $id
     * @param $title
     * @param $class
     * @return string
     */
    protected function deleteAction($resource, $id, $title, $class)
    {
        $deleteConfirm = trans('admin.delete_confirm');
        $confirm = trans('admin.confirm');
        $cancel = trans('admin.cancel');

        $script = <<<SCRIPT

$('.grid-row-delete').unbind('click').click(function() {

    var id = $(this).data('id');

    swal({
      title: "$deleteConfirm",
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
            url: '$resource/$id',
            data: {
                _method:'delete',
                _token:LA.token,
            },
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

        Admin::script($script);

        return <<<EOT
<a href="javascript:void(0);" data-id="{$id}" class="btn $class grid-row-delete">$title</a>
EOT;
    }

    protected function refuseAction($id,$url)
    {
        $script = <<<SCRIPT
$('#refuse-btn-$id').on('click', function () {

    var modalObj   = '#myModal-$id';
    
    $(modalObj).modal({
        keyboard: true
    })

    $(modalObj).find('textarea[name=content]').css('border-color', '');
    $(modalObj).find('textarea[name=content]').val('');
    $(".submit").on('click',function() {
        
        var form = $(this).closest('form');
        var content = form.find('textarea[name=content]');
        
        if(content.val() == '')
        {
            content.css('border-color','red'); 
        }
        else
        {
            form.submit();
            $(modalObj).modal('hide');
        }
    })
});
SCRIPT;
        Admin::script($script);

        return <<<EOT
<a id="refuse-btn-$id" class='btn btn-sm btn-default refuse-btn' href='#'>不同意<a/>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal-$id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <form action="$url" method="GET" pjax-container>
            <input type="hidden" name="id" value="$id"/>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">拒绝理由</h4>
                </div>
                <div class="modal-body">
                    <textarea name="content" class="form-control" rows="5" placeholder="必须填写"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button class="btn btn-primary submit" type="button" class="btn btn-primary">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
EOT;
    }
}