<?php
declare(strict_types = 1);

namespace Zortje\Emailer\Adapter;

use Zortje\Emailer\Email;

/**
 * Class ServiceAdapterInterface
 *
 * @package Zortje\Emailer\Adapter
 */
interface ServiceAdapterInterface
{

    /**
     * Sends email
     *
     * @param Email $email
     *
     * @return void
     */
    public function send(Email $email);
}
