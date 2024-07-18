<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class BackgroundProcessor 
{
    public function index()
    {
        $proc = new BackgroundProcess("curl -s -o " . $_SERVER['DOCUMENT_ROOT'] . "/log_background_process.log " . base_url('tools/message'), true);

        $pid = $proc->getProcessId();
        echo $pid . "\n";
    }
}