<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid;

use Encore\Admin\Grid;

class ExtendedExporter
{
    /**
     * Export scope constants.
     */
    const SCOPE_ALL = 'all';
    const SCOPE_CURRENT_PAGE = 'page';
    const SCOPE_SELECTED_ROWS = 'selected';

    /**
     * @var Grid
     */
    protected $grid;

    /**
     * Available exporter drivers.
     *
     * @var array
     */
    protected static $drivers = [];

    /**
     * Export query name.
     *
     * @var string
     */
    public static $queryName = '_export_';

    /**
     * Create a new ExtendedExporter instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;

        $this->grid->model()->usePaginate(false);
    }

    /**
     * Set export query name.
     *
     * @param $name
     */
    public static function setQueryName($name)
    {
        static::$queryName = $name;
    }

    /**
     * Extends new exporter driver.
     *
     * @param $driver
     * @param $extend
     */
    public static function extend($driver, $extend)
    {
        static::$drivers[$driver] = $extend;
    }

    /**
     * Resolve export driver.
     *
     * @param $driver
     * @return Grid\Exporters\AbstractExporter
     */
    public function resolve($driver)
    {
        if ($driver instanceof Grid\Exporters\AbstractExporter)
        {
            return $driver->setGrid($this->grid);
        }

        return $this->getExporter($driver);
    }

    /**
     * Get export driver.
     *
     * @param string $driver
     *
     * @return ExcelExporter
     */
    protected function getExporter($driver)
    {
        if (!array_key_exists($driver, static::$drivers)) {
            return $this->getDefaultExporter();
        }

        return new static::$drivers[$driver]($this->grid);
    }

    /**
     * Get default exporter.
     *
     * @return ExcelExporter
     */
    public function getDefaultExporter()
    {
        return new ExcelExporter($this->grid);
    }

    /**
     * Format query for export url.
     *
     * @param string $scope
     * @param null $args
     * @return array
     */
    public static function formatExportQuery($scope = '', $args = null)
    {
        $query = '';

        if ($scope == static::SCOPE_ALL) {
            $query = 'all';
        }

        if ($scope == static::SCOPE_CURRENT_PAGE) {
            $query = "page:$args";
        }

        if ($scope == static::SCOPE_SELECTED_ROWS) {
            $query = "selected:$args";
        }

        return [static::$queryName => $query];
    }
}
