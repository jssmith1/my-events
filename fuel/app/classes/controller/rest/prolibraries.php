<?php
class Controller_Rest_Prolibraries extends Controller_Rest
{

	private $authorizationkey = 'o2YG3Wkdt6DpSu8n';


	public function get_webinars()
	{

		$reference_id = $_GET['reference_id'];

	    $soap = Request::forge("http://www.prolibraries.com/library/api/findwebinar.php?wsdl", 'soap');  
	    $soap->set_function("FindWebinar");
	    $soap->set_params(array(array(
	    	"AuthorizationKey" => $this->authorizationkey,
	        "reference_id" => $reference_id
	        )
	    ));
	    $soap->execute();
	    $result = $soap->response()->body();

	    echo json_encode($result);
	  
	    
	}
}