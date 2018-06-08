<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Paypal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';

    }

    public function index()
    {
        echo "Hello<br>";
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'Ae2NJOctg4lZz8B-jNJZgowqyZ_Aey7kM3oBvCazeozECsHo_uA0X9a3_z1TED8be_71V45L50-5b-9C',     // ClientID
                'ELXfovM4wydVSQjsfxsFneMiEsoxf6A3ZeLWMtJ-aGpECc-IUQ60uSHHvLMlCaJoiRALW6vVTyUGDSLt'      // ClientSecret
            )
        );

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');
        $amount = new \PayPal\Api\Amount();
        $amount->setTotal('1.00');
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("https://localhost/Exerseaza/paypal/thankyou")
            ->setCancelUrl("https://localhost/Exerseaza/paypal/cancelled");

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        $request = clone $payment;

        try {
            $payment->create($apiContext);
            //echo $payment;

            //echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            //echo $ex->getData();
            echo "Error - create api context.";
        }

        $approvalUrl = $payment->getApprovalLink();
       echo "<a href='$approvalUrl' >$approvalUrl</a>";

        return $payment;
    }

    public function thankyou()
    {
        $this->db->insert('payment', ['status' => true, 'data' => date("Y-m-d h:i:sa")]);
    }

    public function cancelled()
    {
        $this->db->insert('payment', ['status' => true, 'data' => date("Y-m-d h:i:sa")]);
    }

    public function process()
    {

    }
}