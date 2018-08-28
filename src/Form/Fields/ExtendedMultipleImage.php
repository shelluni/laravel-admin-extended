<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Form\Fields;

use App\Helper\CommonHelper;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form\Field\ImageField;
use Encore\Admin\Form\Field\MultipleImage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ExtendedMultipleImage extends MultipleImage
{
    use ImageField;

    protected $view = "admin_extended::form.extended_multiplefile";

    protected $rules = '';

    protected static $js = [
        '/vendor/laravel-admin/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js?v=4.4.6',
        '/vendor/laravel-admin/bootstrap-fileinput/js/fileinput.min.js?v=4.4.6',
        '/vendor/laravel-admin/bootstrap-fileinput/js/locales/zh.js?v=4.4.6',
    ];

    /***************************************
     * 以下代码用于处理Ajax请求
     ***************************************/

    /**
     * Prepare for each file.
     *
     * @param UploadedFile|null $image
     * @return mixed
     */
    protected function uploadForeach(UploadedFile $image = null)
    {
        $this->name = $this->getStoreName($image);

        $this->callInterventionMethods($image->getRealPath());

        return tap($this->upload($image), function () {
            // $this->name = null;
        });
    }

    /**
     * 手动上传
     *
     * @param $files
     * @return mixed|string
     */
    public function uploadManually($files)
    {
        tap($this->value, function () use ($files) {
            $this->value = array_map([$this, 'uploadForeach'], (array)$files);
        });

        $config = $this->initialPreviewConfig();

        $ret = [
            "initialPreview" => array_map([$this, 'objectUrl'], $this->value),
            "initialPreviewAsData" => true,
            "initialPreviewConfig" => $config,
        ];

        return $ret;
    }

    /***************************************
     * 以下代码用于Form提交
     ***************************************/

    /**
     * Prepare for saving.
     *
     * @param UploadedFile|array $files
     * @return mixed|string
     */
    public function prepare($files)
    {
        Log::info("ExtendedMultipleImage prepare files    = ", (array)$files);
        Log::info("ExtendedMultipleImage prepare original = ", (array)$this->original());

        $files     = empty($files) ? [] : $files;
        $originals = empty($this->original()) ? [] : $this->original();

        $files = CommonHelper::clearArrayNullValue($files);

        // 找到删除的
        $deleted_files = array_diff($originals, $files);
        Log::info("ExtendedMultipleImage prepare deleted = ", $deleted_files);
        foreach ($deleted_files as $deleted_file)
        {
            $this->storage->delete($deleted_file);
        }

        return $files;
    }

    /**
     * @return array
     */
    protected function initialPreviewConfig()
    {
        $files = $this->value ?: [];

        $config = [];

        $token = csrf_token();

        foreach ($files as $index => $file) {
            $config[] = [
                'caption' => "",
                'key'     => $file,
                'url'     => admin_url("image/delete"),
                'extra'   => ['_token' => $token],
            ];
        }

        return $config;
    }



    /**
     * Set default options form image field.
     *
     * @return void
     */
    protected function setupDefaultOptions()
    {
        $defaultOptions = [
            'overwriteInitial'     => false,
            'initialPreviewAsData' => true,
            'browseLabel'          => trans('admin.browse'),
            'showRemove'           => false,
            'showUpload'           => false,
        ];

        $this->options($defaultOptions);
    }

    /**
     * Render file upload field.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $this->attribute('multiple', true);

        $this->setupDefaultOptions();

        if (!empty($this->value)) {
            $this->options(['initialPreview' => $this->preview()]);
            $this->options(['allowedFileTypes' => ['image']]);
            $this->setupPreviewOptions();
        }

        $options = json_encode($this->options);

        $this->script = <<<EOT
        
var uploader = "input{$this->getElementClassSelector()}";
var hiddens  = "#div_{$this->formatName($this->column)}";
$(uploader)
    .fileinput({$options})
    .on("filebatchselected", function(event, files) {
        console.log('filebatchselected');
        $(uploader).fileinput("upload");
    })
    .on('filebatchuploadsuccess', function(event, data) {
        console.log('filebatchuploadsuccess');
        console.log(data.response.initialPreview);
        
        var configs = data.response.initialPreviewConfig;
        configs.forEach(function (config) {
            console.log("upload new image");
            console.log(config);
            $(hiddens).append('<input type="hidden" name="{$this->formatName($this->column)}[]" value="' + config.key + '" />');
        });
    })
    .on("filebatchuploadcomplete", function(event, files, extra) {
        console.log('filebatchuploadcomplete');
        console.log(files);
        console.log(extra);
    })
    .on('filedeleted', function(event, key, jqXHR, data) {
        console.log('filedeleted key = ' + key);
        $('#div_images input').each(function() { 
            if ($(this).val() == key)
            {
                $(this).remove()
            };
        });
    })
EOT;

        Admin::script($this->script);

        return view($this->view, $this->variables());
    }
}