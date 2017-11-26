<?php

namespace spec\Matthewbdaly\Postcode;

use Matthewbdaly\Postcode\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;

class ClientSpec extends ObjectBehavior
{
    function let (HttpClient $client, MessageFactory $messageFactory)
    {
        $this->beConstructedWith($client, $messageFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_can_retrieve_the_base_url()
    {
        $this->getBaseUrl()->shouldReturn('https://api.ideal-postcodes.co.uk/v1/postcodes/');
    }

    function it_can_get_and_set_the_key()
    {
        $this->getKey()->shouldReturn(null);
        $this->setKey('foo')->shouldReturn($this);
        $this->getKey()->shouldReturn('foo');
    }
}
