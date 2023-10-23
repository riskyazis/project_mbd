<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/ReadProduksiCPOWithTransaction/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL ReadProduksiCPOWithTransaction(?)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    $app->put('/countries/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();

        $currentId = $args['id'];
        $countryName = $parsedBody["name"];
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL UpdateProduksiCPO');
        $query->execute([$countryName, $currentId]);

        $response->getBody()->write(json_encode(
            [
                'message' => 'country dengan id ' . $currentId . ' telah diupdate '
            ]
        ));

        return $response->withHeader("Content-Type", "application/json");
    });
    
    
};
