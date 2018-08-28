<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin;

use Encore\Admin\Grid\Displayers\RowSelector;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Jenssegers\Mongodb\Eloquent\Model as MongodbModel;
use Shelluni\Admin\Grid\Column as ExtendedColumn;
use Shelluni\Admin\Traits\GridUITrait;

class Grid extends \Encore\Admin\Grid
{
    use GridUITrait;

    // **************************************************
    // 支持 新的模板
    // **************************************************

    /**
     * View for grid to render.
     *
     * @var string
     */
    protected $view = 'admin_extended::grid.table';

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
     * @param \Closure  $builder
     */
    public function __construct(Eloquent $model, \Closure $builder)
    {
        parent::__construct($model, $builder);

        $this->setupPrinter();
        $this->setupToolbars();
    }

    // **************************************************
    // 与column相关函数
    // **************************************************

    /**
     * Add column to Grid.
     *
     * @param string $name
     * @param string $label
     *
     * @return ExtendedColumn
     */
    public function column($name, $label = '')
    {
        $relationName = $relationColumn = '';

        if (strpos($name, '.') !== false) {
            list($relationName, $relationColumn) = explode('.', $name);

            $relation = $this->model()->eloquent()->$relationName();

            $label = empty($label) ? ucfirst($relationColumn) : $label;

            $name = snake_case($relationName).'.'.$relationColumn;
        }

        $column = $this->addColumn($name, $label);

        if (isset($relation) && $relation instanceof Relation) {
            $this->model()->with($relationName);
            $column->setRelation($relationName, $relationColumn);
        }

        return $column;
    }

    /**
     * Add column to grid.
     *
     * @param string $column
     * @param string $label
     *
     * @return ExtendedColumn
     */
    protected function addColumn($column = '', $label = '')
    {
        $column = new ExtendedColumn($column, $label);
        $column->setGrid($this);

        return $this->columns[] = $column;
    }

    /**
     * Prepend checkbox column for grid.
     *
     * @return void
     */
    protected function prependRowSelectorColumn()
    {
        if (!$this->option('useRowSelector')) {
            return;
        }

        $grid = $this;

        $column = new ExtendedColumn(ExtendedColumn::SELECT_COLUMN_NAME, ' ');
        $column->setGrid($this);

        $column->display(function ($value) use ($grid, $column) {
            $actions = new RowSelector($value, $grid, $column, $this);

            return $actions->display();
        });

        $this->columns->prepend($column);
    }

    /**
     * Build the grid.
     *
     * @return void
     */
    public function build()
    {
        if ($this->builded) {
            return;
        }

        $data = $this->processFilter();

        $this->prependRowSelectorColumn();
        $this->appendActionsColumn();

        ExtendedColumn::setOriginalGridData($data);

        $this->columns->map(function (ExtendedColumn $column) use (&$data) {
            $data = $column->fill($data);

            $this->columnNames[] = $column->getName();
        });

        $this->buildRows($data);

        $this->builded = true;
    }

    /**
     * Handle table column for grid.
     *
     * @param string $method
     * @param string $label
     *
     * @return bool|ExtendedColumn
     */
    protected function handleTableColumn($method, $label)
    {
        if (empty($this->dbColumns)) {
            $this->setDbColumns();
        }

        if ($this->dbColumns->has($method)) {
            return $this->addColumn($method, $label);
        }

        return false;
    }

    /**
     * Handle get mutator column for grid.
     *
     * @param string $method
     * @param string $label
     *
     * @return bool|ExtendedColumn
     */
    protected function handleGetMutatorColumn($method, $label)
    {
        if ($this->model()->eloquent()->hasGetMutator($method)) {
            return $this->addColumn($method, $label);
        }

        return false;
    }

    /**
     * Handle relation column for grid.
     *
     * @param string $method
     * @param string $label
     *
     * @return bool|ExtendedColumn
     */
    protected function handleRelationColumn($method, $label)
    {
        $model = $this->model()->eloquent();

        if (!method_exists($model, $method)) {
            return false;
        }

        if (!($relation = $model->$method()) instanceof Relation) {
            return false;
        }

        if ($relation instanceof HasOne || $relation instanceof BelongsTo) {
            $this->model()->with($method);

            return $this->addColumn($method, $label)->setRelation(snake_case($method));
        }

        if ($relation instanceof HasMany || $relation instanceof BelongsToMany || $relation instanceof MorphToMany) {
            $this->model()->with($method);

            return $this->addColumn(snake_case($method), $label);
        }

        return false;
    }

    /**
     * Dynamically add columns to the grid view.
     *
     * @param $method
     * @param $arguments
     *
     * @return ExtendedColumn
     */
    public function __call($method, $arguments)
    {
        $label = isset($arguments[0]) ? $arguments[0] : ucfirst($method);

        if ($this->model()->eloquent() instanceof MongodbModel) {
            return $this->addColumn($method, $label);
        }

        if ($column = $this->handleGetMutatorColumn($method, $label)) {
            return $column;
        }

        if ($column = $this->handleRelationColumn($method, $label)) {
            return $column;
        }

        if ($column = $this->handleTableColumn($method, $label)) {
            return $column;
        }

        return $this->addColumn($method, $label);
    }

    /**
     * Register column displayers.
     *
     * @return void.
     */
    public static function registerColumnDisplayer()
    {
        $map = [
            'editable'    => \Encore\Admin\Grid\Displayers\Editable::class,
            'switch'      => \Encore\Admin\Grid\Displayers\SwitchDisplay::class,
            'switchGroup' => \Encore\Admin\Grid\Displayers\SwitchGroup::class,
            'select'      => \Encore\Admin\Grid\Displayers\Select::class,
            'image'       => \Encore\Admin\Grid\Displayers\Image::class,
            'label'       => \Encore\Admin\Grid\Displayers\Label::class,
            'button'      => \Encore\Admin\Grid\Displayers\Button::class,
            'link'        => \Encore\Admin\Grid\Displayers\Link::class,
            'badge'       => \Encore\Admin\Grid\Displayers\Badge::class,
            'progressBar' => \Encore\Admin\Grid\Displayers\ProgressBar::class,
            'radio'       => \Encore\Admin\Grid\Displayers\Radio::class,
            'checkbox'    => \Encore\Admin\Grid\Displayers\Checkbox::class,
            'orderable'   => \Encore\Admin\Grid\Displayers\Orderable::class,
        ];

        foreach ($map as $abstract => $class) {
            ExtendedColumn::extend($abstract, $class);
        }
    }
}