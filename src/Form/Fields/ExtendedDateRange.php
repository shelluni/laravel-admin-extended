<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Form\Fields;

use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form\Field\DateRange;

class ExtendedDateRange extends DateRange
{
    protected $view = "admin_extended::form.extended_daterange";

    protected $start;
    protected $end;

    /**
     * 设定开始时间默认值
     *
     * @param $value
     * @return $this
     */
    public function start($value)
    {
        $this->start = $value;

        return $this;
    }

    /**
     * 设定结束时间默认值
     *
     * @param $value
     * @return $this
     */
    public function end($value)
    {
        $this->end = $value;

        return $this;
    }

    public function render()
    {
        $this->options['locale'] = config('app.locale');

        $startOptions = json_encode($this->options);
        $endOptions = json_encode($this->options + ['useCurrent' => false]);

        $startDate = "";
        $endDate   = "";

        // 先确定数据库中的数值
        if (is_array($this->value) && array_key_exists('start', $this->value))
        {
            $startDate = empty($this->value['start']) ? "" : Carbon::parse($this->value['start'])->toDateString();
        }

        if (is_array($this->value) && array_key_exists('end', $this->value))
        {
            $endDate = empty($this->value['end']) ? "" : Carbon::parse($this->value['end'])->toDateString();
        }

        // 如果还是空，再根据default设定
        if (empty($startDate))
        {
            $startDate = empty($this->start) ? "" : Carbon::parse($this->start)->toDateString();
        }

        if (empty($endDate))
        {
            $endDate = empty($this->end) ? "" : Carbon::parse($this->end)->toDateString();
        }

        // 元素的class
        $class = $this->getElementClassSelector();

        $this->script = <<<EOT
            $("{$class['start']}").val("$startDate");
            $("{$class['end']}").val("$endDate");
            $("{$class['start']}").datetimepicker($startOptions);
            $("{$class['end']}").datetimepicker($endOptions);
            $("{$class['start']}").on("dp.change", function (e) {
                $("{$class['end']}").data("DateTimePicker").minDate(e.date);
            });
            $("{$class['end']}").on("dp.change", function (e) {
                $("{$class['start']}").data("DateTimePicker").maxDate(e.date);
            });
EOT;

        Admin::script($this->script);

        return view($this->getView(), $this->variables());
    }
}