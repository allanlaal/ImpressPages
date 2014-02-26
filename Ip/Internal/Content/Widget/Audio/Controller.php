<?php
/**
 * @package ImpressPages

 *
 */
namespace Ip\Internal\Content\Widget\Audio;




class Controller extends \Ip\WidgetController
{
    public function getTitle() {
        return __('Audio', 'ipAdmin', false);
    }


    public function generateHtml($revisionId, $widgetId, $instanceId, $data, $skin)
    {
        $audioHtml = $this->generateAudioHtml($data);
        if ($audioHtml) {
            $data['audioHtml'] = $audioHtml;
        }

        return parent::generateHtml($revisionId, $widgetId, $instanceId, $data, $skin);
    }


    protected function generateAudioHtml($data)
    {
        if (empty($data['url'])) {
            return false;
        }
        $url = $data['url'];

        if (!preg_match('/^((http|https):\/\/)/i', $url)) {
            $url = 'http://' . $url;
        }

        if (preg_match('/^((http|https):\/\/)?(www.)?(player.)?soundcloud.com/i', $url)) {
            if (preg_match('%www.vimeo.com%i', $url)) {
                $url = str_replace('www.vimeo.com', 'player.vimeo.com', $url);
            }
            if (preg_match('%//vimeo.com%i', $url)) {
                $url = str_replace('//vimeo.com', '//player.vimeo.com', $url);
            }

            return $this->renderView('view/soundcloud.php', $url, $data);
        }


        return false;
    }

    protected function renderView($viewFile, $url, $data) {
        $variables = array(
            'url' => $url,
            'style' => '',
            'iframeStyle' => ''
        );

        if (!empty($data['size']) && $data['size'] != 'auto') {
            if (empty($data['width'])) {
                $data['width'] = 853;
            }
            if (empty($data['height'])) {
                $data['height'] = 480;
            }
            $variables['iframeStyle'] = 'width: ' . $data['width'] . 'px; height: ' . $data['height'] . 'px;';
        } else {
            $variables['iframeStyle'] = 'height: 100%; width:100%; position: absolute; top: 0; left: 0;';
            if (!empty($data['ratio']) && $data['ratio'] != '16:9') {
                $variables['style'] = 'padding-bottom: 75% !important; position: relative;';
            } else {
                $variables['style'] = 'padding-bottom: 56.25% !important; position: relative;';
            }
        }


        return ipView($viewFile, $variables)->render();

    }

    public function adminHtmlSnippet()
    {


        $form = $this->editForm();
        $variables = array(
            'form' => $form
        );

        return ipView('snippet/edit.php', $variables)->render();
    }

    protected function editForm()
    {
        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'url',
                'label' => __('Url', 'ipAdmin', false),
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Select(
            array(
                'name' => 'size',
                'label' => __('Size', 'ipAdmin', false),
            ));

        $values = array(
            array('auto', __('Auto', 'ipAdmin', false)),
            array('custom', __('Custom', 'ipAdmin', false)),
        );
        $field->setValues($values);

        $form->addField($field);

        $field = new \Ip\Form\Field\Number(
            array(
                'name' => 'width',
                'label' => __('Width', 'ipAdmin', false),
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Number(
            array(
                'name' => 'height',
                'label' => __('Height', 'ipAdmin', false),
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Select(
            array(
                'name' => 'ratio',
                'label' => __('Aspect ratio', 'ipAdmin', false),
            ));
        $values = array(
            array('16:9', __('16:9', 'ipAdmin', false)),
            array('4:3', __('4:3', 'ipAdmin', false)),
        );
        $field->setValues($values);
        $form->addField($field);



        return $form; // Output a string with generated HTML form
    }

}
