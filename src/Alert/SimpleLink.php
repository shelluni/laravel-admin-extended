<?php
/**
 * Created by PhpStorm.
 * User: shelluni
 * Date: 8/28/18
 * Time: 9:00 AM
 */

namespace Shelluni\Admin\Alert;

class SimpleLink
{
    protected $elementId;

    protected $url = "";
    protected $alertTitle = "";
    protected $buttonText = "";
    protected $buttonIconClass = "";
    protected $target = "";

    /**
     * SimpleLink constructor.
     * @param $url
     * @param $buttonText
     * @param $buttonIconClass
     * @param $target
     */
    public function __construct($url, $buttonText = "", $buttonIconClass = "", $target = "")
    {
        $this->elementId = uniqid();

        $this->url = $url;
        $this->buttonText = $buttonText;
        $this->buttonIconClass = $buttonIconClass;
        $this->target = $target;
    }

    /**
     * 渲染
     *
     * @return string
     */
    public function render()
    {
        $settingTarget = "";
        if (!empty($this->target))
        {
            $settingTarget = "target = '$this->target'";
        }

        return <<<EOT
<a href='$this->url' class='simple-link-$this->elementId margin-r-5' $settingTarget><i class='fa $this->buttonIconClass'></i> $this->buttonText</a>
EOT;
    }

    public function __toString()
    {
        return $this->render();
    }
}