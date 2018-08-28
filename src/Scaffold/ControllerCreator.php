<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Scaffold;

class ControllerCreator
{
    // table comment
    protected $tableComment;

    // Controller full name
    protected $controllerName;

    // Model full name
    protected $modelName;

    // Fields
    protected $fields;

    /**
     * ControllerCreator constructor.
     *
     * @param string $tableComment
     * @param string $controllerName
     * @param string $modelName
     * @param array $fields
     */
    public function __construct($tableComment, $controllerName, $modelName, $fields)
    {
        $this->tableComment = $tableComment;
        $this->controllerName = $controllerName;
        $this->modelName = $modelName;
        $this->fields = $fields;
    }

    /**
     * Create Controller
     *
     * @return string
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function create()
    {
        $stub = app('files')->get($this->getStub());

        $stub = $this->replaceComment($stub, $this->tableComment);

        $stub = $this->replaceClass($stub, $this->controllerName);

        $stub = $this->replaceModel($stub, $this->modelName);

        $stub = $this->replaceCode($stub, $this->fields);

        return $stub;
    }

    /**
     * Replace the table comment for the given stub.
     *
     * @param $stub
     * @param $comment
     * @return mixed
     */
    protected function replaceComment($stub, $comment)
    {
        return str_replace(['TABLE_COMMENT'], [$comment], $stub);
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace(['DummyClass', 'DummyNamespace'], [$class, $this->getNamespace($name)], $stub);
    }

    /**
     * Replace the model class name for the given stub.
     *
     * @param $stub
     * @param $model
     * @return mixed
     */
    protected function replaceModel($stub, $model)
    {
        return str_replace(['DummyModelNamespace', 'DummyModel'], [$model, class_basename($model)], $stub);
    }

    /**
     * Replace the code for the given stub.
     *
     * @param $stub
     * @param $fields
     * @return mixed
     */
    protected function replaceCode($stub, $fields)
    {
        $rowsConst = [];
        $rowsGrid = [];
        $rowsForm = [];

        foreach ($fields as $field)
        {
            $fieldName = $field['name'];
            $fieldType = $field['fieldType'];
            $lableName = empty($field['lableName']) ? "" : $field['lableName'];
            $controlType = $field['controlType'];

            // ----- Code Filters ----->

            // 1
            if ($controlType == "n/a")
            {
                continue;
            }

            // 2
            if ($controlType == 'hidden')
            {
                $rowsForm[] = '$form->hidden("' . $fieldName . '");' . "\n";
                continue;
            }

            // 3
            if ($fieldName == 'id' && empty($lableName))
            {
                $lableName = "ID";
            }

            // 4
            if ($fieldName == 'created_at' && empty($lableName))
            {
                $lableName = "创建时间";
            }

            // 5
            if ($fieldName == 'updated_at' && empty($lableName))
            {
                $lableName = "更新时间";
            }

            // ----- Code Generate ----->

            // 基本变量
            // 根据字段名称猜数据模型名称
            $guessedFieldModelName = DBMapping::getRelationModelName($fieldName);

            // Const Code
            // Const Code中，定义变量
            $rowsConst[] = "\"$fieldName\" => \"$lableName\"," . "\n";

            // Grid Code
            // Grid Code中，代码注释
            $rowsGrid[] = "// $lableName\n";

            // Grid Code中，根据不同的数据类型，生成不同的代码
            if ($controlType == 'select')
            {
                $rowsGrid[] = "\$grid->column(\"$fieldName\", self::FIELDS[\"$fieldName\"])->display(function(\$value) {" . "\n";
                $rowsGrid[] = "    if (\$value == 1) {" . "\n";
                $rowsGrid[] = "        return \"值1\";" . "\n";
                $rowsGrid[] = "    } else if (\$value == 2) {" . "\n";
                $rowsGrid[] = "        return \"值2\";" . "\n";
                $rowsGrid[] = "    } else {" . "\n";
                $rowsGrid[] = "        return \"未设定\";" . "\n";
                $rowsGrid[] = "    }" . "\n";
                $rowsGrid[] = "    // \$obj =  $guessedFieldModelName::find(\$value);" . "\n";
                $rowsGrid[] = "    // if (empty(\$obj))" . "\n";
                $rowsGrid[] = "    // {" . "\n";
                $rowsGrid[] = "    //     return self::COMMON_NOT_SET;" . "\n";
                $rowsGrid[] = "    // }" . "\n";
                $rowsGrid[] = "    // return \$obj->name;" . "\n";
                $rowsGrid[] = "});" . "\n";
            }
            else
            {
                $rowsGrid[] = "\$grid->column(\"$fieldName\", self::FIELDS[\"$fieldName\"]);" . "\n";
            }

            // Grid Code中，尾行空行
            $rowsGrid[] = "\n"; //seperate line

            // Form Code
            // Form Code中，代码注释
            $rowsForm[] = "// $lableName\n";

            // Form Code中，通用的方法
            $codeUseControl = "\$form->$controlType(\"$fieldName\", self::FIELDS[\"$fieldName\"])";

            // Form Code中，根据不同的控件类型，生成不同的代码
            if ($controlType == "select" || $controlType == "multipleSelect" || $controlType == "listbox")
            {
                $rowsForm[] =    "$codeUseControl"."->options([1 => 'foo', 2 => 'bar']);" . "\n";
                $rowsForm[] = "// $codeUseControl"."->options($guessedFieldModelName::selections('name', 'empty'));  // 有三种选项 normal all empty" . "\n";
                $rowsForm[] = "// $codeUseControl"."->options(function(\$ids) { return $guessedFieldModelName::find(\$ids)->pluck('name', 'id'); })->ajax('/api/service');" . "\n";
                $rowsForm[] = "// $codeUseControl"."->options('/api/service');" . "\n";

            }
            else if ($controlType == "radio" || $controlType == "checkbox")
            {
                $rowsForm[] =    "$codeUseControl"."->options([1 => 'foo', 2 => 'bar'])->stacked();  // 竖排" . "\n";
                $rowsForm[] = "// $codeUseControl"."->options($guessedFieldModelName::checkboxs('name'));" . "\n";
            }
            else if ($controlType == "textarea")
            {
                $rowsForm[] = "$codeUseControl"."->rows(10);" . "\n";
            }
            else if ($controlType == "mobile")
            {
                $rowsForm[] = "$codeUseControl"."->options(['mask' => '999 9999 9999']);" . "\n";
            }
            else if ($controlType == "color")
            {
                $rowsForm[] = "$codeUseControl"."->default(['#ccc']);" . "\n";
            }
            else if ($controlType == "timeRange" || $controlType == "dateRange" || $controlType == "datetimeRange")
            {
                $rowsForm[] = "\$form->$controlType(\"$fieldName\", \"$fieldName\", self::FIELDS[\"$fieldName\"])";
            }
            else if ($controlType == "switch")
            {
                $rowsForm[] = "$codeUseControl"."->state(['on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'], 'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger']]);" . "\n";
            }
            else if ($controlType == "display" && $fieldName != "id" && $fieldName != "created_at" && $fieldName != "updated_at")
            {
                $rowsForm[] =    "$codeUseControl;" . "\n";
                $rowsForm[] = "// $codeUseControl"."->with(function(\$value) { return \"<img src='\$value' />\"; });" . "\n";
            }
            else
            {
                $rowsForm[] = "$codeUseControl;" . "\n";
            }

            // Form Code中，尾行空行
            $rowsForm[] = "\n"; //seperate line
        }

        // 代码整合
        $codeConst = trim(join(str_repeat(' ', 8), $rowsConst), "\n");
        $codeGrid = trim(join(str_repeat(' ', 12), $rowsGrid), "\n");
        $codeForm = trim(join(str_repeat(' ', 12), $rowsForm), "\n");

        return str_replace(['CODE_CONST', 'CODE_GRID', 'CODE_FORM'], [$codeConst, $codeGrid, $codeForm], $stub);
    }

    /**
     * Get controller namespace from giving name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Get file path from giving controller name.
     *
     * @param $name
     * @return string
     */
    public function getPath($name)
    {
        $segments = explode('\\', $name);

        array_shift($segments);

        return app_path(join('/', $segments)).'.php';
    }

    /**
     * Get stub file path.
     *
     * @return string
     */
    public function getStub()
    {
        return __DIR__.'/stubs/controller.stub';
    }
}
