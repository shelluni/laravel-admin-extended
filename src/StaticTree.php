<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin;

use Closure;
use Encore\Admin\Facades\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Shelluni\Admin\Tree\StaticTreeTools;

class StaticTree implements Renderable
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $elementId = 'tree-';

    protected $title = '';

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var \Closure
     */
    protected $queryCallback;

    /**
     * View of tree to render.
     *
     * @var string
     */
    protected $view = [
        'tree'   => 'admin.tree.static_tree',
        'branch' => 'admin.tree.static_tree_branch',
    ];

    /**
     * @var \Closure
     */
    protected $callback;

    /**
     * @var null
     */
    protected $branchCallback = null;

    /**
     * the tree base id
     *
     * @var int
     */
    protected $baseId = 0;

    /**
     * @var bool
     */
    public $useCreate = true;

    /**
     * @var bool
     */
    public $useRefresh = true;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * Header tools.
     *
     * @var StaticTreeTools
     */
    public $tools;

    /**
     * Request Path
     *
     * @var array
     */
    protected $path = [];

    protected $keyName = "";

    /**
     * Menu constructor.
     *
     * @param Model|null $model
     * @param $parameters
     * @param \Closure $callback
     */
    public function __construct(Model $model = null, $parameters, \Closure $callback = null)
    {
        // model
        $this->model = $model;

        // parameters
        if (isset($parameters['keyName']))
        {
            $this->keyName = $parameters['keyName'];
        }
        else
        {
            $this->keyName = $this->model->getKeyName();
        }

        // others
        $this->path = app('request')->getPathInfo();
        $this->elementId .= uniqid();

        $this->setupTools();

        if ($callback instanceof \Closure) {
            call_user_func($callback, $this);
        }

        $this->initBranchCallback();
    }

    /**
     * 设定标题
     *
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * Set Tree Base ID
     *
     * @param $baseId
     */
    public function setBaseId($baseId)
    {
        $this->baseId = $baseId;
    }


    /**
     * Setup tree tools.
     */
    public function setupTools()
    {
        $this->tools = new StaticTreeTools($this);
    }

    /**
     * Initialize branch callback.
     *
     * @return void
     */
    protected function initBranchCallback()
    {
        if (is_null($this->branchCallback)) {
            $this->branchCallback = function ($branch) {
                $key = $branch[$this->model->getKeyName()];
                $title = $branch[$this->model->getTitleColumn()];

                return "$key - $title";
            };
        }
    }

    /**
     * Set branch callback.
     *
     * @param \Closure $branchCallback
     *
     * @return $this
     */
    public function branch(\Closure $branchCallback)
    {
        $this->branchCallback = $branchCallback;

        return $this;
    }

    /**
     * Set query callback this tree.
     *
     * @param Closure $callback
     * @return $this
     */
    public function query(\Closure $callback)
    {
        $this->queryCallback = $callback;

        return $this;
    }

    /**
     * Set options.
     *
     * @param array $options
     *
     * @return $this
     */
    public function options($options = [])
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * Disable create.
     *
     * @return void
     */
    public function disableCreate()
    {
        $this->useCreate = false;
    }

    /**
     * Disable refresh.
     *
     * @return void
     */
    public function disableRefresh()
    {
        $this->useRefresh = false;
    }

    /**
     * Save tree order from a input.
     *
     * @param string $serialize
     *
     * @return bool
     */
    public function saveOrder($serialize)
    {
        $tree = json_decode($serialize, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        $this->model->saveOrder($tree);

        return true;
    }

    /**
     * Build tree grid scripts.
     *
     * @return string
     */
    protected function script()
    {
        $deleteConfirm = trans('admin.delete_confirm');
        $refreshSucceeded = trans('admin.refresh_succeeded');
        $deleteSucceeded = trans('admin.delete_succeeded');
        $confirm = trans('admin.confirm');
        $cancel = trans('admin.cancel');

        $optionShowTags          = empty($this->options['showTags']) ? 'false' : ($this->options['showTags'] ? 'true' : 'false');
        $optionLevels            = empty($this->options['levels']) ? 5 : $this->options['levels'];
        $optionEnableLinks       = empty($this->options['enableLinks']) ? 'false' : ($this->options['enableLinks'] ? 'true' : 'false');
        $optionHighlightSelected = empty($this->options['highlightSelected']) ? 'false' : ($this->options['highlightSelected'] ? 'true' : 'false');

        return <<<SCRIPT
        
        console.log('loaded');
        
        $('#{$this->elementId}').treeview(
            {
                data: getTree(),
                showTags: $optionShowTags,
                levels: $optionLevels,
                enableLinks: $optionEnableLinks,
                highlightSelected: $optionHighlightSelected,
            });
            
        $(document).on("click", '.tree_branch_delete', function() {
            var id = $(this).data('id');
            swal({
              title: "$deleteConfirm",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "$confirm",
              closeOnConfirm: false,
              cancelButtonText: "$cancel"
            },
            function(){
                $.ajax({
                    method: 'post',
                    url: '{$this->path}/' + id,
                    data: {
                        _method:'delete',
                        _token:LA.token,
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');

                        if (typeof data === 'object') {
                            if (data.status) {
                                swal(data.message, '', 'success');
                            } else {
                                swal(data.message, '', 'error');
                            }
                        }
                    }
                });
            });
        });

        $('.{$this->elementId}-refresh').click(function () {
            $.pjax.reload('#pjax-container');
            toastr.success('{$refreshSucceeded}');
        });

        $('.{$this->elementId}-expandAll').on('click', function(e){
            $('#{$this->elementId}').treeview('expandAll', { silent: true });
        });

        $('.{$this->elementId}-collapseAll').on('click', function(e){
            $('#{$this->elementId}').treeview('collapseAll', { silent: true });
        });

SCRIPT;
    }

    /**
     * Set view of tree.
     *
     * @param string $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * Return all items of the tree.
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->model->withQuery($this->queryCallback)->toTree($this->baseId);
    }

    /**
     * Variables in tree template.
     *
     * @return array
     */
    public function variables()
    {
        return [
            'id'         => $this->elementId,
            'tools'      => $this->tools->render(),
            'items'      => $this->getItems(),
            'useCreate'  => $this->useCreate,
            'useRefresh' => $this->useRefresh,
            'title'      => $this->title,
        ];
    }

    /**
     * Setup grid tools.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function tools(Closure $callback)
    {
        call_user_func($callback, $this->tools);
    }

    /**
     * Render a tree.
     *
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        Admin::script($this->script());
        //Admin::js($this->js());   //弃用的原因是因为laravel-admin使用了pjax页面局部刷新，导致上一个页面未加载treeview后，下一个页面想使用treeview的时候就不会再加载了
        //Admin::css($this->css());

        view()->share([
            'path'                 => $this->path,
            'keyName'              => $this->keyName,
            'branchView'           => $this->view['branch'],
            'branchCallback'       => $this->branchCallback,
            'optionShowTags'       => empty($this->options['showTags']) ? false : $this->options['showTags'],
            'optionNodeSelectable' => empty($this->options['nodeSelectable']) ? 'false' : ($this->options['nodeSelectable'] ? 'true' : 'false'),
        ]);

        return view($this->view['tree'], $this->variables())->render();
    }

    public function css()
    {
        return admin_asset("/vendor/laravel-admin/bootstrap-treeview/bootstrap-treeview.css");
    }

    public function js()
    {
        return admin_asset("/vendor/laravel-admin/bootstrap-treeview/bootstrap-treeview.js");
    }

    /**
     * Get the string contents of the grid view.
     *
     * @return string
     * @throws \Throwable
     */
    public function __toString()
    {
        return $this->render();
    }
}
