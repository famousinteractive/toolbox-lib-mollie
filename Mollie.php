<?php
namespace App\Libraries\Famous\Mollie;

class Mollies
{

    protected $_mollie;

    /**
     * Mollies constructor.
     * @throws \Mollie_API_Exception
     * @throws \Mollie_API_Exception_IncompatiblePlatform
     */
    public function __construct() {
        $this->_mollie = new \Mollie_API_Client();
        $this->_mollie->setApiKey(env('MOLLIE_IS_LIVE') == true ? env('MOLLIE_API_LIVE_KEY') : env('MOLLIE_API_TEST_KEY') );
    }

    public function getPaymentUrl($amount, $orderId, $description) {
        try
        {
            $payment = $this->_mollie->payments->create(
                array(
                    'amount'      => $this->formatAmount($amount),
                    'description' => $description,
                    'redirectUrl' => route('mollie.after'),
                    'webhookUrl'  => route('mollie.callback'),
                    'metadata'    => array(
                        'order_id' => $orderId
                    )
                )
            );

            return $payment->getPaymentUrl();
        }
        catch (\Mollie_API_Exception $e)
        {
            $errorMsg =  "API call failed: " . htmlspecialchars($e->getMessage());
            $errorMsg2 =  " on field " . htmlspecialchars($e->getField());
            \Log::error($errorMsg);
            \Log::error($errorMsg2);
            return $errorMsg . $errorMsg2;
        }
    }

    public function getPayment($trId) {
        return $this->_mollie->payments->get($trId);
    }

    protected function formatAmount($amount) {
        return str_replace(',', '.', $amount);
    }

}