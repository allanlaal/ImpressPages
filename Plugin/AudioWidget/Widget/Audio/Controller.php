<?php
/**
 * @package ImpressPages

 *
 */
namespace Plugin\AudioWidget\Widget\Audio;




class Controller extends \Ip\WidgetController
{
    public function getTitle() {
        return __('Audio', 'ipAdmin', false);
    }



    /**
     * Update widget data
     *
     * This method is executed each time the widget data is updated.
     *
     * @param $widgetId Widget ID
     * @param $postData
     * @param $currentData
     * @return array Data to be stored to the database
     */
    public function update ($widgetId, $postData, $currentData)
    {
        return $postData;
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

        $output = $this->renderFilePlayersHtml($data);

        return $output;
    }

    protected function renderSoundcloudHtml($url) {
        if (isset($data['url'])){

            $url = $data['url'];

            if (!preg_match('/^((http|https):\/\/)/i', $url)) {
                $url = 'http://' . $url;

            }

            if (preg_match('/^((http|https):\/\/)?(www.)?(player.)?soundcloud.com/i', $url)) {

                $url = str_replace('www.soundcloud.com', 'soundcloud.com', $url);

                $track = 5370961;
                $data['track'] = $track;

                return $this->renderView('view/soundcloud.php',  $url, $data);
            }
        }

        return false;

    }

    protected function renderFilePlayersHtml($data) {

        $output = '';
        if (isset($data['audioFiles'])){
            foreach ($data['audioFiles'] as $fileUrl) {
                $output .= '<div>';
                $output .= '<audio controls>';
                $output .= '<source src="';
                $output .= esc($fileUrl);
                $output .= '">';
                $output .= '</audio>';
                $output .= '</div>';
            }
        }

        if (isset($data['url'])){
            $track = 5370961;
            $data['track'] = $track;

            $output .= $this->renderView('view/soundcloud.php',  $url, $data);
        }

        return $output;

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

        $variables['track'] = $data['track'];

        return ipView($viewFile, $variables)->render();

    }

    public function adminHtmlSnippet()
    {


        $form = $this->editForm();

        $variables = array(
            'formHtml' => $form
        );
        return ipView('snippet/edit.php', $variables)->render();
    }

    protected function editForm()
    {
        $form = new \Ip\Form();

        // Add values and indexes
        $values = array(
            array('soundcloud', __('Soundcloud', 'ipAdmin', false)),
            array('file', __('File', 'ipAdmin', false)),
        );

// Add a field
        $form->addField(new \Ip\Form\Field\Select(
            array(
                'name' => __('source', 'ipAdmin', false), // set HTML 'name' attribute
                'values' => $values,
                'value' => 1
            )));

        $fieldset = new \Ip\Form\Fieldset('Soundcloud');
        $fieldset->addAttribute('id', 'ipsAudioSoundcloud');
        $form->addFieldset($fieldset);

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'url',
                'label' => __('Url', 'ipAdmin', false),
            ));
        $form->addField($field);

        $fieldset = new \Ip\Form\Fieldset('File');
        $fieldset->addAttribute('id', 'ipsAudioFile');
        $form->addFieldset($fieldset);

        return $form; // Output a string with generated HTML form
    }

}
