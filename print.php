<?php

$file = $argv[1];

function usage() {
    global $argv;
    echo sprintf("Usage:  %s [filename]\n", $argv[0]);
    die();
}

if (!isset($file)) {
    usage();
}

if (!file_exists($file) || !is_file($file) || !is_readable($file)) {
    echo "Unable to access file...\n";
    die();
}

$config = require $file;
$routeConfig = $config['router']['routes'];

function printRoute(array $route, $previousRoutePath = '')
{
    $incompleteRoute = isset($route['child_routes']) && (!isset($route['may_terminate']) || !$route['may_terminate']);

    echo "<li>";
    echo "<h2 class='" . ($incompleteRoute ? 'incomplete-route' : '') . "'>";
    echo $previousRoutePath . $route['options']['route'];
    echo ($incompleteRoute ? ' (incomplete endpoint)' : '');
    echo "</h2>";

    if (isset($route['options']['defaults'])) {
        echo "<h4>Defaults:</h4>";
        echo "<table>";
        foreach ($route['options']['defaults'] as $key => $value) {
            echo "<tr>";
            echo "<td>$key</td>";
            echo "<td>$value</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    if (isset($route['options']['constraints'])) {
        echo "<h4>Constraints:</h4>";
        echo "<table>";
        foreach ($route['options']['constraints'] as $key => $value) {
            echo "<tr>";
            echo "<td>$key</td>";
            echo "<td>$value</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    if (isset($route['child_routes'])) {
        echo "<h4>Child routes:</h4>";
        printRoutes($route['child_routes'], $previousRoutePath . $route['options']['route']);
    }

    echo "</li>";
}

function printRoutes(array $routes, $previousRoutePath = '') {
    echo "<ul>";
    foreach ($routes as $route) {
        printRoute($route, $previousRoutePath);
    }
    echo "</ul>";
}

?>
<!DOCTYPE html>
<html>
<head>
<style>
ul li {
    list-style-type: none;
}
table {
    border-collapse: collapse;
}
table tr td {
    border: 1px solid black;
    margin: 0;
    padding: 3px;
}
table tr td:first-of-type {
    background-color: silver;
}
h2 {
    border-bottom: 2px solid silver;
}
h2.incomplete-route {
    color: grey;
}
</style>
</head>
<body>
<h1>Router configuration: <?php echo $file; ?></h1>
<?php printRoutes($routeConfig); ?>
</body>
</html>
