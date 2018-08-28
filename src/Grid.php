<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin;

use Closure;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Input;
use Shelluni\Admin\Grid\ExtendedExporter;
use Shelluni\Admin\Grid\PrinterManager;
use Shelluni\Admin\Grid\Tools\BackToListButton;
use Shelluni\Admin\Grid\Tools\PrintButton;

class Grid extends \Encore\Admin\Grid
{
    // **************************************************
    // 支持 新的模板
    // **************************************************

    /**
     * View for grid to render.
     *
     * @var string
     */
    protected $view = 'admin.grid.table';

    // **************************************************
    // 新的options 增加
    // usePrinter
    // useTop
    // useBottom
    // useBackToList
    // **************************************************

    /**
     * Options for grid.
     *
     * @var array
     */
    protected $options = [
        'usePagination'     => true,
        'useFilter'         => true,
        'useExporter'       => true,
        'usePrinter'        => false,
        'useActions'        => true,
        'useRowSelector'    => true,
        'allowCreate'       => true,
        'useTop'            => false,
        'useBottom'         => false,
        'useBackToList'     => false,
        'useTitle'          => false,
    ];

    // **************************************************
    // 新的构造函数
    // **************************************************
    /**
     * Create a new grid instance.
     *
     * @param Eloquent $model
     * @param Closure  $builder
     */
    public function __construct(Eloquent $model, Closure $builder)
    {
        parent::__construct($model, $builder);

        $this->setupPrinter();
        $this->setupToolbars();
    }

    // **************************************************
    // 支持 顶部扩展
    // **************************************************

    /**
     * If grid allows Top
     *
     * @return bool
     */
    public function allowTop()
    {
        return $this->option('useTop');
    }

    /**
     * Disable Top.
     *
     * @return $this
     */
    public function enableTop()
    {
        return $this->option('useTop', true);
    }

    /**
     * 渲染Top
     *
     * @return string
     */
    public function renderTop()
    {
        return "";
    }

    // **************************************************
    // 支持 底部扩展
    // **************************************************

    protected $contentBottom = "";

    /**
     * If grid allows Bottom
     *
     * @return bool
     */
    public function allowBottom()
    {
        return $this->option('useBottom');
    }

    /**
     * Enable Bottom.
     *
     * @return $this
     */
    public function enableBottom()
    {
        return $this->option('useBottom', true);
    }

    /**
     * 设定Bottom内容
     *
     * @param $content
     */
    public function setBottom($content)
    {
        $this->contentBottom = $content;
    }

    /**
     * 渲染Bottom
     *
     * @return string
     */
    public function renderBottom()
    {
        if ($this->allowBottom())
        {
            return $this->content_bottom;
        }

        return "";
    }

    // **************************************************
    // 支持 返回导航按钮
    // **************************************************

    protected $back_to_list_url;

    public function setBackToListURL($url)
    {
        $this->back_to_list_url = $url;
    }

    /**
     * If grid allows print
     *
     * @return bool
     */
    public function allowBackToList()
    {
        return $this->option('useBackToList');
    }

    /**
     * Disable print.
     *
     * @return $this
     */
    public function enableBackToList()
    {
        return $this->option('useBackToList', true);
    }

    /**
     * 渲染打印按钮
     *
     * @return BackToListButton
     */
    public function renderBackToListButton()
    {
        $button = new BackToListButton($this);
        $button->setURL($this->back_to_list_url);

        return $button;
    }

    // **************************************************
    // 支持 打印按钮
    // **************************************************

    /**
     * If grid allows print
     *
     * @return bool
     */
    public function allowPrinter()
    {
        return $this->option('usePrinter');
    }

    /**
     * Disable print.
     *
     * @return $this
     */
    public function enablePrinter()
    {
        return $this->option('usePrinter', true);
    }

    /**
     * 渲染打印按钮
     *
     * @return PrintButton
     */
    public function renderPrintButton()
    {
        return new PrintButton($this);
    }

    /**
     * 出发打印链接
     *
     * @param int $scope
     * @param null $args
     * @return string
     */
    public function printUrl($scope = 1, $args = null)
    {
        $input = array_merge(Input::all(), PrinterManager::formatPrintQuery($scope, $args));

        return $this->resource().'?'.http_build_query($input);
    }

    // **************************************************
    // 支持 自定义打印
    // **************************************************

    /**
     * Export driver.
     *
     * @var string
     */
    protected $printer;

    /**
     * Set printer driver for Grid to print.
     *
     * @param $printer
     *
     * @return $this
     */
    public function printer($printer)
    {
        $this->printer = $printer;

        return $this;
    }

    /**
     * Setup grid printer.
     *
     * @return void
     */
    protected function setupPrinter()
    {
        if ($scope = Input::get(PrinterManager::$queryName)) {
            $this->model()->usePaginate(false);

            call_user_func($this->builder, $this);

            (new PrinterManager($this))->resolve($this->printer)->withScope($scope)->run();
        }
    }

    // **************************************************
    // 支持 新的导出能力
    // **************************************************
    /**
     * Setup grid exporter.
     *
     * @return void
     */
    protected function setupExporter()
    {
        if ($scope = Input::get(ExtendedExporter::$queryName))
        {
            $this->model()->usePaginate(false);

            (new ExtendedExporter($this))->resolve($this->exporter)->withScope($scope)->export();
        }
    }

    // **************************************************
    // 支持 title
    // **************************************************

    protected $title;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * If grid allows print
     *
     * @return bool
     */
    public function allowTitle()
    {
        return $this->option('useTitle');
    }

    /**
     * Disable print.
     *
     * @return $this
     */
    public function enableTitle()
    {
        return $this->option('useTitle', true);
    }

    /**
     * 渲染打印按钮
     *
     * @return BackToListButton
     */
    public function renderTitle()
    {
        return $this->title;
    }

    // **************************************************
    // 支持 toolbar
    // **************************************************

    /**
     * 左侧工具条
     * @var Toolbar
     */
    protected $toolbarLeft;

    /**
     * 右侧工具条
     * @var Toolbar
     */
    protected $toolbarRight;

    /**
     * Setup grid left toolbar.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function toolbarLeft(Closure $callback)
    {
        call_user_func($callback, $this->toolbarLeft);
    }

    public function renderToolbarLeft()
    {
        return $this->toolbarLeft->render();
    }

    /**
     * Setup grid right toolbar.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function toolbarRight(Closure $callback)
    {
        call_user_func($callback, $this->toolbarRight);
    }

    public function renderToolbarRight()
    {
        return $this->toolbarRight->render();
    }

    /**
     * Setup grid toolbars.
     */
    public function setupToolbars()
    {
        $this->toolbarLeft = new Toolbar($this);

        $this->toolbarRight = new Toolbar($this);
    }

    // **************************************************
    // 支持 设定container的class
    // **************************************************
    protected $containerClass = "box box-info";

    public function containerClass()
    {
        return $this->containerClass;
    }

    /**
     * @param string $containerClass
     */
    public function setContainerClass(string $containerClass)
    {
        $this->containerClass = $containerClass;
    }

    // **************************************************
    // 支持 设定table的class
    // **************************************************
    protected $tableClass = "table table-hover table-bordered";

    /**
     * @return string
     */
    public function tableClass()
    {
        return $this->tableClass;
    }

    /**
     * @param string $tableClass
     */
    public function setTableClass(string $tableClass)
    {
        $this->tableClass = $tableClass;
    }
}