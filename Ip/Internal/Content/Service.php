<?php
/**
 * @package ImpressPages
 *
 */
namespace Ip\Internal\Content;


use Ip\Form\Exception;

class Service
{


    /**
     * @return \Ip\WidgetController[]
     */
    public static function getAvailableWidgets()
    {
        return Model::getAvailableWidgetObjects();
    }


    public static function setManagementMode($newMode)
    {
        $_SESSION['Content']['managementMode'] = $newMode ? 1 : 0;
    }

    public static function isManagementMode()
    {
        $backendLoggedIn = \Ip\Internal\Admin\Backend::loggedIn();
        return $backendLoggedIn && !empty($_SESSION['Content']['managementMode']); //we can't check here if we are in a page. It will result in widget rendering in non management mode when widget is rendered using ajax
    }

    public static function getPageLayout(\Ip\Page $page)
    {
        return ipPageStorage($page->getId())->get('layout', 'main.php');
    }

    public static function createWidget($widgetName, $data = null, $skin = null)
    {
        $widgetObject = Model::getWidgetObject($widgetName);
        if (!$widgetObject) {
            throw new \Ip\Exception("Widget '$widgetName' doesn't exist");
        }

        if ($data ===  null) {
            $data = $widgetObject->defaultData();
        }

        if ($skin === null) {
            $skins = $widgetObject->getSkins();
            $skin = $skins[0]['name'];
        }

        $widgetId = Model::createWidget($widgetName, $data, $skin);
        return $widgetId;
    }

    public static function addWidgetInstance($widgetId, $revisionId, $languageId, $block, $position, $visible = true)
    {
        $instanceId = InstanceModel::addInstance($widgetId, $revisionId, $languageId, $block, $position, $visible);
        return $instanceId;
    }


    public static function deleteWidgetInstance($instanceId)
    {
        InstanceModel::deleteInstance($instanceId);
    }



}
