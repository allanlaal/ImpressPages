<?php
/**
 * @package ImpressPages
 *
 */

namespace Modules\standard\design;


use \Modules\developer\form as Form;

class ConfigModel{

    protected $isInPreviewState;

    protected function __construct()
    {
        $this->isInPreviewState = defined('IP_ALLOW_PUBLIC_THEME_CONFIG') || isset($_GET['ipDesignPreview']) && $this->hasPermission();
    }

    /**
     * @return ConfigModel
     */
    public static function instance()
    {
        return new ConfigModel();
    }

    public function isInPreviewState()
    {
        return $this->isInPreviewState;
    }


    public function getConfig()
    {

    }

    public function getConfigValue($theme, $name, $default = null)
    {
        if ($this->isInPreviewState() && isset($_POST['ipDesign']['previewConfig'][$name])) {
            return $_POST['ipDesign']['previewConfig'][$name];
        }

        $dbh = \Ip\Db::getConnection();
        $sql = '
            SELECT
                value
            FROM
                `'.DB_PREF.'m_design`
            WHERE
                `theme` = :theme AND
                `name` = :name
        ';

        $params = array (
            ':theme' => $theme,
            ':name' => $name
        );
        $q = $dbh->prepare($sql);
        $q->execute($params);
        $result = $q->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result['value'];
        }
        return $default;
    }

    public function getAllConfigValues($theme)
    {
        if ($this->isInPreviewState() && isset($_POST['ipDesign']['previewConfig'])) {
            return $_POST['ipDesign']['previewConfig'];
        }

        $dbh = \Ip\Db::getConnection();
        $sql = '
            SELECT
                `name`, `value`
            FROM
                `'.DB_PREF.'m_design`
            WHERE
                `theme` = :theme
        ';

        $params = array (
            ':theme' => $theme,
        );

        $q = $dbh->prepare($sql);
        $q->execute($params);
        $rs = $q->fetchAll(\PDO::FETCH_ASSOC);

        $config = array();
        foreach ($rs as $row) {
            $config[$row['name']] = $row['value'];
        }

        return $config;
    }

    public function setConfigValue($theme, $name, $value)
    {
        $dbh = \Ip\Db::getConnection();
        $sql = '
            INSERT INTO
                `'.DB_PREF.'m_design`
            SET
                `theme` = :theme,
                `name` = :name,
                `value` = :value
            ON DUPLICATE KEY UPDATE
                `value` = :value
        ';

        $params = array (
            ':theme' => $theme,
            ':name' => $name,
            ':value' => $value
        );
        $q = $dbh->prepare($sql);
        $q->execute($params);
    }


    /**
     * @param string $name
     * @return \Modules\developer\form\Form
     * @throws \Ip\CoreException
     */
    public function getThemeConfigForm($name)
    {
        $model = Model::instance();
        $theme = $model->getTheme($name);
        if (!$theme) {
            throw new \Ip\CoreException("Theme doesn't exist");
        }


        $form = new \Modules\developer\form\Form();
        $form->addClass('ipsForm');

        $field = new Form\Field\Hidden();
        $field->setName('g');
        $field->setDefaultValue('standard');
        $form->addField($field);
        $field = new Form\Field\Hidden();
        $field->setName('m');
        $field->setDefaultValue('design');
        $form->addField($field);
        $field = new Form\Field\Hidden();
        $field->setName('ba');
        $field->setDefaultValue('updateConfig');
        $form->addField($field);


        $options = $theme->getOptions();

        foreach($options as $option) {
            if (empty($option['type']) || empty($option['name'])) {
                continue;
            }
            switch ($option['type']) {

                case 'select':
                    $newField = new Form\Field\Select();
                    $values = array();
                    if (!empty($option['values']) && is_array($option['values'])) {
                        foreach($option['values'] as $value) {
                            $values[] = array($value, $value);
                        }
                    }
                    $newField->setValues($values);

                    break;
                case 'text':
                    $newField = new Form\Field\Text();
                    break;
                case 'file':
                    $newField = new Form\Field\File();
                    break;
                case 'color':
                    $newField = new Form\Field\Color();
                    break;
                case 'range':
                    $newField = new Form\Field\Range();
                    break;
                default:
                    //do nothing
            }
            if (!isset($newField)) {
                //field type is not recognised
                continue;
            }

            $newField->setName($option['name']);
            $newField->setLabel(empty($option['label']) ? '' : $option['label']);
            $default = isset($option['default']) ? $option['default'] : null;
            $newField->setDefaultValue($this->getConfigValue($name, $option['name'], $default));

            $form->addfield($newField);
            $newField = null;
        }

        return $form;
    }


    protected function hasPermission()
    {

        if (!\Ip\Backend::loggedIn()) {
            return false;
        }

        if (!\Ip\Backend::userHasPermission(\Ip\Backend::userId(), 'standard', 'design')) {
            return false;
        }

        return true;
    }


}