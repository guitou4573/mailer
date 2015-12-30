<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mailconsumer\Service\Mailchimp;
class ListController extends Controller
{
	protected $subscriptionHandler;

	public function __construct()
	{
		$this->mailingHandler = new Mailchimp($this);
	}

	public function getLists( Request $request )
	{
		return $this->mailingHandler->getLists($request);
	}

	public function createCampaign(Request $request)
	{
		return view('subscription.create');
	}	
}