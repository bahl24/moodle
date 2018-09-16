
<?php
class block_simplehtml extends block_base {
    
    public function init() {
        $this->title = get_string('simplehtml', 'block_simplehtml');
    }
    
    public function get_content() {
        if ($this->content !== null) {
          return $this->content;
        }

        $this->content         =  new stdClass;
        $this->content->text   = 'The of our SimpleHTML block!';

        global $COURSE,$DB;

        $url = new moodle_url('/blocks/simplehtml/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
        $this->content->footer = html_writer::link($url, get_string('addpage', 'block_simplehtml'));

            if (! empty($this->config->text)) {
                $this->content->text = $this->config->text;
            }

            if($DB->get_records('block_simplehtml', array('blockid' => $this->instance->id))){
                $simplehtmlpages = $DB->get_records('block_simplehtml', array('blockid' => $this->instance->id));
                $this->content->text .= '<ul class="block-simplehtml-pagelist">';
                foreach($simplehtmlpages as $simplehtmlpage){
                $pageurl = new moodle_url('/blocks/simplehtml/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'id' => $simplehtmlpage->id, 'viewpage' => '1'));
        $this->content->text .= html_writer::start_tag('li');
        $this->content->text .= html_writer::link($pageurl, $simplehtmlpage->pagetitle);
        $this->content->text .= html_writer::end_tag('li');
                }
                $this->content->text .= html_writer::end_tag('ul');
            }   
        return $this->content;
    }
    
    public function specialization() {
            if (isset($this->config)) {
                if (empty($this->config->title)) {
                    $this->title = get_string('defaulttitle', 'block_simplehtml');            
                } else {
                    $this->title = $this->config->title;
                }

                if (empty($this->config->text)) {
                    $this->config->text = get_string('defaulttext', 'block_simplehtml');
                }    
            }
        }
     public function instance_allow_multiple() {
        return true;
     }  
     function has_config() 
     {return true;}
     
     public function instance_config_save($data,$nolongerused =false) {
     if(get_config('simplehtml', 'Allow_HTML') == '1') {
       $data->text = strip_tags($data->text);
     }

     // And now forward to the default implementation defined in the parent class
     return parent::instance_config_save($data,$nolongerused);
   }
   public function hide_header() {
        return false;
    }
    public function html_attributes() {
        $attributes = parent::html_attributes(); // Get default values
        $attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute
        return $attributes;
    }
}
