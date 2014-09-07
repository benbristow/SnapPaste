<?php
class App extends CI_Controller {
    public function index() {
        $this->loadPage("home", array("title" => "Home"));
    }
    
    public function submit() {
        //Load Form Validation library
        $this->load->library('form_validation');
        
        //Disable non-POST access.
        if(!$this->input->post()) {
            return $this->showErrorPage("Cannot directly access this URL.");  
        }
        
        //Make sure we have some paste content.
        $this->form_validation->set_rules('pastecontents', 'Paste Contents', 'required');
        if (!$this->form_validation->run()) {
            return $this->showErrorPage("You can't submit an empty paste!");   
        }
        
        //Grab paste contents
        $pastecontents = $this->input->post('pastecontents');
        
        //Parse into markdown
        $this->load->library('markdown');
        $pastecontents = $this->markdown->parse($pastecontents);
        
        //If we don't have a paste title, make one.
        $pastetitle = $this->input->post('pastetitle');
        if(strlen($pastetitle) == 0) {
            $pastetitle = "Untitled Paste";
        }
        
        //Generate paste ID
        $pasteid = uniqid(null, true);
        
        //Submit into database
        $sqldata = array('pasteid' => $pasteid, 'title' => $pastetitle, 'contents' => $pastecontents);
        $this->db->insert('pastes', $sqldata);
        
        //Get Paste ID
        $insertid = $this->db->insert_id();
        $insertdata = $this->db->get_where('pastes', array('id' => $insertid));
        
        return $this->loadPage("success", array("title" => "Success!", "pasteid" => $insertdata->row()->pasteid, "pastecontents" => $insertdata->row()->contents));
    }
    
    public function view($id) {
        //Make sure ID is supplied
        if(!$id) {
            return $this->showErrorPage("No paste ID supplied");   
        }
        
        //Get Paste information
        $query = $this->db->get_where('pastes', array('pasteid' => $id));
        
        //If no paste info, show error
        if($query->num_rows == 0) {
            return $this->showErrorPage("Paste does not exist. It has probably already been viewed.");   
        }
        
        //Get paste information
        $pasteinfo = $query->row();
        $pastetitle = $pasteinfo->title;
        $pastecontents = $pasteinfo->contents;
        $pastedate = $pasteinfo->date;
        
        //Now delete the paste info.
        $this->db->delete('pastes', array('pasteid' => $id));
        
        //Now show to the user
        $data = array('title' => $pastetitle, 'pastetitle' => $pastetitle, 'pastecontents' => $pastecontents, 'pastedate' => $pastedate);
        return $this->loadPage("view", $data, true);
    }
    
    private function loadPage($page, $data, $nocache = false) {
        
        if($nocache) {
            //Disable cache for view pages
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache"); 

        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }
    
    private function showErrorPage($error) {
        $this->loadPage("error", array('title' => "Error!", 'errortext' => $error));           
    }
}
?>