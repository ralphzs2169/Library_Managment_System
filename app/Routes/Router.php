<?php

class Router
{
    public function dispatch($uri, $method)
    {
        // Load database connection
        require_once __DIR__ . '/../Core/Database.php';
        $db = new Database(); 

        $routes = $this->getRoutes();

        if (!isset($routes[$method])) {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        foreach ($routes[$method] as $route => $handler) {
            // Convert dynamic segments {param} to regex
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match

                list($controllerName, $action) = explode('@', $handler);

                $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
                if (!file_exists($controllerFile)) {
                    http_response_code(500);
                    echo json_encode(['error' => "Controller $controllerName not found"]);
                    return;
                }

                require_once $controllerFile;

                $controller = new $controllerName($db);

                if (!method_exists($controller, $action)) {
                    http_response_code(404);
                    echo json_encode(['error' => "Method $action not found in $controllerName"]);
                    return;
                }

                // Get POST/PUT body if exists
                $data = json_decode(file_get_contents('php://input'), true);

                if (in_array($method, ['POST', 'PUT'])) {
                    $controller->$action($data, ...$matches);
                } else {
                    $controller->$action(...$matches);
                }
                return;
            }
        }

        // No route matched
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    private function getRoutes()
    {
        return [
            'POST' => [
                '/signup' => 'AuthController@signup',
                '/login' => 'AuthController@login',
                '/logout' => 'AuthController@logout',
               
                // Add more POST routes here
            ],
            'GET' => [
                '/test' => 'UserController@test',
                '/users' => 'RegisterController@getAllVerifiedUsers',
                // Add more GET routes here
            ],
            'PUT' => [
                '/updateUser/{id}' => 'LoginController@updateUser',
                // Add more PUT routes here
            ],
            'DELETE' => [
                '/deleteUser/{id}' => 'RegisterController@deleteUserById',
                // Add more DELETE routes here
            ],
        ];
    }
}
