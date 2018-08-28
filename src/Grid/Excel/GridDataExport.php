<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;

class GridDataExport implements FromCollection
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }
}