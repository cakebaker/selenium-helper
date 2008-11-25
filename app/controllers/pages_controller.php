<?php

class PagesController extends AppController{
    public $helpers = array('Html', 'Selenium');
    public $uses = array();

    function display() {
        if (!func_num_args()) {
            $this->redirect('/');
        }
        
        $path = func_get_args();
        
        if (!count($path)) {
            $this->redirect('/');
        } elseif ($path[0] == 'tests') {
        	if (strpos($path[1], 'testsuite') !== false) {
        		$this->layout = 'selenium_testsuite';
        	} else {
        		$this->layout = 'selenium_testcase';
        	}
        }
        
        $this->set('page', $path[0]);
        $this->set('subpage', empty($path[1])? null: $path[1]);
        $this->set('title', ucfirst($path[count($path)-1]));
        $this->render(join('/', $path));
    }
}