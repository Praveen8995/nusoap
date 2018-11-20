<?php
 require_once('dbconn.php');
 require_once('lib/nusoap.php'); 
 $server = new nusoap_server();
function fetchBankDetails($ifsc){
	global $dbconn;
	$sql = "SELECT branch, bank_name, address, city, district, state , ifsc FROM mytable
	        where ifsc = :ifsc";
    $stmt = $dbconn->prepare($sql);
    $stmt->bindParam(':ifsc', $ifsc);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return json_encode($data);
    $dbconn = null;
}
$server->configureWSDL('bankServer', 'urn:bank');
$server->register('fetchBankDetails',
			array('ifsc' => 'xsd:string'),                               
			array('data' => 'xsd:string'),  
			'urn:bank',   
			'urn:bank#fetchBankDetails'
			);  
$server->service(file_get_contents("php://input"));

?>
