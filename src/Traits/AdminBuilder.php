<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Traits;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Tree;
use Shelluni\Admin\Form as ExtendedForm;
use Shelluni\Admin\Grid as ExtendedGrid;
use Shelluni\Admin\StaticTree;

trait AdminBuilder
{
    /**
     * 表格
     *
     * @param \Closure $callback
     * @return Grid
     */
    public static function grid(\Closure $callback)
    {
        return new Grid(new static(), $callback);
    }

    /**
     * 扩展性表格
     *
     * @param \Closure $callback
     * @return ExtendedGrid
     */
    public static function extendedGrid(\Closure $callback)
    {
        return new ExtendedGrid(new static(), $callback);
    }

    /**
     * 表单
     *
     * @param \Closure $callback
     * @return Form
     */
    public static function form(\Closure $callback)
    {
        Form::registerBuiltinFields();

        return new Form(new static(), $callback);
    }

    /**
     * 扩展性表单
     *
     * @param \Closure $callback
     * @return ExtendedForm
     */
    public static function extendedForm(\Closure $callback)
    {
        Form::registerBuiltinFields();

        return new ExtendedForm(new static(), $callback);
    }

    /**
     * 树
     *
     * @param \Closure $callback
     * @return Tree
     */
    public static function tree(\Closure $callback = null)
    {
        return new Tree(new static(), $callback);
    }

    /**
     * 静态树
     *
     * @param \Closure|null $callback
     * @param $parameters
     * @return StaticTree
     */
    public static function staticTree(\Closure $callback = null, $parameters = [])
    {
        return new StaticTree(new static(), $parameters, $callback);
    }
}
