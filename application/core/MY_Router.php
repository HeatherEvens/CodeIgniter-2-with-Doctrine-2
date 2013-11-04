<?php
class MY_Router extends CI_Router {
  function _validate_request($segments = array())
  {
    if (count($segments) == 0)
    {
      return $segments;
    }

    // for prettier URLs we use hyphens, but PHP methods must use underscores...
    foreach ($segments as $index => $segment)
    {
      $segments[$index] = str_replace('-','_',$segment);
    }

    // Does the requested controller exist in the root folder?
    if (file_exists(APPPATH.'controllers/'.$segments[0].'.php'))
    {
      return $segments;
    }

    // Is the controller in a sub-folder?
    if (is_dir(APPPATH.'controllers/'.$segments[0]))
    {
      // Set the directory and remove it from the segment array
      $this->set_directory($segments[0]);
      $segments = array_slice($segments, 1);

      if (count($segments) > 0)
      {
        // Does the requested controller exist in the sub-folder?
        if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].'.php'))
        {
          if ( ! empty($this->routes['404_override']))
          {
            $x = explode('/', $this->routes['404_override']);

            $this->set_directory('');
            $this->set_class($x[0]);
            $this->set_method(isset($x[1]) ? $x[1] : 'index');

            return $x;
          }
          else
          {
            array_unshift($segments,'pages');
          }
        }
      }
      else
      {
        // Is the method being specified in the route?
        if (strpos($this->default_controller, '/') !== FALSE)
        {
          $x = explode('/', $this->default_controller);

          $this->set_class($x[0]);
          $this->set_method($x[1]);
        }
        else
        {
          $this->set_class($this->default_controller);
          $this->set_method('index');
        }

        // Does the default controller exist in the sub-folder?
        if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.'.php'))
        {
          $this->directory = '';
          return array();
        }

      }
      return $segments;
    }

    foreach ($segments as $index => $segment)
    {
      $segments[$index] = str_replace('_','-',$segment);
    }
    
    // if the requested controller/method wasn't found we assume it to be a CMS 'page' and pass it to
    // the pages controller
    array_unshift($segments,'pages');

    // validate on the new method/controller
    return $this->_validate_request($segments);
  }
}
