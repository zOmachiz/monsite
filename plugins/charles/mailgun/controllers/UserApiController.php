<?php

namespace Charles\Mailgun\Controllers;

use Session;

use Charles\Mailgun\Models\Contact;
use Charles\Mailgun\Models\Visit;

class UserApiController {

    public function index($userkey='3lrU70dUgW8R')
    {
    $contact = Contact::where('key', $userkey)->with('cloudis', 'client')->first();
    $contact->visits()->add(new Visit(['type' => 'site']));
    $contact['colors'] = $contact->client->colors;
	return $contact;
    }

}