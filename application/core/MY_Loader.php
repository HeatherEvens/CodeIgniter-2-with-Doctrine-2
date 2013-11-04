<?php
class MY_Loader extends CI_Loader
{

  /**
   * Returns true if the model with the given name is loaded; false otherwise.
   *
   * @param   string  name for the model
   * @return  bool
   */
  public function is_loaded($name,$type = 'model')
  {
    return in_array($name, $this->_ci_models, TRUE);
  }
}
/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
