<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Widgets;

use Encore\Admin\Form\Field;
use Illuminate\Contracts\Support\Renderable;

/**
 * Class Form.
 *
 * @method Field\Text           text($name, $label = '')
 * @method Field\Password       password($name, $label = '')
 * @method Field\Checkbox       checkbox($name, $label = '')
 * @method Field\Radio          radio($name, $label = '')
 * @method Field\Select         select($name, $label = '')
 * @method Field\MultipleSelect multipleSelect($name, $label = '')
 * @method Field\Textarea       textarea($name, $label = '')
 * @method Field\Hidden         hidden($name, $label = '')
 * @method Field\Id             id($name, $label = '')
 * @method Field\Ip             ip($name, $label = '')
 * @method Field\Url            url($name, $label = '')
 * @method Field\Color          color($name, $label = '')
 * @method Field\Email          email($name, $label = '')
 * @method Field\Mobile         mobile($name, $label = '')
 * @method Field\Slider         slider($name, $label = '')
 * @method Field\Map            map($latitude, $longitude, $label = '')
 * @method Field\Editor         editor($name, $label = '')
 * @method Field\File           file($name, $label = '')
 * @method Field\Image          image($name, $label = '')
 * @method Field\Date           date($name, $label = '')
 * @method Field\Datetime       datetime($name, $label = '')
 * @method Field\Time           time($name, $label = '')
 * @method Field\DateRange      dateRange($start, $end, $label = '')
 * @method Field\DateTimeRange  dateTimeRange($start, $end, $label = '')
 * @method Field\TimeRange      timeRange($start, $end, $label = '')
 * @method Field\Number         number($name, $label = '')
 * @method Field\Currency       currency($name, $label = '')
 * @method Field\Json           json($name, $label = '')
 * @method Field\SwitchField    switch($name, $label = '')
 * @method Field\Display        display($name, $label = '')
 * @method Field\Rate           rate($name, $label = '')
 * @method Field\Divide         divide()
 * @method Field\Decimal        decimal($column, $label = '')
 * @method Field\Html           html($html, $label = '')
 * @method Field\Tags           tags($column, $label = '')
 * @method Field\Icon           icon($column, $label = '')
 * @method \Shelluni\Admin\Form\Fields\ExtendedMultipleImage extMultipleImage($column, $label = '')
 * @method \Shelluni\Admin\Form\Fields\ExtendedDateRange extDateRange($start, $end, $label = '')
 * @method \Shelluni\Admin\Form\Fields\MultipleSelectHidden extHidden($column, $label = '')
 */
class Form extends \Encore\Admin\Widgets\Form implements Renderable
{
    public $options=[
        'enable_reset'=>true,
        'enable_submit'=>true,
        'button_text_reset'=>'',
        'button_text_submit'=>'',
        'button_text_submit_position' => 'right'
    ];

    public function setSubmitButtonText($text)
    {
        $this->options['button_text_submit'] = $text;
    }

    public function setResetButtonText($text)
    {
        $this->options['button_text_reset'] = $text;
    }

    public function setSubmitButtonPosition($position)
    {
        $this->options['button_text_submit_position'] = $position;
    }

    // **************************************************
    // 支持 取消按钮
    // **************************************************
    /**
     * Disable form reset.
     *
     * @return $this
     */
    public function disableRest()
    {
        $this->options['enable_rest'] = false;

        return $this;
    }

    /**
     * Disable form reset.
     *
     * @return $this
     */
    public function disableSubmit()
    {
        $this->options['enable_submit'] = false;

        return $this;
    }

    /**
     * Get variables for render form.
     *
     * @return array
     */
    protected function getVariables()
    {
        foreach ($this->fields as $field) {
            $field->fill($this->data);
        }

        return [
            'fields'     => $this->fields,
            'attributes' => $this->formatAttribute(),
            'options' => $this->options,
        ];
    }

    /**
     * Render the form.
     *
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        return view('admin_extended::widgets.form', $this->getVariables())->render();
    }

}
