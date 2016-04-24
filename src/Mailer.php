<?php
declare(strict_types = 1);

namespace Zortje\Emailer;

use Zortje\Emailer\Adapter\ServiceAdapter;

/**
 * Class Mailer
 *
 * @package Zortje\Emailer
 */
class Mailer
{

    /**
     * @var ServiceAdapter
     */
    protected $serviceAdapter;

    /**
     * Mailer constructor.
     *
     * @param ServiceAdapter $serviceAdapter
     */
    public function __construct(ServiceAdapter $serviceAdapter)
    {
        $this->serviceAdapter = $serviceAdapter;
    }

    /**
     * Send email
     *
     * @param Email $email
     */
    public function send(Email $email)
    {
        $this->serviceAdapter->send($email);
    }
}
