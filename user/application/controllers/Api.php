<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;
class Api extends REST_Controller
{

	public function __construct()
    {
       header('Access-Control-Allow-Origin: *');
       header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
       parent:: __construct();
       $this->load->database();
       $this->load->model('Gamermodel');
       $this->load->library('Authorization_Token');
    }
    

    // Get method

        public function getall_GET(){
        $gamer = new Gamermodel;
        $result = $gamer->get_gamer();
        $this->response($result,200);
    }
     
    // add method

    public function addgamer_POST(){
        $gamer = new GamerModel;
        $data = [
        'id'=> $this->input->POST('id'),
        'firstname' => $this->input->POST('firstname'),
		'lastname' => $this->input->POST("lastname"),
		'age' => $this->input->POST("age"),
		'gender' => $this->input->POST("gender"),
		'contact' => $this->input->POST("contact"),
		'email' => $this->input->POST("email"),
		'password' => md5($this->input->POST("password"))
        ];

        $add_result =  $gamer->insert_gamer($data);

        if($add_result == true)
        {
            $this->response([
                'status' => true,
                'message'=>'Gamer added successfully'
            ]);
        }else{
            $this->response([
                'status' => false,
                'message'=>'Gamer added failed'
            ]);
        }
    }
    
    // get by id method

    public function find_get($id){
        $gamer = new Gamermodel;
        $result = $gamer->edit_gamer($id);
        $this->response($result,200);
    }
    
    // update method

    public function update_POST($id){
        $gamer = new GamerModel;
        $data = [
        'firstname' => $this->input->POST('firstname'),
		'lastname' => $this->input->POST("lastname"),
		'age' => $this->input->POST("age"),
		'gender' => $this->input->POST("gender"),
		'contact' => $this->input->POST("contact"),
		'email' => $this->input->POST("email")
        ];

        $update_result = $gamer->update_gamer($id,$data);

        if($update_result == true)
        {
            // echo"hi";
            $this->response([
                'status' => true,
                'message'=>'Gamer updated successfully'
            ]);
        }else{
            $this->response([
                'status' => false,
                'message'=>'Gamer updated failed'
            ]);
        }
    }
    
    // delete method

    public function delete_delete($id){
        // $gamer = new GamerModel;
        $this->load->model('GamerModel');
        $delete_result = $this->GamerModel->delete($id);
        if($delete_result == true)
        {
            $this->response([
                'status' => true,
                'message'=>'Gamer deleted successfully'
            ]);
        }else{
            $this->response([
                'status' => false,
                'message'=>'Gamer deleted failed'
            ]);
        }
    }


	public function register_post()
	{   $token_data['id'] = 101;
		$token_data['username'] = 'hari'; 
        $token_data['email'] = 'abc@gmail.com'; 
		$token_data['users'] = 'abc@gmail.com'; 
        

		$tokenData = $this->authorization_token->generateToken($token_data);

		$final = array();
		$final['token'] = $tokenData;
		$final['status'] = 'ok';
 
		$this->response($final); 

	}
	public function verify_post()
	{  
		$headers = $this->input->request_headers(); 
		$decodedToken = $this->authorization_token->validateToken($headers['Authorization']);

		$this->response($decodedToken);  
	}


}

