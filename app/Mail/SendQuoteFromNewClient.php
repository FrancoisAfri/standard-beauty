<?php

namespace App\Mail;

use App\User;
use App\CompanyIdentity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendQuoteFromNewClient extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
	public $first_name;
	public $surname;
	public $company_email;
	public $contact_number;
	public $users_range;
	public $portal_option;
	public $adv;
    public function __construct($first_name, $surname, $company_email, $contact_number, $users_range, $portal_option, $adv)
    {
        $this->first_name = $first_name;
        $this->surname = $surname;
        $this->company_email = $company_email;
        $this->contact_number = $contact_number;
        $this->users_range = $users_range;
        $this->portal_option = $portal_option;
        $this->adv = $adv;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $companyDetails = CompanyIdentity::systemSettings();
        $companyName = $companyDetails['company_name'];
        $subject = "New Enquiry | $companyName";

        $data['support_email'] = $companyDetails['support_email'];
        $data['company_name'] = $companyName;
        $data['full_company_name'] = $companyDetails['full_company_name'];
        $data['company_logo'] = url('/') . $companyDetails['company_logo_url'];
        $data['profile_url'] = url('/');

        return $this->view('mails.send_new_user_quotation')
            ->from($companyDetails['mailing_address'], $companyDetails['mailing_name'])
            ->subject($subject)
            ->with($data);
    }
}
