<?php
declare(strict_types = 1);

namespace Zortje\Emailer\Adapter;

use Zortje\Emailer\Email;

/**
 * Class ServiceAdapter
 *
 * @package Zortje\Emailer\Adapter
 */
interface ServiceAdapter
{

    /**
     * Sends email
     *
     * @param Email $email
     */
    public function send(Email $email);
}
