<?php
/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Article controller
 **/

class Tagger {
    private $template;
    private $menuText;
    private $Tags = array();

    /**
     * Tagger constructor.
     */
    protected function __construct(){}

    /**
     * Sets the root directory. could be used for accessing css and js files in views
     * e.g  <link rel="stylesheet" href="{ZEMA_ROOT}/css/app.css">
     */
    public function setRootDir(){
        $this->replaceTemplateTag("ZEMA_ROOT", ZEMA_ROOT);
    }

    /**
     * @param $tpl
     */
    public function renderView($tpl){
        ///ToDo: Exception handling
        $this->template = file_get_contents($tpl);
    }

    /**
     * @param $partial
     * @param $path
     */
    public function setPartial($partial, $path)
    {
        ///ToDo: Exception handling
        $content = file_get_contents($path);
        if ($content === false) {
            echo ERROR['file-not-found'];
            // throw new ResourceNotFoundException('File not  found');
        }
        $this->replaceTemplateTag(strtoupper($partial), $content);

    }

    /**
     * @param array $tags
     */
    public function setTagArray(array $tags){
        ///ToDo: Exception handling
        foreach ($tags as $name => $value) {
            $this->replaceTemplateTag(strtoupper($name), $value);
        }
    }

    /**
     * @param $tag
     * @param $data
     */
    function setTag($tag, $data){
        $this->menuText = '';
        if (is_array($data)) {
            array_map(function ($value){
                $this->menuText .= $value;
            }, $data);

        } else {
            $this->menuText = $data;
        }
        $this->replaceTemplateTag(strtoupper($tag), $this->menuText);
    }

    /**
     * @param $tag
     */
    function hideTag($tag) {
        $this->replaceTemplateTag(strtoupper($tag), "");
    }

    /**
     * makeHtmlTag Method : creates the start and end html tags
     * @param $tag
     * @return array
     */
    public function makeHtmlTag($tag) {
        if($tag!="") {
            $start_tag = '<'.$tag.'>';
            $end_tag = '</'.$tag.'>';
        } else {
            $start_tag = $end_tag = "";
        }

        return (['start' => $start_tag, 'end' => $end_tag]);
    }


    /**
     * @param $TagName
     * @param $TagValue
     */
    function replaceTemplateTag($TagName, $TagValue) {
        $this->Tags['{'.$TagName.'}'] = $TagValue;//nl2br($TagValue);
    }

    protected function replaceTag($tagName, $tagValue, $template) {
        return str_replace(strtoupper('{'.$tagName.'}'),$tagValue,$template);
    }

    /**
     * @return mixed
     */
    function create(){
        //keys: the needles, values: to be replaced with, template: the haystack
        return str_replace(array_keys($this->Tags),array_values($this->Tags),$this->template);
    }
}
?>