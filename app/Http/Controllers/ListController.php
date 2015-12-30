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

	public function index( Request $request )
	{
		return $this->mailingHandler->getLists($request);
	}

	public function store(Request $request)
	{  
        $list = [
            'name' => $request->listname,
            'contact' => [
                'company' => 'DumLi',
                'address1' => '1 Wandaa Crt Coolum Beach',
                'city' => 'Coolum Beach',
                'state' => 'Qld',
                'zip' => '4573',
                'country' => 'Australia',
            ],
            'permission_reminder' => $request->reminder,
            'campaign_defaults' => [
                'from_name' => $request->listnamefrom,
                'from_email' => $request->listemailfrom,
                'subject' => 'My Subject',
                'language' => 'english',
            ],
            'email_type_option' => false
        ];
        $this->mailingHandler->setList($list);
	}	
}