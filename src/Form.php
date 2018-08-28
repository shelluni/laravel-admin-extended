<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin;

use Closure;
use Shelluni\Admin\Form\Builder;

/**
 * Class Form.
 *
 * @method \Shelluni\Admin\Form\Fields\ExtendedMultipleImage extMultipleImage($column, $label = '')
 * @method \Shelluni\Admin\Form\Fields\ExtendedDateRange extDateRange($start, $end, $label = '')
 * @method \Shelluni\Admin\Form\Fields\MultipleSelectHidden extHidden($column, $label = '')
 */
class Form extends \Encore\Admin\Form
{
    // **************************************************
    // 支持 新的模板
    // **************************************************

    /**
     * View for this form.
     *
     * @var string
     */
    protected $view = 'admin_extended::form';

    // **************************************************
    // 支持 自定义的提交后跳转的地址
    // **************************************************

    /**
     * 提交后跳转的地址
     * @var
     */
    protected $redirect_url;

    /**
     * 设定提交后跳转的地址
     * @param $url
     */
    public function setRedirectURL($url)
    {
        $this->redirect_url = $url;
    }

    /**
     * 新建后跳转
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectAfterStore()
    {
        if (empty($this->redirect_url))
        {
            return parent::redirectAfterStore();
        }

        admin_toastr(trans('admin.save_succeeded'));

        // get redirect url
        $id = $this->model()->id;
        $url = str_replace("{id}", $id, $this->redirect_url);

        return redirect($url);
    }

    /**
     * 更新后跳转
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectAfterUpdate()
    {
        if (empty($this->redirect_url))
        {
            return parent::redirectAfterUpdate();
        }

        admin_toastr(trans('admin.update_succeeded'));

        // get redirect url
        $id = $this->model()->id;
        $url = str_replace("{id}", $id, $this->redirect_url);

        return redirect($url);
    }

    // **************************************************
    // 支持 提交按钮改名
    // **************************************************
    public $button_text_validate = "admin.submit_validate";
    public $button_text_save     = "admin.submit";

    public function setSubmitButtonText($text)
    {
        //$this->button_text_validate = $text;
        $this->button_text_save     = $text;
    }

    public function setButtonTextValidate($text)
    {
        $this->button_text_validate = $text;
    }

    public function setButtonTextSave($text)
    {
        $this->button_text_save = $text;
    }

    // **************************************************
    // 支持 取消按钮
    // **************************************************
    /**
     * Disable form reset.
     *
     * @return $this
     */
    public function disableCancel()
    {
        $this->builder()->options(['enableCancel' => false]);

        return $this;
    }

    // **************************************************
    // 构造函数 支持 新的builder
    // **************************************************

    /**
     * Create a new form instance.
     *
     * @param $model
     * @param \Closure $callback
     */
    public function __construct($model, Closure $callback)
    {
        $this->model = $model;

        $this->builder = new Builder($this);

        $callback($this);
    }

    // **************************************************
    // 支持 修改title
    // **************************************************

    public $title;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    // **************************************************
    // 支持 修改container的css
    // **************************************************
    protected $containerClass = "box box-info";

    /**
     * @return string
     */
    public function getContainerClass(): string
    {
        return $this->containerClass;
    }

    /**
     * @param string $containerClass
     */
    public function setContainerClass(string $containerClass)
    {
        $this->containerClass = $containerClass;
    }

    // **************************************************
    // 支持 修改container header的css
    // **************************************************
    protected $containerHeaderClass = "with-border";

    /**
     * @return string
     */
    public function getContainerHeaderClass(): string
    {
        return $this->containerHeaderClass;
    }

    /**
     * @param string $containerHeaderClass
     */
    public function setContainerHeaderClass(string $containerHeaderClass)
    {
        $this->containerHeaderClass = $containerHeaderClass;
    }

    // **************************************************
    // 支持 新的模板
    // **************************************************
    public function inputRemove($name)
    {
        if (array_key_exists($name, $this->inputs))
        {
            unset($this->inputs[$name]);
        }
    }


}