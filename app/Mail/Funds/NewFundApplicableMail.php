<?php

namespace App\Mail\Funds;

use App\Mail\ImplementationMail;

/**
 * Class NewFundApplicableMail
 * @package App\Mail\Funds
 */
class NewFundApplicableMail extends ImplementationMail
{
    private $fundName;
    private $link;

    public function __construct(
        string $fundName,
        string $link,
        string $identityId = null
    ) {
        parent::__construct($identityId);
        $this->fundName = $fundName;
        $this->link = $link;
    }

    public function build(): ImplementationMail
    {
        return parent::build()
            ->subject(mail_trans('new_fund_created.title'))
            ->view('emails.funds.new_fund_created', [
                'fund_name' => $this->fundName,
                'webshop_link' => $this->link
            ]);
    }
}
