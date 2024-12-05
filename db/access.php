<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'block/courses_by_month:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'user' => CAP_ALLOW,
            'guest' => CAP_PREVENT,
        ),
    ),
);
