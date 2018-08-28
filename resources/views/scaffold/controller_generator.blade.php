<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">设置</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <form method="post" id="scaffold" pjax-container>

            <div class="box-body">

                <div class="form-horizontal">
                    <!-- Table名称 -->
                    <div class="form-group">
                        <label for="inputTableName" class="col-sm-1 control-label">Table</label>
                        <div class="col-sm-4">
                            <select style="width: 100%;" name="table_name" id="inputTableName">
                                @foreach($tableNames as $tableName)
                                    <option value="{{ $tableName }}" {{old('table_name') == $tableName ? 'selected' : '' }}>{{$tableName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="button" id="buttonGetTableSchema" class="btn btn-primary" value="获得当前表结构" >
                        </div>
                    </div>
                    <!-- TableComment -->
                    <div class="form-group">
                        <label for="inputModelName" class="col-sm-1 control-label">Comment</label>
                        <div class="col-sm-4">
                            <input type="text" name="table_comment" class="form-control" id="inputTableComment" placeholder="model" value="{{ old('table_comment', "") }}">
                        </div>
                    </div>
                    <!-- Model名称 -->
                    <div class="form-group">
                        <label for="inputModelName" class="col-sm-1 control-label">Model</label>
                        <div class="col-sm-4">
                            <input type="text" name="model_name" class="form-control" id="inputModelName" placeholder="model" value="{{ old('model_name', "App\\Biz\\Model\\") }}">
                        </div>
                    </div>
                    <!-- Controller名称 -->
                    <div class="form-group">
                        <label for="inputControllerName" class="col-sm-1 control-label">Controller</label>
                        <div class="col-sm-4">
                            <input type="text" name="controller_name" class="form-control" id="inputControllerName" placeholder="controller" value="{{ old('controller_name', "App\\Admin\\Controllers\\") }}">
                        </div>
                    </div>
                </div>

                <hr />

                <h4>字段</h4>

                <table class="table table-hover" id="table-fields">
                    <tbody>
                    <tr>
                        <th style="width: 20%;">字段名称</th>
                        <th style="width: 20%;">类型</th>
                        <th style="width: 20%;">标签标题</th>
                        <th style="width: 20%;">使用控件</th>
                        <th style="width: 20%;">Action</th>
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
                <h4>结果</h4>
                <textarea rows="30" class="form-control" id="textCode">{{ $code }}</textarea>
            </div>

            {{ csrf_field() }}

            <!-- /.box-footer -->
        </form>
    </div>

</div>

<template id="table-field-tpl">
    <tr>
        <td>
            <input type="text" name="fields[__index__][name]" class="form-control" placeholder="field name" />
        </td>
        <td>
            <select style="width: 100%;" name="fields[__index__][fieldType]">
                @foreach($fieldTypes as $type)
                    <option value="{{ $type }}">{{$type}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control" placeholder="显示标题的内容" name="fields[__index__][lableName]"/>
        </td>
        <td>
            <select style="width: 100%;" name="fields[__index__][controlType]">
                @foreach($controlTypes as $type)
                    <option value="{{ $type }}">{{$type}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> remove</a>
        </td>
    </tr>
</template>

<script>

$(function () {

    // 动态增加一个字段
    function addLine(field)
    {
        var index = $('#table-fields tr').length - 1;

        if (field == undefined)
        {
            $('#table-fields tbody').append($('#table-field-tpl').html().replace(/__index__/g, index));
        }
        else
        {
            $('#table-fields tbody').append($('#table-field-tpl').html().replace(/__index__/g, index));

            var name = field['Field'];
            var comment = field['Comment'];
            var type = field['Type'];


            // set name labelName fieldType
            $("input[name='fields[" + index + "][name]']").val(name);
            $("input[name='fields[" + index + "][lableName]']").val(comment);
            $("select[name='fields[" + index + "][fieldType]'] option[value='" + type + "']").prop('selected', true);

            // set controlType
            if (name === "id" || name === "created_at" || name === "updated_at")
            {
                chooseSelect2(index, 'display');
            }
            else if (name.indexOf("config_") === 0)
            {
                chooseSelect2(index, 'select');
            }
            else
            {
                if (type === "BIGINT")
                {
                    chooseSelect2(index, 'select');
                }
                else if (type === "VARCHAR" || type === "INT")
                {
                    chooseSelect2(index, 'text');
                }
                else if (type === "TINYINT")
                {
                    chooseSelect2(index, 'select');
                }
                else if (type === "TEXT")
                {
                    chooseSelect2(index, 'textarea');
                }
                else if (type === "DATETIME" || type === "DATE" || type === "TIMESTAMP")
                {
                    chooseSelect2(index, 'datetime');
                }
            }
        }
    }

    // 修改选项的值
    function chooseSelect2(index, control)
    {
        $("select[name='fields[" + index + "][controlType]'] option[value='" + control + "']").prop('selected', true);
    }

    // 将选项初始化
    function enableSelect2()
    {
        $('select').select2();
        $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    }

    // 点击获得当前表结构
    $('#buttonGetTableSchema').click(function () {

       var tableName = $('#inputTableName').val();
       var url = "{{url()->current()}}/schema";

       $.ajax({
           method: "GET",
           url: url,
           data: { table_name: tableName }
       }).done(function (response) {

           var bundle = eval(response);
           console.log(bundle);

           var fields = bundle['fields'];
           var modelName = bundle['model_name'];
           var tableComment = bundle['table_comment'];
           var controllerName = bundle['controller_name'];

           $("#table-fields tr").remove();

           fields.forEach(function(field) {
               addLine(field);
           });

           $("#inputTableComment").val(tableComment);
           $("#inputModelName").val(modelName);
           $("#inputControllerName").val(controllerName);

           enableSelect2();
       });
    });

    // 点击生成
    $('#buttonGenerate').click(function () {

        var url = "{{url()->current()}}";

        $.ajax({
            method: "POST",
            url: url,
            data: $('#scaffold').serialize()
        }).done(function (response) {

            var bundle = eval(response);
            console.log(bundle);

            var code = bundle['code'];

            $('#textCode').val(code);
        });
    });

    // 增加行
    $('#add-table-field').click(function (event) {
        addLine();
        enableSelect2();
    });

    // 删除行
    $('#table-fields').on('click', '.table-field-remove', function(event) {
        $(event.target).closest('tr').remove();
    });

    // Main
    enableSelect2();
});

</script>