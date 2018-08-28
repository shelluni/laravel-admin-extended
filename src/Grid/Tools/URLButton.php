<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Grid\Tools;

use Encore\Admin\Grid\Tools\AbstractTool;
use Shelluni\Admin\Grid;

class URLButton extends AbstractTool
{
    protected $text = "";

    protected $url = "";

    protected $icon = "fa-list";

    protected $class = "btn-sm btn-default";

    protected $target = "_self";

    /**
     * Create a new Print button instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    public function setURL($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Render Print button.
     *
     * @return string
     */
    public function render()
    {
        return <<<EOT
    <a href="$this->url" target="$this->target" class="btn $this->class"><i class="fa $this->icon"></i>&nbsp;$this->text</a>
EOT;
    }
}
