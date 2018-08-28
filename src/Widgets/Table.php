<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Widgets;

use Encore\Admin\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

class Table extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'admin.widgets.table';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $rows = [];

    /**
     * @var array
     */
    protected $styles = [];

    /**
     * Table constructor.
     * @param array $headers
     * @param array $rows
     * @param array $styles
     * @param string $class
     */
    public function __construct($headers = [], $rows = [], $styles = [], $class = "table table-striped")
    {
        $this->setHeaders($headers);
        $this->setRows($rows);
        $this->setStyles($styles);

        $this->class($class);
    }

    /**
     * Set table class.
     *
     * @param $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class($class);

        return $this;
    }

    /**
     * Set table headers.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders($headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set table rows.
     *
     * @param array $rows
     *
     * @return $this
     */
    public function setRows($rows = [])
    {
        if (Arr::isAssoc($rows)) {
            foreach ($rows as $key => $item) {
                $this->rows[] = [$key, $item];
            }

            return $this;
        }

        $this->rows = $rows;

        return $this;
    }

    /**
     * Set table style.
     *
     * @param array $styles
     *
     * @return $this
     */
    public function setStyles($styles = [])
    {
        $this->styles = $styles;

        return $this;
    }

    /**
     * Render the table.
     *
     * @return mixed|string
     * @throws \Throwable
     */
    public function render()
    {
        $vars = [
            'headers'    => $this->headers,
            'rows'       => $this->rows,
            'styles'     => $this->styles,
            'attributes' => $this->formatAttributes(),
        ];

        return view($this->view, $vars)->render();
    }
}
