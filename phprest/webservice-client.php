<?php
	require_once('lib/nusoap.php');
	$error  = '';
	$result = array();
	$wsdl = "http://localhost/Rest/webservice-server.php?wsdl";
	if(isset($_POST['sub'])){
		$ifsc = trim($_POST['ifsc']);
		if(!$ifsc){
			$error = 'ifsc code name cannot be left blank.';
		}

		if(!$error){
			$client = new nusoap_client($wsdl, true);
			$err = $client->getError();
			if ($err) {
				echo '<h2>Constructor error</h2>' . $err;
			    exit();
			}
			 try {
				$result = $client->call('fetchBankDetails', array($ifsc));
				$result = json_decode($result);
			  }catch (Exception $e) {
			    echo 'Caught exception: ',  $e->getMessage(), "\n";
			 }
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bank details Web Service</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Bank details Rest Web Service</h2>
  <p>Enter <strong>ifsc code</strong> and click <strong>Fetch Bank Information</strong> button.</p>
  <br />       
  <div class='row'>
  	<form class="form-inline" method = 'post' name='form1'>
  		<?php if($error) { ?> 
	    	<div class="alert alert-danger fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Error!</strong>&nbsp;<?php echo $error; ?> 
	        </div>
		<?php } ?>
	    <div class="form-group">
	      <label for="email">ifsc:</label>
	      <input type="text" class="form-control" name="ifsc" id="ifsc" placeholder="Enter ifsc"><br>
	    </div>
	    <button type="submit" name='sub' class="btn btn-default">Fetch Bank Information</button>
    </form>
   </div>
   <br />
   <h2>Bank Information</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ifsc</th>
        <th>branch</th>
        <th>bank</th>
        <th>address</th>
        <th>city</th>
        <th>district</th>
        <th>state</th>
      </tr>
    </thead>
    <tbody>
    <?php if(count($result)){ 
      		for ($i=0; $i < count($result); $i++) { ?>
		      <tr>
		        <td><?php echo $result->ifsc; ?></td>
		        <td><?php echo $result->branch; ?></td>
                        <td><?php echo $result->bank_name; ?></td>
                        <td><?php echo $result->address; ?></td>
                        <td><?php echo $result->city; ?></td>
                        <td><?php echo $result->district; ?></td>
                        <td><?php echo $result->state; ?></td>
		      </tr>
      <?php 
  			}
  		}else{ ?>
  			<tr>
		        <td colspan='5'>Enter ifsc code and click on Fetch Bank Information button</td>
		      </tr>
  		<?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>



