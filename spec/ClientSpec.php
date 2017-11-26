<?php

namespace spec\Matthewbdaly\Postcode;

use Matthewbdaly\Postcode\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Matthewbdaly\Postcode\Exceptions\PaymentRequired;

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

    function it_can_send_the_request(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        $this->beConstructedWith($client, $messageFactory);
        $this->setKey('foo');
        $data = json_encode([
            'result' => [
                "postcode" => "SW1A 2AA",
                "postcode_inward" => "2AA",
                "postcode_outward" => "SW1A",
                "post_town" => "LONDON",
                "dependant_locality" => "",
                "double_dependant_locality" => "",
                "thoroughfare" => "Downing Street",
                "dependant_thoroughfare" => "",
                "building_number" => "10",
                "building_name" => "",
                "sub_building_name" => "",
                "po_box" => "",
                "department_name" => "",
                "organisation_name" => "Prime Minister & First Lord Of The Treasury",
                "udprn" => 23747771,
                "umprn" => "",
                "postcode_type" => "L",
                "su_organisation_indicator" => "",
                "delivery_point_suffix" => "1A",
                "line_1" => "Prime Minister & First Lord Of The Treasury",
                "line_2" => "10 Downing Street",
                "line_3" => "",
                "premise" => "10",
                "longitude" => -0.127695242183412,
                "latitude" => 51.5035398826274,
                "eastings" => 530047,
                "northings" => 179951,
                "country" => "England",
                "traditional_county" => "Greater London",
                "administrative_county" => "",
                "postal_county" => "London",
                "county" => "London",
            ]
        ]);
        $messageFactory->createRequest('GET', 'https://api.ideal-postcodes.co.uk/v1/postcodes/SW1A%202AA?api_key=foo', [], null, '1.1')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn($data);
        $this->get('SW1A 2AA')->shouldBeLike(json_decode($data, true));
    }

    function it_throws_an_exception_if_payment_required(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        $this->beConstructedWith($client, $messageFactory);
        $this->setKey('foo');
        $messageFactory->createRequest('GET', 'https://api.ideal-postcodes.co.uk/v1/postcodes/SW1A%202AA?api_key=foo', [], null, '1.1')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(402);
        $this->shouldThrow(PaymentRequired::class)->duringGet('SW1A 2AA');
    }
}
