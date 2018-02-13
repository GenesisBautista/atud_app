<?php
class ImportModel extends Model{

    function __construct(){
        parent::__construct();

    }

    public function getcompanies(){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabImportCompany();
        $this->db->CloseConnection($link);
        return $return;
    }

    public function getmembers($company){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabMembers("1 OR atud_members.active = 0 ", $company, NULL);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function setverifier($id){
        $encrypted = md5($id);
        Session::set('verifier', $encrypted);
        return $encrypted;
    }

    public function getdelinquents(){
        $link = $this->db->OpenConnection();
        $return = $this->db->GetDelinquents(Session::get('usedids'), Session::get('company_id'));
        $this->db->CloseConnection($link);
        return $return;
    }
    /*
    verification and errors
    */
    public function getverifiererror(){
        return $_POST['verifier'] == Session::get('verifier') ? false : 'Invalid security token';
    }

    public function getextensionerror($extension){
        return in_array($extension, array('xls', 'xlsx')) ? false : 'Unknown file type';
    }

    public function setmessage($extension){
        $errors = array( $this->getverifiererror(), $this->getextensionerror($extension) );
        Session::remove('verifier');
        $message = 'File upload failed: ';
        if(  count(array_unique($errors)) === 1 ){
            Session::set('importmessage', 'File uploaded successfully');
            return;
        }
        Session::set( 'importmessage', $message.join( array_filter($errors), ', ' ) );
    }

    /*
    start import
    */
    public function run(){
        $file = explode('.', $_FILES['importfile']['name']);
        $extension = end($file);
        $this->setmessage($extension);
        //to do: read file and insert to db
        $importer = new ImportExtended($_POST['company']);
        if( $_POST['company'] == 8 ){
            Session::set('company_id', 7);
        }else{
            Session::set('company_id', $_POST['company']);
        }
        $sheetdata = $importer->CleanData($importer->getexcelobject($_FILES['importfile']['tmp_name']));
        $importer->loopthroughdata($sheetdata);
        header('location: '.URL.'import/flags');
        unlink($_FILES['importfile']['tmp_name']);
        exit;
    }

    /*
     * runflags
    */
    public function runflags(){
        $importer = new ImportExtended(Session::get('company_id'));
        $importer->runflags();
        header('location: '.URL.'import/delinquent');
        exit;
    }

    public function rundelinquents(){
        $importer = new ImportExtended(Session::get('company_id'));
        $importer->rundelinquents();
        header('location: '.URL.'import');
        exit;
    }
}
