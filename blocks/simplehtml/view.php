<?php
 
require_once('../../config.php');
require_once('simplehtml_form.php');
 
global $DB, $OUTPUT, $PAGE;
 
// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
 
$blockid = required_param('blockid', PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$viewpage = optional_param('viewpage', false, PARAM_BOOL);
 
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_simplehtml', $courseid);
}
 
require_login($course);

$PAGE->set_url('/blocks/simplehtml/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('edithtml', 'block_simplehtml'));
 
$simplehtml = new simplehtml_form();

$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$simplehtml->set_data($toform);


if($simplehtml->is_cancelled()){
    $courseurl = new moodle_url('/course/view.php', array('id'=>$id));
    redirect($courseurl);
}
else if($simplehtml->get_data()){
    $fromform = $simplehtml->get_data();
    $courseurl = new moodle_url('/course/view.php', array('id'=>$id));
    //print_object($fromform);
    
    
    if (!$DB->insert_record('block_simplehtml', $fromform))     {
            print_error('inserterror', 'block_simplehtml');
        }
    redirect($courseurl);    
}
else{
 
echo $OUTPUT->header();    
if ($viewpage) {
    $simplehtmlpage = $DB->get_record('block_simplehtml', array('id' => $id));
    block_simplehtml_print_page($simplehtmlpage);
} else {
    $simplehtml->display();
}
$settingsnode = $PAGE->settingsnav->add(get_string('simplehtmlsettings', 'block_simplehtml'));
$editurl = new moodle_url('/blocks/simplehtml/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
$editnode = $settingsnode->add(get_string('editpage', 'block_simplehtml'), $editurl);
$editnode->make_active();
$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$simplehtml->set_data($toform);


echo $OUTPUT->footer();
}
?>