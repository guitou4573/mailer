<?php 

namespace App\Mailconsumer\Service;

/*use App\User;*/

class Mailchimp {

	protected $client;
	protected $listener;

	public function __construct($listener)
	{
		$this->listener = $listener;   
        $this->client = new \GuzzleHttp\Client();

	}
    
    public function getLists()
    {
        $res = $this->client->request('GET', getenv('MAILCHIMP_API_URL') . '/lists', [
            'auth' => [getenv('MAILCHIMP_API_USR'), getenv('MAILCHIMP_API_KEY')]
        ]);

        return ($res->getStatusCode() == 200 ? $res : false);
    }
    
    public function setList($list)
    {
        $res = $this->client->request('POST', getenv('MAILCHIMP_API_URL') . '/lists', [
            'auth' => [getenv('MAILCHIMP_API_USR'), getenv('MAILCHIMP_API_KEY')],
            'body' => json_encode($list)
        ]);
        
        return ($res->getStatusCode() == 200 ? $res : false);
    }
    
    public function getMembers($listid)
    {
        $res = $this->client->request('GET', getenv('MAILCHIMP_API_URL') . '/lists/' .$listid. '/members', [
            'auth' => [getenv('MAILCHIMP_API_USR'), getenv('MAILCHIMP_API_KEY')]
        ]);

        return ($res->getStatusCode() == 200 ? $res : false);
    }
    
    public function setMember($listid, $member)
    {
        $res = $this->client->request('POST', getenv('MAILCHIMP_API_URL') . '/lists/' .$listid. '/members', [
            'auth' => [getenv('MAILCHIMP_API_USR'), getenv('MAILCHIMP_API_KEY')],
            'body' => json_encode($member)
        ]);
        
        return ($res->getStatusCode() == 200 ? $res : "error");
    }
    
    public function updateMember($listid, $id, $member)
    {
        $res = $this->client->request('PATCH', getenv('MAILCHIMP_API_URL') . '/lists/' .$listid. '/members/' .$id, [
            'auth' => [getenv('MAILCHIMP_API_USR'), getenv('MAILCHIMP_API_KEY')],
            'body' => json_encode($member)
        ]);
        
        return ($res->getStatusCode() == 200 ? $res : "error");
    }
    
    public function deleteMember($listid, $id)
    {
        $res = $this->client->request('DELETE', getenv('MAILCHIMP_API_URL') . '/lists/' .$listid. '/members/' .$id, [
            'auth' => [getenv('MAILCHIMP_API_USR'), getenv('MAILCHIMP_API_KEY')],
        ]);
        
        return $res;
    }
}