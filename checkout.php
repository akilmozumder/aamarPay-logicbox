<?php
	session_start();
	@session_save_path("./");  //specify path where you want to save the session.
	require("functions.php");	//file which has required functions as provided by Reseller Club
	include("config.php");

	//$checksumStatus=1;
	//Reseller Club Details
// Reseller Club Code

		//Below are the  parameters which will be passed from foundation as http GET request

		$paymentTypeId = $_GET["paymenttypeid"];  //payment type id
		$transId = $_GET["transid"];			   //This refers to a unique transaction ID which we generate for each transaction
		//$txnid= $_GET["transid"];
		$userId = $_GET["userid"];               //userid of the user who is trying to make the payment
		$userType = $_GET["usertype"];  		   //This refers to the type of user perofrming this transaction. The possible values are "Customer" or "Reseller"
		$transactionType = $_GET["transactiontype"];  //Type of transaction (ResellerAddFund/CustomerAddFund/ResellerPayment/CustomerPayment)

		$invoiceIds = $_GET["invoiceids"];		   //comma separated Invoice Ids, This will have a value only if the transactiontype is "ResellerPayment" or "CustomerPayment"
		$debitNoteIds = $_GET["debitnoteids"];	   //comma separated DebitNotes Ids, This will have a value only if the transactiontype is "ResellerPayment" or "CustomerPayment"

		$description = $_GET["description"];

		$sellingCurrencyAmount = $_GET["sellingcurrencyamount"]; //This refers to the amount of transaction in your Selling Currency
		
        $accountingCurrencyAmount = $_GET["accountingcurrencyamount"]; //This refers to the amount of transaction in your Accounting Currency

		$redirectUrl = $_GET["redirecturl"];  //This is the URL on our server, to which you need to send the user once you have finished charging him


		$checksum = $_GET["checksum"];	 //checksum for validation

		//Extra added field
		 $name1 = $_GET['name'];
		 $email1 = $_GET['emailAddr'];
		 $telephone = $_GET['telNo'];
		$city1 = $_GET['city'];
		$state1 = $_GET['state'];
		$country1 = $_GET['country'];
		$zip1 = $_GET['zip'];
		$address11 = $_GET['address1'];
		$address21 = $_GET['address2'];
	    $surl1 = $redirect_url;
		$furl1 = $redirect_url;
		$curl1 = $redirect_url;
//$PAYU_BASE_URL = "";


		if(verifyChecksum($paymentTypeId, $transId, $userId, $userType, $transactionType, $invoiceIds, $debitNoteIds, $description, $sellingCurrencyAmount, $accountingCurrencyAmount, $key, $checksum))
		{

		/**
		* since all these data has to be passed back to foundation after making the payment you need to save these data
		*
		* You can make a database entry with all the required details which has been passed from foundation.
		*
		*							OR
		*
		* keep the data to the session which will be available in responsehandler.php as we have done here.
		*
		**/
			$_SESSION['redirecturl']=$redirectUrl;
			$_SESSION['transid']=$transId;
			$_SESSION['sellingcurrencyamount']=$sellingCurrencyAmount;
			$_SESSION['accountingcurencyamount']=$accountingCurrencyAmount;
		$checksumStatus=1;

		}
		else
		{
			$checksumStatus=0;
			$base_url="";
		}



$hash = '';
//$productinfo1 = json_encode(json_decode('[{"name":"$name1","description":"$description","value":"$sellingCurrencyAmount","isRequired":"false"}]'));

   $hash_string = '';
   $hash_string .= $merchant_id.'|'.$transId.'|'.$sellingCurrencyAmount.'|'.$transactionType.'|'.$name1.'|'.$email1.'|||||||||||';
   $hash_string .= $salt;
   $hash = "28c78bb1f45112f5d40b956fe104645e";


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>aamarPay Gateway</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom -->
    <link href="css/custom.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body style="background:#ecf0f1;">
    <form action="<?php echo $base_url; ?>" method="post" name="paymentpage">
      <input type="hidden" name="store_id" value="<?php echo $merchant_id ?>" />
      <input type="hidden" name="currency" value="BDT">
      <input type="hidden" name="desc" value="Payment From Reseller Club">
      <input type="hidden" name="signature_key" value="<?php echo $hash ?>"/>
      <input type="hidden" name="tran_id" value="<?php echo $transId ?>" />
      <input type="hidden" name="amount" value="<?php echo $sellingCurrencyAmount?>" />
      <input type="hidden" name="cus_name" id="firstname" value="<?php echo $name1; ?>" />
      <input type="hidden" name="cus_email" id="email" value="<?php echo $email1; ?>" />
      <input type="hidden"name="cus_phone" value="<?php echo $telephone; ?>" />
      <input type="hidden" name="productinfo" value="<?php echo $transactionType; ?>" />
      <input type="hidden" name="success_url" value="<?php echo $surl1; ?>" size="64" />
      <input type="hidden" name="fail_url" value="<?php echo $furl1; ?>" size="64" />
      <input type="hidden" name="cancel_url" value="<?php echo $curl1; ?>" />
      <input type="hidden" name="cus_add1" value="<?php echo $address11; ?>" />
      <input type="hidden" name="cus_city" value="<?php echo $city1; ?>" />
      <input type="hidden" name="cus_state" value="<?php echo $state1; ?>" />
      <input type="hidden" name="cus_country" value="<?php echo $country1; ?>" />
      <input type="hidden" name="cus_postcode" value="<?php echo $zip1; ?>" />
      <input type="hidden" value="Submit" />

    </form>
 <section id="transMessageSec" class="container">

	<!--GIF LOADER-->

        <div class="row">
			<div class="col-md-3"></div>
            <div id="loaderCol" class="col-md-6">
				<center>
					<img class="img-responsive" src="images/ajax-loader.gif"/>
				</center>
            </div>
			<div class="col-md-3"></div>
        </div>

	<!--GIF LOADER-->

       <?php if($checksumStatus){ ?>
	<!--TRANSACTION MESSAGE-->

        <div class="row">
            <div id="messageDiv" class="col-md-12">
                <div class="alert-message alert-message-success text-center">
                    <h4>Transaction is being processed</h4>
                    <p>Please wait while your transaction is being processed ... </p>
                   <p> (Please do not use "Refresh" or "Back" button)</p>
                </div>
            </div>
        </div>

	<!--TRANSACTION MESSAGE-->
	<?php } ?>
	<?php if(!$checksumStatus){ ?>

<!--NOTIFICATION MESSAGE-->

		<div class="row">
			<div class="col-sm-3"></div>

            <div id="messageDiv" class="col-md-6">
               <center>
					<div id ="notificationBar" class="alert alert-danger" role="alert">
<b>Security Error.</b> Illegal access detected</div>
				</center>
            </div>

			<div class="col-sm-3"></div>
        </div>

	<!--NOTIFICATION MESSAGE-->
    <?php } ?>
		</section>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
<?php if($checksumStatus){ ?>
<script language='javascript'>document.paymentpage.submit();</script>
<?php }?>

 </body>
</html>
