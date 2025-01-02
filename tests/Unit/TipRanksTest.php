<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Nikosid\Tipranks\TipRanks;

it('calls login in the constructor', function () {
    $email = 'test@example.com';
    $password = 'password';

    $tipRanks = mock(TipRanks::class)
        ->makePartial()
        ->shouldReceive('login')
        ->once()
        ->with($email, $password)
        ->andReturnSelf()
        ->getMock();

    $tipRanks->__construct($email, $password);

    expect($tipRanks)->toBeInstanceOf(TipRanks::class);
});

it('handles request correctly', function () {
    $email = 'test@example.com';
    $password = 'password';

    $mockClient = mock(Client::class)
        ->shouldReceive('request')
        ->once()
        ->andReturn(new Response(200, [], json_encode(['success' => true])))
        ->getMock();

    $tipRanks = mock(TipRanks::class)
        ->makePartial()
        ->shouldReceive('login')
        ->once()
        ->with($email, $password)
        ->andReturnSelf()
        ->getMock();

    $tipRanks->__construct($email, $password);

    $reflection = new \ReflectionClass(TipRanks::class);
    $property = $reflection->getProperty('httpClient');
    $property->setAccessible(true);
    $property->setValue($tipRanks, $mockClient);

    $method = $reflection->getMethod('request');
    $method->setAccessible(true);

    $response = $method->invokeArgs($tipRanks, ['GET', '/test-endpoint']);

    expect($response)->toBeArray()
        ->and($response)->toHaveKey('success')
        ->and($response['success'])->toBeTrue();
});
