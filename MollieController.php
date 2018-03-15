<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Famous\Mollie\Mollies;
use Illuminate\Http\Request;

class MollieController extends Controller
{

	public function callback(Request $request) {


		$mollie = new Mollies(); //TODO catch exception like you want

		$transactionId = $request->get('id');
		$mollieData = $mollie->getPayment( $transactionId);

		$orderId = $mollieData->metadata->order_id;


		if($mollieData->isPaid()) {
			/**
			 * TODO stuff is payment is ok
			 */
		} else {
			/**
			 * TODO stuff if payment failed
			 */
		}

		die('ok');
	}

	public function afterPayment(Request $request) {
		return view()->make('mollie.after');
	}


}
