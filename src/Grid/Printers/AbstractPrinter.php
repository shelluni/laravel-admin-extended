<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Printers;

use Shelluni\Admin\Grid;

abstract class AbstractPrinter implements PrinterInterface
{
    /**
     * @var \Shelluni\Admin\Grid
     */
    protected $grid;

    /**
     * Create a new exporter instance.
     *
     * @param $grid
     */
    public function __construct(Grid $grid = null)
    {
        if ($grid) {
            $this->setGrid($grid);
        }
    }

    /**
     * Set grid for exporter.
     *
     * @param Grid $grid
     *
     * @return $this
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * Get table of grid.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->grid->model()->eloquent()->getTable();
    }

    /**
     * Get data with export query.
     *
     * @return array
     */
    public function getData()
    {
        return $this->grid->getFilter()->execute();
    }

    /**
     * Export data with scope.
     *
     * @param string $scope
     *
     * @return $this
     */
    public function withScope($scope)
    {
        if ($scope == Grid\PrinterManager::SCOPE_ALL)
        {
            return $this;
        }

        list($scope, $args) = explode(':', $scope);

        if ($scope == Grid\PrinterManager::SCOPE_CURRENT_PAGE)
        {
            $this->grid->model()->usePaginate(true);
        }

        if ($scope == Grid\PrinterManager::SCOPE_SELECTED_ROWS)
        {
            $selected = explode(',', $args);
            $this->grid->model()->whereIn($this->grid->getKeyName(), $selected);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function run();
}
