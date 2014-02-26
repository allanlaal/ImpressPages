<?php
/**
 * @package ImpressPages
 *
 */
namespace Ip\Internal\Content;


class PublicController extends \Ip\Controller
{
    public function index()
    {
        //find current page
        $page = ipContent()->getCurrentPage();

        // redirect if needed
        if (in_array($page->getType(), array('subpage', 'redirect')) && !ipIsManagementState()) {
            return new \Ip\Response\Redirect($page->getLink());
        }

        // change layout if safe mode
        if (\Ip\Internal\Admin\Service::isSafeMode()) {
            ipSetLayout(ipFile('Ip/Internal/Admin/view/safeModeLayout.php'));
        } else {
            ipSetLayout(Service::getPageLayout($page));
        }

        // initialize management
        if (ipIsManagementState()) {
            if (!ipRequest()->getQuery('ipDesignPreview')) {
                $this->initManagement();
            }
        } else {
            if (\Ip\Internal\Admin\Backend::userId()) {
                //user has access to the backend
                ipAddJsVariable('ipContentShowEditButton', 1);
            }
        }

        //show page content
        $response = ipResponse();
        $response->setDescription(\Ip\ServiceLocator::content()->getDescription());
        $response->setKeywords(ipContent()->getKeywords());
        $response->setTitle(ipContent()->getTitle());

        $revision = \Ip\ServiceLocator::content()->getCurrentRevision();
        if ($revision) {
            return \Ip\Internal\Content\Model::generateBlock('main', $revision['revisionId'], 0, ipIsManagementState());
        } else {
            return '';
        }

    }

    private function initManagement()
    {
        $widgets = Service::getAvailableWidgets();
        $snippets = array();
        foreach ($widgets as $widget) {
            $snippetHtml = $widget->adminHtmlSnippet();
            if ($snippetHtml != '') {
                $snippets[] = $snippetHtml;
            }
        }
        ipAddJsVariable('ipWidgetSnippets', $snippets);




        ipAddJsVariable('ipContentInit', Model::initManagementData());

        if (ipConfig()->isDebugMode()) {
            ipAddJs('Ip/Internal/Content/assets/management/ipContentManagementInit.js');
            ipAddJs('Ip/Internal/Content/assets/management/content.js');
            ipAddJs('Ip/Internal/Content/assets/management/jquery.ip.contentManagement.js');
            ipAddJs('Ip/Internal/Content/assets/management/jquery.ip.widgetbutton.js');
            ipAddJs('Ip/Internal/Content/assets/management/jquery.ip.layoutModal.js');
            ipAddJs('Ip/Internal/Content/assets/management/jquery.ip.block.js');
            ipAddJs('Ip/Internal/Content/assets/management/jquery.ip.widget.js');
            ipAddJs('Ip/Internal/Content/assets/management/exampleContent.js');
            ipAddJs('Ip/Internal/Content/assets/management/drag.js');

            ipAddJs('Ip/Internal/Content/Widget/Columns/assets/Columns.js');
            ipAddJs('Ip/Internal/Content/Widget/Faq/assets/Faq.js');
            ipAddJs('Ip/Internal/Content/Widget/File/assets/File.js');
            ipAddJs('Ip/Internal/Content/Widget/File/assets/jquery.ipWidgetFile.js');
            ipAddJs('Ip/Internal/Content/Widget/File/assets/jquery.ipWidgetFileContainer.js');
            ipAddJs('Ip/Internal/Content/Widget/Form/assets/Form.js');
            ipAddJs('Ip/Internal/Content/Widget/Form/assets/FormContainer.js');
            ipAddJs('Ip/Internal/Content/Widget/Form/assets/FormField.js');
            ipAddJs('Ip/Internal/Content/Widget/Form/assets/FormOptions.js');
            ipAddJs('Ip/Internal/Content/Widget/Html/assets/Html.js');
            ipAddJs('Ip/Internal/Content/Widget/Video/assets/Video.js');
            ipAddJs('Ip/Internal/Content/Widget/Audio/assets/Audio.js');
            ipAddJs('Ip/Internal/Content/Widget/Image/assets/Image.js');
            ipAddJs('Ip/Internal/Content/Widget/Gallery/assets/Gallery.js');
            ipAddJs('Ip/Internal/Content/Widget/Text/assets/Text.js');
            ipAddJs('Ip/Internal/Content/Widget/Title/assets/Title.js');
            ipAddJs('Ip/Internal/Content/Widget/Title/assets/TitleModal.js');
            ipAddJs('Ip/Internal/Content/Widget/Map/assets/Map.js');

        } else {
            ipAddJs('Ip/Internal/Content/assets/management.min.js');
        }

        ipAddJs('Ip/Internal/Content/assets/jstree/jstree.js');
        ipAddJs('Ip/Internal/Content/assets/jstree/jstree.wholerow.js');



        ipAddJs('Ip/Internal/Core/assets/js/jquery-ui/jquery-ui.js');
        ipAddCss('Ip/Internal/Core/assets/js/jquery-ui/jquery-ui.css');

        ipAddJs('Ip/Internal/Core/assets/js/jquery-tools/jquery.tools.ui.scrollable.js');

        ipAddJs('Ip/Internal/Core/assets/ipCore/plupload/plupload.full.js');
        ipAddJs('Ip/Internal/Core/assets/ipCore/plupload/plupload.browserplus.js');
        ipAddJs('Ip/Internal/Core/assets/ipCore/plupload/plupload.gears.js');
        ipAddJs('Ip/Internal/Core/assets/ipCore/plupload/jquery.plupload.queue/jquery.plupload.queue.js');


        ipAddJs('Ip/Internal/Upload/assets/jquery.ip.uploadImage.js');
        ipAddJs('Ip/Internal/Upload/assets/jquery.ip.uploadFile.js');

        ipAddJsVariable('isMobile', \Ip\Internal\Browser::isMobile());


        ipAddJsVariable(
            'ipWidgetLayoutModalTemplate',
            ipView('view/widgetLayoutModal.php')->render()
        );
        ipAddJsVariable(
            'ipBrowseLinkModalTemplate',
            ipView('view/browseLinkModal.php')->render()
        );
    }


}
