<?php
require __DIR__ . '/../vendor/autoload.php';

use Nyholm\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use Spiral\RoadRunner\Worker;
use Spiral\RoadRunner\Http\PSR7Worker;

// Create new RoadRunner worker from global environment
$worker = Worker::create();
// Create common PSR-17 HTTP factory
$factory = new Psr17Factory();
$psr7 = new PSR7Worker($worker, $factory, $factory, $factory);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addGroup('/ru', function (\FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/cases', ['Russian', 'cases']);
        $r->addRoute('GET', '/name', ['Russian', 'name']);
        $r->addRoute('GET', '/detectGender', ['Russian', 'detectGender']);
        $r->addRoute('GET', '/pluralize', ['Russian', 'pluralize']);
        $r->addGroup('/noun', function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/cases', ['Russian', 'nounCases']);
            $r->addRoute('GET', '/pluralize', ['Russian', 'nounPluralize']);
        });
    });
});

class Russian {
    public function cases()
    {
        return \morphos\CasesHelper::getAllCases();
    }

    public function name(array $args)
    {
        return \morphos\Russian\inflectName($args['name'], $args['case'] ?? null, $args['gender'] ?? null);
    }

    public function detectGender(array $args)
    {
        return \morphos\Russian\detectGender($args['name']);
    }

    public function pluralize(array $args)
    {
        return \morphos\Russian\pluralize($args['count'], $args['word'], $args['animateness'] ?? false, $args['case'] ?? null);
    }

    public function nounCases(array $args)
    {
        return \morphos\Russian\NounDeclension::getCases($args['word'], $args['animateness'] ?? false);
    }

    public function nounPluralize(array $args)
    {
        return \morphos\Russian\NounPluralization::getCases($args['word'], $args['animateness'] ?? false);
    }
}

$handlers = [];

do {
    try {
        $request = $psr7->waitRequest();
        if ($request === null) {
            break;
        }
    } catch (\Throwable $e) {
        // Although the PSR-17 specification clearly states that there can be
        // no exceptions when creating a request, however, some implementations
        // may violate this rule. Therefore, it is recommended to process the
        // incoming request for errors.
        //
        // Send "Bad Request" response.
        $psr7->respond(new Response(400));
        continue;
    }

    try {
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                $psr7->respond(new Response(404));
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                $psr7->respond(new Response(405));
                break;
            case FastRoute\Dispatcher::FOUND:
                if (!isset($handlers[$routeInfo[1][0]])) {
                    $handlers[$routeInfo[1][0]] = new $routeInfo[1][0];
                }
                parse_str($request->getUri()->getQuery(), $args);
                // Reply by the 200 OK response
                $psr7->respond(
                    new Response(200, [
                        'Content-Type' => 'application/json',
                    ], json_encode(
                        [
                            'result' => call_user_func([
                                           $handlers[$routeInfo[1][0]],
                                           $routeInfo[1][1]
                                       ], $args)
                        ]
                    ))
                );
                break;
        }
    } catch (\Throwable $e) {
        // In case of any exceptions in the application code, you should handle
        // them and inform the client about the presence of a server error.
        //
        // Reply by the 500 Internal Server Error response
        $psr7->respond(new Response(500, [], 'Something Went Wrong!'));

        // Additionally, we can inform the RoadRunner that the processing
        // of the request failed.
        $psr7->getWorker()->error((string)$e);
    }
} while (isset($request));
