<?php
/**
 * @package ImpressPages

 *
 */
namespace Ip\Internal\Content\Widget\Html;




class Controller extends \Ip\WidgetController
{
    public function getTitle() {
        return __('HTML', 'ipAdmin', false);
    }

    public function adminHtmlSnippet()
    {
        return ipView('snippet/edit.php')->render();
    }

}
