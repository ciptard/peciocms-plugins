<?php

class BlogCategoryListPlugin extends PecAbstractPlugin {
    
    function __construct($plugin_meta, $site_view, $sub_site_view) {
        parent::__construct($plugin_meta, $site_view, $sub_site_view);

        $this->list_wrapper_template = file_get_contents(PLUGIN_PATH . $this->plugin_meta->get_directory_name() . '/templates/list-wrapper.tpl');
        $this->list_element_template = file_get_contents(PLUGIN_PATH . $this->plugin_meta->get_directory_name() . '/templates/list-element.tpl');
    }
    
    public function run($var_data='') {        
        $categories = PecBlogCategory::load();

        $list_elements_html = '';

        $home = $this->settings->get_blog_onstart() ? true : false;
        
        foreach ($categories as $c) {
            $list_element = str_replace('{%CATEGORY_NAME%}', $c->get_name(), $this->list_element_template);
            $list_element = str_replace('{%CATEGORY_URL%}', create_blogcategory_url($c, false, $home), $list_element);
            $list_elements_html .= $list_element;
        }

        $list_html = str_replace('{%CATEGORY_ELEMENTS%}', $list_elements_html, $this->list_wrapper_template);
        
        return $list_html;    }
    
    public function head_data() {
        return '';
    }
    
}

?>
