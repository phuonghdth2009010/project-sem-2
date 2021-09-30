<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;

class PaypalController extends Controller
{
    public function createPayment(Request $request)
    {
        $orderId = $request->get('orderId');
        $order = Order::find($orderId);
        if ($order == null) {
            return 1;
        }
        // Xử lý tạo payment của paypal sau khi có orders
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AfPOmD4sA0AMx73t_1bqi5Zqvh84TOK8HKQzxfh7u6TfFVOABPEghh8a0epynKRfzTz4C9ZhzQCDxLCN',
                'EGVcw6zQExO66g6M4ZxEkJMVg2-Ubny5XF0eWvqg5whO9ZnB2aW8yakzuIRDjVZW-mVpjk2ATzKVJB17'
            )
        );
        $apiContext->setConfig([
            'mode' => 'sandbox'
        ]);
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $itemArray = [];
        $totalPrice = 0;
        foreach ($order->orderDetails as $orderDetail) {
            $totalPrice += $orderDetail->unitPrice / 22750 * $orderDetail->quantity;
            $item = new Item();
            $item->setName($orderDetail->product->name)
                ->setCurrency('USD')
                ->setQuantity($orderDetail->quantity)
                ->setSku($orderDetail->productId)
                ->setPrice($orderDetail->unitPrice / 22750);
            array_push($itemArray, $item);
        }
        $itemList = new ItemList();
        $itemList->setItems($itemArray);

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($totalPrice);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($totalPrice)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Thanh toán thành công")
            ->setInvoiceNumber($order->id);
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://127.0.0.1:8000/paypal/success")
            ->setCancelUrl("http://127.0.0.1:8000/paypal/cancel");

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            exit(1);
        }
        return $payment;
    }

    public function executePayment(Request $request)
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AfPOmD4sA0AMx73t_1bqi5Zqvh84TOK8HKQzxfh7u6TfFVOABPEghh8a0epynKRfzTz4C9ZhzQCDxLCN',
                'EGVcw6zQExO66g6M4ZxEkJMVg2-Ubny5XF0eWvqg5whO9ZnB2aW8yakzuIRDjVZW-mVpjk2ATzKVJB17'
            )
        );
        $apiContext->setConfig([
            'mode' => 'sandbox'
        ]);
        $paymentID = $request->get('paymentID');
        $payerID = $request->get('payerID');
        $payment = Payment::get($paymentID, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);
        try {
            $result = $payment->execute($execution, $apiContext);
            try {
                $payment = Payment::get($paymentID, $apiContext);
                if (count($payment->transactions) > 0) {
                    $orderId = $payment->transactions[0]->invoice_number;
                    $order = Order::find($orderId);
                    if ($order != null) {
                        $order->status = Status::PAID;
                        $order->is_checkout = 1;
                        $order->save();
                        if (Auth::check()) {
                            $this->send_mail($order);
                        }
                    }
                }
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode(); // Prints the Error Code
                echo $ex->getData(); // Prints the detailed error message
                die($ex);
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode(); // Prints the Error Code
            echo $ex->getData(); // Prints the detailed error message
            die($ex);
        }
        return $payment;
    }

    public function send_mail($order)
    {
        $data = [
            'order' => $order,
            'user' => Auth::user(),
        ];
        Mail::send('mails.mail', $data, function ($message) {
            $message->from(env('MAIL_USERNAME'), 'Cơm chay');
            $message->to(Auth::user()->email, 'Phuong');
            $message->subject('Cơm chay - Đơn hàng mới');
        });
    }
}
