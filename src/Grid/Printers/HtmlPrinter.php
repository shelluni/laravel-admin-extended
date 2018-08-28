<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Printers;

use Illuminate\Support\Arr;
use Shelluni\Admin\Grid;

class HtmlPrinter extends AbstractPrinter
{
    private $view = '';

    public function __construct(Grid $grid = null, $view='')
    {
        parent::__construct($grid);

        $this->view = $view;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        //$data = $this->getData();
        //var_dump($this->grid->getFilter()->get());die;
        echo view($this->view,['data'=>$this->grid->model()->get()]);die;
    }

    /**
     * Remove indexed array.
     *
     * @param array $row
     *
     * @return array
     */
    protected function sanitize(array $row)
    {
        return collect($row)->reject(function ($val) {
            return is_array($val) && !Arr::isAssoc($val);
        })->toArray();
    }
}
