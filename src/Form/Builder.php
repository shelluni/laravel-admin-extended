<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Form;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Shelluni\Admin\Form;
use Shelluni\Admin\Form\Tools as ExtendTools;

class Builder extends \Encore\Admin\Form\Builder
{
    // **************************************************
    // 支持 新的模板
    // **************************************************

    /**
     * View for this form.
     *
     * @var string
     */
    protected $view = 'admin.form';

    // **************************************************
    // 新的options
    // 支持 cancel按钮
    // **************************************************

    /**
     * @var array
     */
    protected $options = [
        'enableSubmit' => true,
        'enableReset'  => false,
        'enableCancel' => false,
    ];

    // **************************************************
    // 构造函数 支持 新的form
    // **************************************************

    /**
     * Builder constructor.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;

        $this->fields = new Collection();

        $this->setupTools();
    }

    // **************************************************
    // 支持 新的tools
    // **************************************************

    /**
     * Setup grid tools.
     */
    public function setupTools()
    {
        $this->tools = new ExtendTools($this);
    }

    // **************************************************
    // 支持 提交按钮改名
    // **************************************************

    /**
     * Submit button of form..
     *
     * @return string
     */
    public function submitButton()
    {
        if ($this->mode == self::MODE_VIEW) {
            return '';
        }

        if (!$this->options['enableSubmit']) {
            return '';
        }

        $text_save = trans($this->form->button_text_save);

        return <<<EOT
<div class="btn-group pull-right">
    <button type="submit" class="btn btn-info" value="save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> $text_save"><i class="fa fa-save"></i>&nbsp;$text_save</button>
</div>
EOT;
    }

    // **************************************************
    // 支持 取消按钮
    // **************************************************

    /**
     * Canel button of form..
     *
     * @return string
     */
    public function cancelButton()
    {
        if ($this->mode == self::MODE_VIEW) {
            return '';
        }

        if (!$this->options['enableCancel']) {
            return '';
        }

        $slice = Str::contains($this->getResource(0), '/edit') ? null : -1;
        $resource = $this->getResource($slice);

        $text = trans('admin.cancel');

        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="$resource" class="btn btn-default"><i class="fa fa-close"></i>&nbsp;$text</a>
</div>
EOT;
    }

    // **************************************************
    // 支持 修改title
    // **************************************************

    /**
     * 修改title
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function title()
    {
        if (!empty($this->form->title))
        {
            return $this->form->title;
        }

        if ($this->mode == static::MODE_CREATE) {
            return trans('admin.create');
        }

        if ($this->mode == static::MODE_EDIT) {
            return trans('admin.edit');
        }

        if ($this->mode == static::MODE_VIEW) {
            return trans('admin.view');
        }

        return '';
    }

    // **************************************************
    // 支持 修改container的css
    // **************************************************
    public function containerClass()
    {
        return $this->form->getContainerClass();
    }

    // **************************************************
    // 支持 修改container header的css
    // **************************************************
    public function containerHeaderClass()
    {
        return $this->form->getContainerHeaderClass();
    }
}