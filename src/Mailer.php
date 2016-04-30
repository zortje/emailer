<?php
declare(strict_types = 1);

namespace Zortje\Emailer;

use Zortje\Emailer\Adapter\ServiceAdapterInterface;

/**
 * Class Mailer
 *
 * @package Zortje\Emailer
 */
class Mailer
{

    /**
     * @var ServiceAdapterInterface
     */
    protected $serviceAdapter;

    /**
     * Mailer constructor.
     *
     * @param ServiceAdapterInterface $serviceAdapter
     */
    public function __construct(ServiceAdapterInterface $serviceAdapter)
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
