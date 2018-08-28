<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid;

use Encore\Admin\Grid;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Shelluni\Admin\Grid\Excel\GridDataExport;

class ExcelExporter extends AbstractExporter
{
    public function __construct(Grid $grid = null)
    {
        parent::__construct($grid);
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        $filename = "export.xlsx";

        // 构建 获得数据
        $this->grid->build();

        // 数据
        $ret_rows = [];

        // 头部
        $titles = [];
        $wanted = [];
        $columns = $this->grid->columns();
        foreach ($columns as $column)
        {
            if ($column->getName() !== "__row_selector__" && $column->getName() !== "__custom_actions__" && $column->getName() !== "__more_info__")
            {
                $titles[] = $column->getLabel();
                $wanted[] = $column->getName();
            }
        }

        $ret_rows[] = array_values($titles);

        // 数据区
        $rows = $this->grid->rows();
        foreach ($rows as $row)
        {
            $fields = [];
            foreach ($wanted as $key)
            {
                $value = $row->column($key);

                $fields[] = strip_tags($value);
            }

            $ret_rows[] = array_values($fields);
        }

        $data = new GridDataExport($ret_rows);

        Excel::download($data, $filename);
    }
}