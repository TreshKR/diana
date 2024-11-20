<?php
require("utils/Diana.php");
$Diana = new Diana();

$projects = $Diana->project_list();

//$current_project_id = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST["project_id"] : $projects[0]["id"];
$current_project_id = 1;

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
if (!empty($_POST["date_range"])) {
    $dates = explode(',', $_POST["date_range"]);
    if (count($dates) > 1) {
        // Es un rango
        $filters["date"] = [$dates[0], $dates[1]];
    } else {
        // Es una fecha única
        $filters["date"] = [$dates[0], $dates[0]];
    }
}
// PROJECT ID
$filters["project_id"] = $current_project_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diana - Timeline App</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"/>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

    <style>
        .litepicker {
            background-color: #1F2937;
            border: 1px solid #374151;
            border-radius: 0.5rem;
            color: #E5E7EB;
        }
        .litepicker .container__months {
            background-color: #1F2937;
        }
        .litepicker .container__days .day-item {
            color: #E5E7EB;
        }
        .litepicker .container__days .day-item:hover {
            background-color: #374151;
        }
        .litepicker .container__days .day-item.is-start-date,
        .litepicker .container__days .day-item.is-end-date {
            background-color: #2563EB;
            color: white;
        }
        .litepicker .container__days .day-item.is-in-range {
            background-color: #3B82F6;
            opacity: 0.7;
        }
        .litepicker .container__months .month-item-header {
            color: #E5E7EB;
        }
        .litepicker .button-previous-month,
        .litepicker .button-next-month {
            color: #E5E7EB;
        }
        .litepicker .container__days .day-item.is-today {
            color: #60A5FA;
        }
    </style>

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
                        <?php foreach ($projects as $project): 
                            $selected = ($project["id"] == $current_project_id) ? 'selected' : ''; ?>
                            <option value="<?= $project["id"] ?>" <?= $selected ?> ><?= $project["title"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-300">Filters</h2>
                
                <form method="POST" class="space-y-4">
                    <!-- Date Range -->
                    <!-- Hidden Project ID -->
                    <input type="hidden" name="project_id" value="<?= $current_project_id ?>">

                    <!-- Date Range -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-400">Date Range</label>
                        <input 
                            type="text" 
                            id="daterange"
                            name="date_range"
                            value="<?= $_POST['date_range'] ?? '' ?>"
                            placeholder="Select date or range"
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-1 px-2 text-gray-200"
                            readonly
                        >
                        <!-- Botones de acceso rápido -->
                        <div class="flex space-x-2 mt-2">
                            <button type="button" 
                                onclick="setToday()"
                                class="px-2 py-1 text-xs bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition-colors">
                                Today
                            </button>
                            <button type="button" 
                                onclick="setLastWeek()"
                                class="px-2 py-1 text-xs bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition-colors">
                                Last week
                            </button>
                            <button type="button" 
                                onclick="setLastMonth()"
                                class="px-2 py-1 text-xs bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition-colors">
                                Last month
                            </button>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-400">Tags</label>
                        <div class="h-48 overflow-y-auto space-y-1 bg-gray-750 rounded-md p-2">
                            <?php
                            $tags = $Diana->tag_list($current_project_id);
                            foreach ($tags as $tag) {
                                $isSelected = in_array($tag['name'], $filters['tags'] ?? []);
                                $bgColor = $isSelected ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600';
                                
                                echo "<label 
                                        class='tag-label flex items-center justify-between p-2 rounded cursor-pointer transition-colors {$bgColor}'
                                        onclick='toggleTag(this)'
                                    >";
                                echo "  <span class='text-sm'>{$tag['name']}</span>";
                                echo "  <span class='text-xs px-2 py-1 rounded-full bg-opacity-25 bg-black'>{$tag['count']}</span>";
                                echo "  <input 
                                        type='checkbox' 
                                        name='tags[]' 
                                        value='{$tag['name']}'
                                        " . ($isSelected ? 'checked' : '') . "
                                        class='hidden'
                                        >";
                                echo "</label>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>
                </form>
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

<script>
    let picker = new Litepicker({
        element: document.getElementById('daterange'),
        singleMode: false,
        numberOfMonths: 2,
        numberOfColumns: 2,
        startDate: '<?= explode(',', $_POST['date_range'] ?? '')[0] ?? '' ?>',
        endDate: '<?= explode(',', $_POST['date_range'] ?? '')[1] ?? '' ?>',
        format: 'YYYY-MM-DD',
        setup: (picker) => {
            picker.on('selected', (date1, date2) => {
                if (date1.dateInstance > date2.dateInstance) {
                    const tmp = date1.dateInstance;
                    date1.dateInstance = date2.dateInstance;
                    date2.dateInstance = tmp;
                }
            });
        }
    });

    // Funciones para los botones de acceso rápido
    function setToday() {
        const today = new Date();
        picker.setDateRange(today, today);
    }

    function setLastWeek() {
        const today = new Date();
        const lastWeek = new Date();
        lastWeek.setDate(today.getDate() - 7);
        picker.setDateRange(lastWeek, today);
    }

    function setLastMonth() {
        const today = new Date();
        const lastMonth = new Date();
        lastMonth.setMonth(today.getMonth() - 1);
        picker.setDateRange(lastMonth, today);
    }

    function toggleTag(label) {
        const checkbox = label.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        
        // Toggle las clases visuales
        if (checkbox.checked) {
            label.classList.remove('bg-gray-700', 'text-gray-300');
            label.classList.add('bg-blue-600', 'text-white');
        } else {
            label.classList.remove('bg-blue-600', 'text-white');
            label.classList.add('bg-gray-700', 'text-gray-300');
        }
    }
</script>