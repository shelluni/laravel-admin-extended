<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid;

use Shelluni\Admin\Grid;
use Shelluni\Admin\Grid\Printers\AbstractPrinter;
use Shelluni\Admin\Grid\Printers\HtmlPrinter;

class PrinterManager
{
    /**
     * Print scope constants.
     */
    const SCOPE_ALL = 'all';
    const SCOPE_CURRENT_PAGE = 'page';
    const SCOPE_SELECTED_ROWS = 'selected';

    /**
     * @var Grid
     */
    protected $grid;

    /**
     * Available printer drivers.
     *
     * @var array
     */
    protected static $drivers = [];

    /**
     * Print query name.
     *
     * @var string
     */
    public static $queryName = '_print_';

    /**
     * Create a new PrinterManager instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;

        $this->grid->model()->usePaginate(false);
    }

    /**
     * Set print query name.
     *
     * @param $name
     */
    public static function setQueryName($name)
    {
        static::$queryName = $name;
    }

    /**
     * Extends new printer driver.
     *
     * @param $driver
     * @param $extend
     */
    public static function extend($driver, $extend)
    {
        static::$drivers[$driver] = $extend;
    }

    /**
     * Resolve print driver.
     *
     * @param $driver
     * @return AbstractPrinter
     */
    public function resolve($driver)
    {
        if ($driver instanceof AbstractPrinter) {
            return $driver->setGrid($this->grid);
        }

        return $this->getPrinter($driver);
    }

    /**
     * Get print driver.
     *
     * @param string $driver
     *
     * @return HtmlPrinter
     */
    protected function getPrinter($driver)
    {
        if (!array_key_exists($driver, static::$drivers)) {
            return $this->getDefaultPrinter();
        }

        return new static::$drivers[$driver]($this->grid);
    }

    /**
     * Get default printer.
     *
     * @return HtmlPrinter
     */
    public function getDefaultPrinter()
    {
        return new HtmlPrinter($this->grid);
    }

    /**
     * Format query for print url.
     *
     * @param string $scope
     * @param null $args
     * @return array
     */
    public static function formatPrintQuery($scope = '', $args = null)
    {
        $query = '';

        if ($scope == static::SCOPE_ALL)
        {
            $query = 'all';
        }

        if ($scope == static::SCOPE_CURRENT_PAGE)
        {
            $query = "page:$args";
        }

        if ($scope == static::SCOPE_SELECTED_ROWS)
        {
            $query = "selected:$args";
        }

        return [static::$queryName => $query];
    }
}
