<?php
class MY_Controller extends CI_Controller {
    protected $header_file = 'common/header';
    protected $body_file;
    protected $footer_file = 'common/footer';
    protected $header_vars = array();
    protected $body_vars = array();
    protected $footer_vars = array();
 
    public function _remap($method, $params = array())
    {
        // you can set default variables to send to the template here
        // in reality, this probably going to be useful for loading in
        // some common variables from language files...
        $this->header_vars['title'] = 'My website';
        $this->body_file = strtolower(get_class($this)).'/'.$method;
        if (method_exists($this, $method))
        {
            $result = call_user_func_array(array($this, $method), $params);
            
            $this->load->view($this->header_file, $this->header_vars);
            $this->load->view($this->body_file, $this->body_vars);
            $this->load->view($this->footer_file, $this->footer_vars);
            return $result;
        }
        show_404();
    }
}
