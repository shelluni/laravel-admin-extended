<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">设置</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <form method="post" id="scaffold" pjax-container>

            <div class="box-body">

                <div class="form-horizontal">
                    <!-- Model名称 -->
                    <div class="form-group">
                        <label for="inputModelName" class="col-sm-1 control-label">Model名称</label>
                        <div class="col-sm-4">
                            <input type="text" name="model_name" class="form-control" id="inputModelName" placeholder="model" value="{{ old('model_name', "App\\Biz\\Models\\") }}">
                        </div>
                    </div>
                    <!-- Controller名称 -->
                    <div class="form-group">
                        <label for="inputControllerName" class="col-sm-1 control-label">Controller名称</label>
                        <div class="col-sm-4">
                            <input type="text" name="controller_name" class="form-control" id="inputControllerName" placeholder="controller" value="{{ old('controller_name', "App\\Admin\\Controllers\\") }}">
                        </div>
                    </div>
                    <!-- Table名称 -->
                    <div class="form-group">
                        <label for="page_title" class="col-sm-1 control-label">静态Tab页面标题</label>
                        <div class="col-sm-4">
                            <input type="text" name="page_title" class="form-control" id="page_title" placeholder="header" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="page_desc" class="col-sm-1 control-label">静态Tab页面说明</label>
                        <div class="col-sm-4">
                            <input type="text" name="page_desc" class="form-control" id="page_desc" placeholder="description" value="">
                        </div>
                    </div>
                </div>

                <hr />

                <h4>Tabs</h4>

                <table class="table table-hover" id="table-fields">
                    <tbody>
                    <tr>
                        <th style="width: 20%;">名称</th>
                        <th style="width: 20%;">URL</th>
                    </tr>

                    </tbody>
                </table>

                <hr style="margin-top: 0;"/>

                <div class='form-inline margin' style="width: 100%">


                    <div class='form-group'>
                        <button type="button" class="btn btn-sm btn-success" id="add-table-field"><i class="fa fa-plus"></i>&nbsp;&nbsp;增加字段</button>
                    </div>

                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <input type="button" class="btn btn-info pull-right" id="buttonGenerate" value="生成">
                <div class="result-area"></div>
                <!--<textarea rows="30" class="form-control" id="textCode"></textarea>-->
            </div>

            {{ csrf_field() }}

            <!-- /.box-footer -->
        </form>
    </div>

</div>

<template id="table-field-tpl">
    <tr>
        <td>
            <input type="text" name="fields[__index__][name]" class="form-control" placeholder="tab标题" />
        </td>
        <td>
            <input type="text" name="fields[__index__][url]" class="form-control" placeholder="tab URL" />
        </td>
        <td>
            <a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> 删除</a>
        </td>
    </tr>
</template>

<script>

$(function () {
    
    function addLine()
    {
        var index = $('#table-fields tr').length - 1;
        $('#table-fields tbody').append($('#table-field-tpl').html().replace(/__index__/g, index));
    }

    $('#buttonGenerate').click(function () {

        var url = "{{url()->current()}}";

        $.ajax({
            method: "POST",
            url: url,
            data: $('#scaffold').serialize()
        }).done(function (response) {
            var textareacode = ''
            $.each(response.code.original,function (idx,obj) {
                $('.result-area').append('<h4>结果' + idx + '</h4><textarea rows="30" style="margin:5px" class="form-control" id="textCode">' + obj + '</textarea><br/>')
            })
            //$('.result-area').html(textareacode);
        });
    });

    // 增加行
    $('#add-table-field').click(function (event) {
        addLine();
    });

    // 删除行
    $('#table-fields').on('click', '.table-field-remove', function(event) {
        $(event.target).closest('tr').remove();
    });
});

</script>