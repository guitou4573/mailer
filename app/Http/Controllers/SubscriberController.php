<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mailconsumer\Service\Mailchimp;
class SubscriberController extends Controller
{
	protected $subscriptionHandler;

	public function __construct()
	{
		$this->mailingHandler = new Mailchimp($this);
	}

	public function index( Request $request )
	{
        $listid = $request->listid;
		return $this->mailingHandler->getMembers($listid);
	}

	public function store(Request $request)
	{
        if(!$request->confirmed)
        {
            return false;
        }
        $listid = $request->listid;
        $member = [
            'status' => $request->statussub,
            'email_address' => $request->emailsub,
        ];
        if(!$request->hash)
        {
            return $this->mailingHandler->setMember($listid, $member);
        }
        else
        {
            return $this->mailingHandler->updateMember($listid, $request->hash, $member);
        }
    }
    
    public function destroy(Request $request)
    {
        $id = $request->id;
        $listid = $request->listid;
        return $this->mailingHandler->deleteMember($listid, $id);
    }
}