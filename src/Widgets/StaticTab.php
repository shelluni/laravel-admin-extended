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

class StaticTab extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'admin.widgets.statictab';

    /**
     * @var array
     */
    protected $data = [
        'id'       => '',
        'title'    => '',
        'tabs'     => [],
        'dropDown' => [],
        'active'   => 0,
        'content'   => '',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->class('nav-tabs-custom');
    }

    /**
     * Add a tab and its contents.
     *
     * @param $title
     * @param $href
     * @param bool $active
     * @return $this
     */
    public function add($title, $href, $active = false)
    {
        $this->data['tabs'][] = [
            'id'      => mt_rand(),
            'title'   => $title,
            'href' => $href,
        ];

        if ($active) {
            $this->data['active'] = count($this->data['tabs']) - 1;
        }

        return $this;
    }

    public function content($content)
    {
        if ($content instanceof \Closure)
        {
            $this->data['content'] = call_user_func($content);
        }
        else
        {
            $this->data['content'] = $content;
        }

        return $this;
    }

    /**
     * Set title.
     *
     * @param string $title
     */
    public function title($title = '')
    {
        $this->data['title'] = $title;
    }

    public function active($active)
    {
        $this->data['active'] = $active;
    }

    /**
     * Set drop-down items.
     *
     * @param array $links
     *
     * @return $this
     */
    public function dropDown(array $links)
    {
        if (is_array($links[0])) {
            foreach ($links as $link) {
                call_user_func([$this, 'dropDown'], $link);
            }

            return $this;
        }

        $this->data['dropDown'][] = [
            'name' => $links[0],
            'href' => $links[1],
        ];

        return $this;
    }

    /**
     * Render Tab.
     *
     * @return string
     */
    public function render()
    {
        $variables = array_merge($this->data, ['attributes' => $this->formatAttributes()]);

        return view($this->view, $variables)->render();
    }
}
