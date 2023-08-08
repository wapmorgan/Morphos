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
    $r->addGroup('/en', function (\FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/pluralize', [\morphos\Service\English::class, 'pluralize']);
        $r->addRoute('GET', '/cardinal', [\morphos\Service\English::class, 'cardinal']);
        $r->addRoute('GET', '/ordinal', [\morphos\Service\English::class, 'ordinal']);
        $r->addRoute('GET', '/time/spellDifference', [\morphos\Service\English::class, 'spellTimeDifference']);
        $r->addRoute('GET', '/time/spellInterval', [\morphos\Service\English::class, 'spellTimeInterval']);
    });
    $r->addGroup('/ru', function (\FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/cases', [\morphos\Service\Russian::class, 'cases']);
        $r->addRoute('GET', '/name', [\morphos\Service\Russian::class, 'name']);
        $r->addRoute('GET', '/detectGender', [\morphos\Service\Russian::class, 'detectGender']);
        $r->addRoute('GET', '/pluralize', [\morphos\Service\Russian::class, 'pluralize']);
        $r->addGroup('/noun', function (\FastRoute\RouteCollector $r) {
            $r->addGroup('/declension', function (\FastRoute\RouteCollector $r) {
                $r->addRoute('GET', '/cases', [\morphos\Service\Russian::class, 'nounDeclensionCases']);
                $r->addRoute('GET', '/detectGender', [\morphos\Service\Russian::class, 'nounDeclensionDetectGender']);
                $r->addRoute('GET', '/detect', [\morphos\Service\Russian::class, 'nounDeclensionDetect']);
                $r->addRoute('GET', '/isMutable', [\morphos\Service\Russian::class, 'nounDeclensionIsMutable']);
            });
            $r->addGroup('/pluralization', function (\FastRoute\RouteCollector $r) {
                $r->addRoute('GET', '/cases', [\morphos\Service\Russian::class, 'nounPluralizationCases']);
                $r->addRoute('GET', '/numeralForm', [\morphos\Service\Russian::class, 'nounPluralizationNumeralForm']);
            });
        });
        $r->addGroup('/cardinal', function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/cases', [\morphos\Service\Russian::class, 'cardinalCases']);
        });
        $r->addGroup('/ordinal', function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/cases', [\morphos\Service\Russian::class, 'ordinalCases']);
        });
        $r->addGroup('/geo', function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/cases', [\morphos\Service\Russian::class, 'geoCases']);
            $r->addRoute('GET', '/isMutable', [\morphos\Service\Russian::class, 'geoIsMutable']);
        });
        $r->addRoute('GET', '/money/spell', [\morphos\Service\Russian::class, 'spellMoney']);
        $r->addRoute('GET', '/time/spellDifference', [\morphos\Service\Russian::class, 'spellTimeDifference']);
        $r->addRoute('GET', '/time/spellInterval', [\morphos\Service\Russian::class, 'spellTimeInterval']);
        $r->addGroup('/prep', function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/in', [\morphos\Service\Russian::class, 'prepIn']);
            $r->addRoute('GET', '/with', [\morphos\Service\Russian::class, 'prepWith']);
            $r->addRoute('GET', '/about', [\morphos\Service\Russian::class, 'prepAbout']);
        });
        $r->addRoute('GET', '/verb/ending', [\morphos\Service\Russian::class, 'verbEnding']);
    });
});

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
                if (is_string($routeInfo[1])) {
                    $handlers = $routeInfo[1];
                } else if (is_array($routeInfo[1])) {
                    if (!isset($handlers[$routeInfo[1][0]])) {
                        $handlers[$routeInfo[1][0]] = new $routeInfo[1][0];
                    }
                    $handler = [$handlers[$routeInfo[1][0]], $routeInfo[1][1]];
                }
                parse_str($request->getUri()->getQuery(), $args);
                // Reply by the 200 OK response
                $psr7->respond(
                    new Response(200, [
                        'Content-Type' => 'application/json',
                    ], json_encode(
                        [
                            'result' => call_user_func($handler, $args, $dispatcher)
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
