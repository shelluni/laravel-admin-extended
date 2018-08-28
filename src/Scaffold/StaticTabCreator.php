<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Scaffold;

class StaticTabCreator
{
    // Controller full name
    protected $controllerName;
    protected $modelName;
    protected $header;
    protected $desc;

    // Fields
    protected $fields;

    /**
     * ControllerCreator constructor.
     *
     * @param string $controllerName
     * @param string $modelName
     * @param string $header
     * @param string $desc
     * @param array $fields
     */
    public function __construct($controllerName, $modelName, $header, $desc, $fields)
    {
        $this->controllerName = $controllerName;
        $this->modelName = $modelName;
        $this->header = $header;
        $this->desc = $desc;
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

        $stub = $this->replaceClass($stub, $this->controllerName);
        $stub = $this->replaceModel($stub, $this->modelName);
        $stub = $this->replaceHeader($stub, $this->header);
        $stub = $this->replaceDesc($stub, $this->desc);

        $stub = $this->replaceCode($stub, $this->fields);

        return response()->json($stub);
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

    protected function replaceModel($stub, $model)
    {
        return str_replace(['DummyModelNamespace', 'DummyModel'], [$model, class_basename($model)], $stub);
    }

    /**
     * Replace the model class name for the given stub.
     *
     * @param $stub
     * @param $header
     * @return mixed
     */
    protected function replaceHeader($stub, $header)
    {
        return str_replace('PAGE_HEADER', $header, $stub);
    }

    protected function replaceDesc($stub, $desc)
    {
        return str_replace('PAGE_DESC', $desc, $stub);
    }

    protected function replaceActive($stub, $num)
    {
        return str_replace('ACTIVE_SHEET', $num, $stub);
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
        $files = [];
        $tabs = '';
        foreach ($fields as $field){
            $tabs .= "\$st->add('$field[name]','$field[url]');\r\n\t    ";
        }
        $stub = str_replace('TABS_CODE', $tabs, $stub);

        foreach ($fields as $k => $v){
            $files[$k] = $this->replaceActive($stub, $k);
        }
        return $files;
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
        return __DIR__.'/stubs/statictab.stub';
    }
}
