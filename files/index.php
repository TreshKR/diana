<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diana - Timeline App</title>
    <link href="/assets/css/output.css" rel="stylesheet">
    <!--<script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <header class="py-6">
            <h1 class="text-3xl font-bold text-gray-800">Diana Timeline</h1>
        </header>
        
        <div class="flex">
            <!-- Filters -->
            <aside class="w-1/4 pr-4">
                <h2 class="text-xl font-semibold mb-4">Filters</h2>
                <!-- Add filter options here -->
            </aside>
            
            <!-- Timeline -->
            <main class="w-3/4">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <!-- Timeline content will go here -->
                    <div class="space-y-4">
                        <?php
                        // Placeholder for PHP code to fetch and display events
                        $events = [
                            ['date' => '2024-10-18', 'title' => 'Team Meeting'],
                            ['date' => '2024-10-19', 'title' => 'Client Call'],
                            ['date' => '2024-10-20', 'title' => 'Project Deadline'],
                        ];
                        
                        foreach ($events as $event) {
                            echo "<div class='flex items-center'>";
                            echo "<div class='w-24 text-sm text-gray-600'>{$event['date']}</div>";
                            echo "<div class='flex-grow bg-blue-100 rounded p-2'>{$event['title']}</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>