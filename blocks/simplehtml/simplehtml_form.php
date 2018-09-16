<?php

    require_once("{$CFG->libdir}/formslib.php");
    require_once($CFG->dirroot.'/blocks/simplehtml/lib.php');
 
    class simplehtml_form extends moodleform {

        function definition() {

            $mform =& $this->_form;
            
            $mform->addElement('header','displayinfo', get_string('textfields', 'block_simplehtml'));
            
            $mform->addElement('text', 'pagetitle', get_string('pagetitle', 'block_simplehtml'));
            $mform->setType('pagetitle', PARAM_RAW);
            $mform->addRule('pagetitle', null, 'required', null, 'client');

            $mform->addElement('htmleditor', 'displaytext', get_string('displayedhtml', 'block_simplehtml'));
            $mform->setType('displaytext', PARAM_RAW);
            $mform->addRule('displaytext', null, 'required', null, 'client');

            $mform->addElement('filepicker', 'filename', get_string('file'), null, array('accepted_types' => '*'));
            $images = block_simplehtml_images();
            $radioarray = array();
            for ($i = 0; $i < count($images); $i++) {
                $radioarray[] =& $mform->createElement('radio', 'picture', '', $images[$i], $i);
            }
            $mform->addGroup($radioarray, 'radioar', get_string('pictureselect', 'block_simplehtml'), array(' '), FALSE);
            
            $mform->addElement('header', 'optional', get_string('optional', 'form'), null, false);
            $mform->addElement('date_time_selector', 'displaydate', get_string('displaydate', 'block_simplehtml'), array('optional' => true));
            $mform->setAdvanced('optional');
            
            $mform->addElement('hidden','blockid');
            $mform->addElement('hidden','courseid');

            $this->add_action_buttons();

        }

    }

