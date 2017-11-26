<?php

namespace spec\Matthewbdaly\Postcode;

use Matthewbdaly\Postcode\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }
}
