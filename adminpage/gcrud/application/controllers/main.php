<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Main extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */ 
 
        $this->load->library('grocery_CRUD');
 
    }
 
    public function index()
    {
        echo "<h1>Welcome to the world of Codeigniter</h1>";//Just an example to ensure that we get into the function
        die();
    }
 
    public function activity()
    {
        $this->grocery_crud->set_table('activity_table');
        $output = $this->grocery_crud->render();
 
        $this->activity_output($output);        
    }
 
    function activity_output($output = null)
 
    {
        $this->load->view('view_template.php',$output);    
    }
}
 
/* End of file main.php */
/* Location: ./application/controllers/main.php */
?>