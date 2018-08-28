<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Printers;

interface PrinterInterface
{
    /**
     * Export data from grid.
     *
     * @return mixed
     */
    public function run();
}
