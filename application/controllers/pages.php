<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller {
  /**
   * Pages controller, build some CMS page retrieval in here
   */
  public function index()
  {
    $this->template_data['header']['meta_title'] = 'Default meta title';
  }

  public function show_page($page_id)
  {
    /* find the page with the specified ID and send to template */
    return true;
  }

  /**
   * @param $method
   * @param $params
   * @return boolean
   */
  private function _get_id($method,$params)
  {
    $method = str_replace('_','-',$method);
    $page_path = array($method);
    foreach ($params as $param)
    {
      $page_path[] = $param;
    }
    
    // with the page path now arraied, perform some interaction with the
    // database layer here to get the correct page ID to show
    
    return $thePageId;
  }

  public function _remap($method, $params)
  {
    // on receiving requests to this controller, try to find the specified page...
    $page_id = $this->_get_id($method,$params);
    if ($page_id > 0)
    {
      $this->main_template = strtolower(get_class($this)).'/show_page.phtml';
      $result = $this->show_page($page_id);
      if ($this->show_header)
        $this->load->view($this->header_template,$this->template_data['header']);
      $this->load->view($this->main_template,$this->template_data['body']);
      if ($this->show_footer)
        $this->load->view($this->footer_template,$this->template_data['footer']);
      return $result;
    }
    // if no page found, does this controller have a method with that name?
    if (method_exists($this, $method))
    {
      $this->main_template = strtolower(get_class($this)).'/'.$method.'.phtml';
      $result = call_user_func_array(array($this,$method),$params);
      if ($this->show_header)
        $this->load->view($this->header_template,$this->template_data['header']);
      $this->load->view($this->main_template,$this->template_data['body']);
      if ($this->show_footer)
        $this->load->view($this->footer_template,$this->template_data['footer']);
      return $result;
    }
    // failing all else, it's a 404 here
    else
    {
      show_404();
      return null;
    }
  }
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */
