<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Widgets;

use Closure;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Form\Field;
use Shelluni\Admin\Form\Builder;

/*
 * TODO 1# in dialog 更加简单的支持RowSelection模式
 * TODO 2# in dialog 写phpunit
 */

/**
 * Class Dialog.
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
 * @method Field\SwitchField    switch($name, $label = '')
 * @method Field\Display        display($name, $label = '')
 * @method Field\Rate           rate($name, $label = '')
 * @method Field\Divide         divide()
 * @method Field\Decimal        decimal($column, $label = '')
 * @method Field\Html           html($html)
 * @method Field\Tags           tags($column, $label = '')
 * @method Field\Icon           icon($column, $label = '')
 */
class Dialog
{
    const DIALOG_OPENER_MODE_BUTTON = 1;
    const DIALOG_OPENER_MODE_LINK   = 2;

    /**
     * @var mixed
     */
    public $uniqueId = "";

    /**
     * @var mixed
     */
    public $openerMode = self::DIALOG_OPENER_MODE_BUTTON;

    /**
     * Action of form.
     *
     * @var string
     */
    public $action;

    /**
     * Support Row Selections
     *
     * @var bool
     */
    public $supportRowSelection = false;

    /**
     * The Selected Row Name Index In Tr
     *
     * @var
     */
    public $rowSelectionNameIndex = 1;

    /**
     * Dialog Title
     *
     * @var string
     */
    public $dialogTitle = "";

    /**
     * Opener Button Class
     *
     * @var string
     */
    public $openerButtonClass = "btn-sm btn-primary";

    /**
     * Opener Button Icon
     *
     * @var string
     */
    public $openerButtonIcon = "fa-filter";

    /**
     * Opener Button Text
     *
     * @var string
     */
    public $openerButtonText = "";

    /**
     * Has Submit Button
     *
     * @var bool
     */
    public $hasSubmitButton = true;

    /**
     * Submit Button Class
     *
     * @var string
     */
    public $submitButtonClass = "btn-primary";

    /**
     * Submit Button Text
     *
     * @var string
     */
    public $submitButtonText = "";

    /**
     * Has Cancel Button
     *
     * @var bool
     */
    public $hasCancelButton = true;

    /**
     * Cancel Button Class
     *
     * @var string
     */
    public $cancelButtonClass = "btn-default";

    /**
     * Cancel Button Text
     *
     * @var string
     */
    public $cancelButtonText = "";

    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $view = 'admin_extended::widgets.dialog';

    /**
     * Create a new dialog instance.
     *
     * @param \Closure $callback
     */
    public function __construct(Closure $callback)
    {
        $this->submitButtonText = trans("admin.save");
        $this->cancelButtonText = trans("admin.cancel");

        $this->uniqueId = uniqid();

        $callback($this);
    }

    /* ---------------------------------------
     * Form
     * --------------------------------------- */

    /**
     * Generate a Field object and add to form builder if Field exists.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if ($className = static::findFieldClass($method)) {
            $column = array_get($arguments, 0, ''); //[0];

            $element = new $className($column, array_slice($arguments, 1));

            $this->pushField($element);

            return $element;
        }
    }

    /**
     * Find field class.
     *
     * @param string $method
     *
     * @return bool|mixed
     */
    public static function findFieldClass($method)
    {
        $class = array_get(Form::$availableFields, $method);

        if (class_exists($class)) {
            return $class;
        }

        return false;
    }

    /**
     * Add a form field to form.
     *
     * @param Field $field
     *
     * @return $this
     */
    protected function pushField(Field &$field)
    {
        array_push($this->fields, $field);

        return $this;
    }

    /* ---------------------------------------
     * Fields
     * --------------------------------------- */

    /**
     * Get fields.
     *
     * @return Field[]
     */
    public function fields()
    {
        return $this->fields;
    }

    /**
     * Get specify field.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function field($name)
    {
        return $this->fields()->first(function (Field $field) use ($name) {
            return $field->column() == $name;
        });
    }

    public function addPreviousField()
    {
        //Log::info('addRedirectUrlField');

        $previous = url()->full();

        //Log::info("addRedirectUrlField $previous");

        if (empty($previous)) {
            return;
        }

        $this->fields[] = (new Field\Hidden(Builder::PREVIOUS_URL_KEY))->value($previous);
    }

    /* ---------------------------------------
     * Render
     * --------------------------------------- */

    /**
     * Get the string contents of the view.
     *
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        if ($this->supportRowSelection)
        {
            $script = <<<SCRIPT
$('#dialog-opener-{$this->uniqueId}').click(function () {

    console.log('#dialog-{$this->uniqueId} .display_row_selected_names');
    
    // selectIds
    var selectedIDs = [];
    $('.grid-row-checkbox:checked').each(function(){
        selectedIDs.push($(this).data('id'));
    });

    $('#dialog-{$this->uniqueId} [name=row_selected_ids]').val(selectedIDs);
    
    // selectNames
    var selectedNames = [];
    $('.grid-row-checkbox:checked').each(function(){
        selectedNames.push($.trim($(this).parent().parent().parent().children('td:eq({$this->rowSelectionNameIndex})').text()));
    });
    
    $('#dialog-{$this->uniqueId}').find('.display_row_selected_names').html(selectedNames.join(" / ") + "&nbsp;");
});

var selectedRowsID = function () {

}

var selectedRowsName = function () {

}

SCRIPT;
            Admin::script($script);
        }

        return view($this->view)->with([
            'action'  => $this->action,
            'dialog' => $this,
        ])->render();
    }

    /**
     * Get the string contents of the view.
     *
     * @return string
     * @throws \Throwable
     */
    public function __toString()
    {
        return $this->render();
    }

    /* ---------------------------------------
     * Basic Setting
     * --------------------------------------- */

    /**
     * 设置
     *
     * @param $openerMode
     * @return $this
     */
    public function setOpenerMode($openerMode)
    {
        $this->openerMode = $openerMode;

        return $this;
    }

    /**
     * Set action of search form.
     *
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function setDialogTitle($title)
    {
        $this->dialogTitle = $title;

        return $this;
    }

    public function setSupportRowSelection($supportRowSelection)
    {
        $this->supportRowSelection = $supportRowSelection;

        return $this;
    }

    public function setRowSelectionNameIndex($rowSelectionNameIndex)
    {
        $this->rowSelectionNameIndex = $rowSelectionNameIndex;

        return $this;
    }

    /* ---------------------------------------
     * Opener Button
     * --------------------------------------- */

    public function setOpenerButtonClass($openerButtonClass)
    {
        $this->openerButtonClass = $openerButtonClass;

        return $this;
    }

    public function setOpenerButtonText($openerButtonText)
    {
        $this->openerButtonText = $openerButtonText;

        return $this;
    }

    public function setOpenerButtonIcon($openerButtonIcon)
    {
        $this->openerButtonIcon = $openerButtonIcon;

        return $this;
    }

    /* ---------------------------------------
     * Submit Button
     * --------------------------------------- */

    public function setHasSumbitButton($hasSubmitButton)
    {
        $this->hasSubmitButton = $hasSubmitButton;

        return $this;
    }

    public function setSubmitButtonClass($submitButtonClass)
    {
        $this->submitButtonClass = $submitButtonClass;

        return $this;
    }

    public function setSubmitButtonText($submitButtonText)
    {
        $this->submitButtonText = $submitButtonText;

        return $this;
    }

    /* ---------------------------------------
     * Cancel Button
     * --------------------------------------- */

    public function setHasCancelButton($hasCancelButton)
    {
        $this->hasCancelButton = $hasCancelButton;

        return $this;
    }

    public function setCancelButtonClass($cancelButtonClass)
    {
        $this->cancelButtonClass = $cancelButtonClass;

        return $this;
    }

    public function setCancelButtonText($cancelButtonText)
    {
        $this->cancelButtonText = $cancelButtonText;

        return $this;
    }

    /* ---------------------------------------
     * Form
     * --------------------------------------- */
    public function form(Closure $callback)
    {
        $callback($this);
    }
}
