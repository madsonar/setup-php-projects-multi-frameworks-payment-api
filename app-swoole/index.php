<?php

declare(strict_types=1);

use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Http\Client;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

$server = new Server('0.0.0.0', 9977);

$server->on('start', static function (Server $server) {
    echo "Swoole HTTP server http://localhost:9977";
});

$server->on('request', static function (Request $request, Response $response) {
    $username = 'madsonar';
    $token    = '';

    // Execução com corotinas
    $startTimeWithCoroutines = microtime(true);

    $client = new Client('api.github.com', 443, true);
    $client->setHeaders([
        'Authorization' => 'token ' . $token,
        'User-Agent' => 'swoole-http-client',
    ]);
    $client->get("/users/$username/repos");
    $repos = json_decode($client->body, true);
    $client->close();

    $channel = new Channel(count($repos));
    foreach ($repos as $repo) {
        go(static function () use ($repo, $username, $token, $channel) {
            $clientRepo = new Client('api.github.com', 443, true);
            $clientRepo->setHeaders([
                'Authorization' => 'token ' . $token,
                'User-Agent' => 'swoole-http-client',
            ]);

            $repoName = $repo['name'];
            $clientRepo->get("/repos/$username/$repoName");
            $repoDetails = json_decode($clientRepo->body, true);
            echo 'Repo full_name: ' . $repoDetails['full_name'] . "\n";
            $clientRepo->close();
            $channel->push(true);
        });
    }

    for ($i = 0; $i < count($repos); $i++) {
        $channel->pop();
    }
    echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";

    $endTimeWithCoroutines  = microtime(true);
    $durationWithCoroutines = $endTimeWithCoroutines - $startTimeWithCoroutines;

    // Execução sem corotinas
    $startTimeWithoutCoroutines = microtime(true);

    foreach ($repos as $repo) {
        $clientRepo = new Client('api.github.com', 443, true);
        $clientRepo->setHeaders([
            'Authorization' => 'token ' . $token,
            'User-Agent' => 'swoole-http-client',
        ]);

        $repoName = $repo['name'];
        $clientRepo->get("/repos/$username/$repoName");
        $repoDetails = json_decode($clientRepo->body, true);
        echo 'Repo full_name: ' . $repoDetails['full_name'] . "\n";
        $clientRepo->close();
    }

    $endTimeWithoutCoroutines  = microtime(true);
    $durationWithoutCoroutines = $endTimeWithoutCoroutines - $startTimeWithoutCoroutines;

    // Consolidar resposta
    $count        = count($repos);
    $responseText = "Repos ({$count}) user: $username" .
                    " | Exe com coroutines: {$durationWithCoroutines} seconds." .
                    " | Exe sem coroutines: {$durationWithoutCoroutines} seconds.";
    $response->end($responseText);
});

$server->start();
