<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Layout;

use Closure;
use Encore\Admin\Layout\Row;
use Illuminate\Contracts\Support\Renderable;

class Panel implements Renderable
{
    /**
     * @var Row[]
     */
    protected $rows = [];

    /**
     * Panel constructor.
     * @param \Closure|null $callback
     */
    public function __construct(\Closure $callback = null)
    {
        if ($callback instanceof Closure)
        {
            $callback($this);
        }
    }

    /**
     * Alias of method row.
     *
     * @param $content
     * @return Panel
     */
    public function body($content)
    {
        return $this->row($content);
    }

    /**
     * Add one row for content body.
     *
     * @param $content
     *
     * @return $this
     */
    public function row($content)
    {
        if ($content instanceof Closure)
        {
            $row = new Row();
            call_user_func($content, $row);
            $this->addRow($row);
        }
        else
        {
            $this->addRow(new Row($content));
        }

        return $this;
    }

    public function count()
    {
        return count($this->rows);
    }

    /**
     * Add Row.
     *
     * @param Row $row
     */
    protected function addRow(Row $row)
    {
        $this->rows[] = $row;
    }

    /**
     * Build html of content.
     *
     * @return string
     */
    public function build()
    {
        ob_start();

        foreach ($this->rows as $row)
        {
            $row->build();
        }

        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }

    /**
     * Render this content.
     *
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        $items = [
            'content' => $this->build(),
        ];

        return view('admin.layout.panel', $items)->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function __toString()
    {
        return $this->render();
    }
}