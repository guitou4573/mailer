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
        
        return $res;
    }
}