<?php
require("utils/Diana.php");
$Diana = new Diana();

$project_id = 1;

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {}

// EJ http://localhost:8080/?tags=work&color=blue&icon=users

// FILTERS
$filters = [];
// TAGS
if ( !empty($_GET["tags"]) ) {
    $filters["tags"] = array_filter(array_map('trim', explode(",", $_GET["tags"])));
}
// COLOR
if ( !empty($_GET["color"]) ) {
    $filters["color"] = $_GET["color"];
}
// ICON
if ( !empty($_GET["icon"]) ) {
    $filters["icon"] = $_GET["icon"];
}
// DATE
if ( !empty($_GET["date"]) ) {
    $filters["date"] = ["2024-10-01", "2024-10-20"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diana - Timeline App</title>
    <link href="/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <div class="flex h-screen">
        <!-- Left Column - Actions & Filters -->
        <aside class="w-64 bg-gray-800 p-4 border-r border-gray-700">
            <!-- Project Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-400 mb-2">Project</label>
                <div class="relative">
                    <select class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Personal Timeline</option>
                        <option>Work Project</option>
                        <option>Study Notes</option>
                    </select>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-300">Filters</h2>
                
                <!-- Date Range -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-400">Date Range</label>
                    <input type="date" class="w-full bg-gray-700 border border-gray-600 rounded-md py-1 px-2 text-gray-200">
                </div>

                <!-- Tags -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-400">Tags</label>
                    <div class="space-y-1">
                        <?php
                        $tags = $Diana->tag_list( $project_id );
                        foreach ($tags as $tag) {
                            echo "<label class='flex items-center space-x-2'>
                                    <input type='checkbox' class='rounded bg-gray-700 border-gray-600 text-blue-500 focus:ring-blue-500'>
                                    <span class='text-gray-300'>{$tag['name']}</span>
                                  </label>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Middle Column - Timeline -->
        <main class="flex-1 bg-gray-900 p-6 overflow-y-auto border-r border-gray-700">
            <div class="space-y-4">
                <?php
                $events = $Diana->event_list( $filters );
                foreach ($events as $event) {
                    echo "<div class='flex items-center space-x-4 p-3 bg-gray-800 rounded-lg hover:bg-gray-750 cursor-pointer transition-colors duration-150'>";
                    echo "  <div class='text-sm text-gray-400'>{$event['display_timestamp']}</div>";
                    echo "  <div class='flex-grow flex items-center space-x-2'>";
                    echo "    <div class='w-2 h-2 rounded-full {$event['color']}'></div>";
                    echo "    <div class='text-gray-200'>{$event['title']}, {$event['color']}, {$event['icon']}</div>";
                    echo "  </div>";
                    echo "  <span class='px-2 py-1 text-xs rounded-full bg-gray-700 text-gray-300'>{$event['tags']}</span>";
                    echo "</div>";
                }
                ?>
            </div>
        </main>

        <!-- Right Column - Event Details/Creation -->
        <aside class="w-96 bg-gray-800 p-6">
            <div class="text-center text-gray-500 h-full flex items-center justify-center">
                <p>Select an event to view details<br>or create a new one</p>
            </div>
        </aside>
    </div>
</body>
</html>