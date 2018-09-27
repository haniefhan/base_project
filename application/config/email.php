<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// mail server google
$config['protocol']     = 'smtp';
$config['smtp_host']    = 'ssl://smtp.gmail.com';
$config['smtp_port']    = '465';
$config['smtp_timeout'] = '120';
$config['smtp_user']    = 'haniefhan@gmail.com';
$config['smtp_pass']    = '*********';
$config['charset']    	= 'utf-8';
$config['newline']    	= "\r\n";
$config['mailtype']     = 'html'; // or html
$config['validation'] 	= TRUE; // bool whether to validate email or not
$config['email_from']   = 'admin@base_project.com';