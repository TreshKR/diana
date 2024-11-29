<?php
// Diane, 7:30 am, February twenty-fourth. Entering town of Twin Peaks.
require("utils/Diana.php");
$Diana = new Diana();
// Get all the projects for this user
$projects = $Diana->project_list();
// PROJECT SELECTION - either via POST or the projects list
$current_project_id = $_POST["project_id"] ?? $projects[0]["id"];

// FILTERS - Preparing the array that will hold all selected filters
$filters = [];
// PROJECT ID
$filters["project_id"] = $current_project_id;

// If its a POST request, there will most likely be more filters to be applied
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DATE
    if ( !empty($_POST["date_start"]) ) $filters["date"] = [
        date("Y-m-d", strtotime($_POST["date_start"])), 
        date("Y-m-d", strtotime($_POST["date_end"]))
    ];
    // TAGS
    if ( !empty($_POST["tags"]) ) {
        // Just making sure there are no empty array elements
        $filters["tags"] = array_filter($_POST["tags"]);
    }
    // COLOR
    if ( !empty($_POST["color"]) ) {
        $filters["color"] = $_POST["color"];
    }
    // ICON
    if ( !empty($_POST["icon"]) ) {
        $filters["icon"] = $_POST["icon"];
    }
}
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
    <!-- custom css -->
    <link rel="stylesheet" href="/assets/css/styles.css"/>

</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <div class="flex h-screen">
        <!-- Left Column - Actions & Filters -->
        <aside class="w-64 bg-gray-800 p-4 border-r border-gray-700">
            <!-- Project Selection -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-medium text-gray-400">Project</label>
                    <button type="button" class="p-1 text-gray-400 hover:text-gray-200 hover:bg-gray-700 rounded-full transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
                <div class="relative">
                    <select id="project_selection" class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($projects as $project): 
                            $selected = ($project["id"] == $current_project_id) ? 'selected' : ''; ?>
                            <option value="<?= $project["id"] ?>" <?= $selected ?> ><?= $project["title"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <script>
            // Event handler for the project selection dropdown
            document.getElementById('project_selection').addEventListener('change', function() {
                // When the selection changes we change the hidden input in the form
                document.getElementById('post_project_id').value = this.value;
                // and submit that form
                document.getElementById('post_project_form').submit();
            });
            </script>
            <!-- Filters Section -->
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-300">Filters</h2>
                
                <form id="post_project_form" method="POST" class="space-y-4">
                    <!-- Hidden Project ID -->
                    <input id="post_project_id" type="hidden" name="project_id" value="<?= $current_project_id ?>">

                    <!-- DATE RANGE SELECTOR -->
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
                        <input id="date_start" type="hidden" name="date_start" value="">
                        <input id="date_end" type="hidden" name="date_end" value="">
                        <!-- QUICK DATE ACCESS -->
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

                    <!-- FILTER TAGs -->
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
                <?php $events = $Diana->event_list($filters);
                foreach ($events as $event) {
                    echo "<div class='flex items-center space-x-4 p-3 bg-gray-800 rounded-lg hover:bg-gray-750 cursor-pointer transition-colors duration-150'>";
                    echo "  <div class='text-sm text-gray-400'>{$event['display_timestamp']}</div>";
                    echo "  <div class='flex-grow flex items-center space-x-2'>";
                    echo "    <div class='w-2 h-2 rounded-full {$event['color']}'></div>";
                    echo "    <div class='text-gray-200'>{$event['title']}, {$event['color']}, {$event['icon']}</div>";
                    echo "  </div>";
                    if ( !empty($event['tags']) ) {
                        echo "  <div class='flex gap-2'>";
                        // individual tag pills
                        $tagArray = array_map('trim', explode(',', $event['tags']));
                        foreach ($tagArray as $tag) {
                            if (!empty($tag)) {
                                echo "<button type='button' 
                                        class='px-2 py-1 text-xs rounded-full bg-gray-700 hover:bg-gray-600 text-gray-300 transition-colors'>";
                                echo $tag;
                                echo "</button>";
                            }
                        }
                        echo "  </div>";
                    }
                    echo "</div>";
                } ?>
            </div>
        </main>

        <!-- Right Column - Event Details/Creation -->
        <aside class="w-96 bg-gray-800 p-6">
            <!-- Empty State Message - Lo dejamos pero lo ocultaremos -->
            <div id="emptyState" class="text-center text-gray-500 h-full flex flex-col items-center justify-center transition-opacity duration-300">
                <div class="mb-1">
                    <p class="inline">Select an event to view details or </p>
                    <button onclick="newEventForm()"
                        class="text-gray-400 font-semibold hover:text-blue-300 transition-colors duration-150 inline">
                        create a new one
                    </button>
                </div>
                
                <button
                    onclick="newEventForm()"
                    class="mt-8 p-3 rounded-full bg-gray-900 hover:bg-transparent transition-all duration-200 group"
                    title="Create new event">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-14 h-14 text-gray-400/70 group-hover:text-gray-300 transition-colors duration-200" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor" 
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>

            <!-- New Event Form - Inicialmente oculto -->
            <form id="newEventForm" 
                action="index.php" 
                method="POST" 
                class="hidden opacity-0 transition-all duration-300 h-full">
                <!-- Header con título y botón cerrar -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-300">New Event</h2>
                    <button type="button" 
                            onclick="closeEventForm()" 
                            class="text-gray-400 hover:text-gray-300 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-6 w-6" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor">
                            <path stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Project ID hidden input -->
                <input type="hidden" name="project_id" value="<?= $current_project_id ?>">

                <!-- Contenedor para el formulario con scroll -->
                <div class="h-[calc(100%-4rem)] overflow-y-auto px-2 py-2">
                    <div class="space-y-6  pr-2">
                        <!-- Title Field -->
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-medium text-gray-400">
                                What happened?
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title"
                                placeholder="..."
                                class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                                required>
                        </div>

                        <!-- Timestamp Fields - Ahora separados en fecha y hora -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">
                                When did this happen?
                            </label>
                            <div class="flex gap-3">
                                <!-- Date Picker -->
                                <div class="flex-grow relative">
                                    <input 
                                        type="text" 
                                        id="display_date" 
                                        name="display_date"
                                        class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 pl-3 pr-10 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        readonly>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5 text-gray-400" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor">
                                            <path stroke-linecap="round" 
                                                stroke-linejoin="round" 
                                                stroke-width="2" 
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Time Picker -->
                                <input 
                                    type="time" 
                                    id="display_time" 
                                    name="display_time"
                                    class="bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                
                                <!-- Hidden input para el timestamp completo -->
                                <input type="hidden" id="display_timestamp" name="display_timestamp">
                                
                            </div>
                        </div>

                        <!-- Text Input -->
                        <div class="space-y-2">
                            <label for="input_text" class="block text-sm font-medium text-gray-400">
                                Additional notes
                            </label>
                            <textarea 
                                id="input_text" 
                                name="input_text" 
                                rows="4"
                                placeholder="Add any additional details about this event..."
                                class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                            ></textarea>
                        </div>

                        <!-- Tag Selection and Creation -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">
                                Add tags
                            </label>
                            <div class="p-2 bg-gray-700 rounded-md space-y-3">
                                <!-- Tags seleccionados -->
                                <div id="selectedTags" class="flex flex-wrap gap-2">
                                    <!-- Los tags seleccionados se insertarán aquí dinámicamente -->
                                </div>

                                <!-- Input para tags -->
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="tagInput"
                                        placeholder="Type to add tags..."
                                        class="w-full bg-gray-800 border border-gray-600 rounded-md py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                                    >
                                    <!-- Dropdown de sugerencias -->
                                    <div id="tagSuggestions" 
                                        class="absolute z-10 w-full mt-1 bg-gray-800 border border-gray-700 rounded-md shadow-lg hidden">
                                    </div>
                                </div>

                                <!-- Tags existentes -->
                                <div class="pt-2 border-t border-gray-600">
                                    <p class="text-xs text-gray-400 mb-2">Existing tags:</p>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ($Diana->tag_list($current_project_id) as $tag): ?>
                                            <button type="button"
                                                    onclick="addTag('<?= $tag['name'] ?>')"
                                                    class="px-2 py-1 text-sm rounded-full bg-gray-800 hover:bg-gray-600 text-gray-300 transition-colors duration-150">
                                                <?= $tag['name'] ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden inputs para enviar los datos -->
                            <input type="hidden" id="tagList" name="tags" value="">
                            <input type="hidden" id="newTags" name="new_tags" value="">
                        </div>

                                                <!-- Icon Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">
                                Add an icon (optional)
                            </label>
                            <div class="grid grid-cols-8 gap-2 p-2 bg-gray-700 rounded-md max-h-32 overflow-y-auto">
                                <!-- Opción "sin ícono" -->
                                <button type="button" 
                                        onclick="selectIcon(null)" 
                                        class="flex items-center justify-center h-8 rounded hover:bg-gray-600 transition-colors duration-150 group"
                                        title="No icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5 text-gray-400 group-hover:text-gray-300" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor">
                                        <path stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="1.5" 
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <?php
                                // Definimos un array asociativo de íconos comunes con sus paths SVG
                                $icons = [
                                    'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />',
                                    'bell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />',
                                    'star' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />',
                                    'heart' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />',
                                    'bookmark' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />',
                                    'flag' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />',
                                    'bolt' => '<path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />',
                                    'chat' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />'
                                ];
                                
                                foreach ($icons as $name => $path): ?>
                                    <button type="button"
                                            onclick="selectIcon('<?= $name ?>')"
                                            class="flex items-center justify-center h-8 rounded hover:bg-gray-600 transition-colors duration-150 group icon-option"
                                            title="<?= ucfirst($name) ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5 text-gray-400 group-hover:text-gray-300" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor"
                                            stroke-width="1.5">
                                            <?= $path ?>
                                        </svg>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" id="selected_icon" name="icon" value="">
                        </div>

                        <!-- Color Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">
                                Choose a color (optional)
                            </label>
                            <div class="flex gap-2 p-2 bg-gray-700 rounded-md overflow-x-auto">
                                <!-- Opción "sin color" -->
                                <button type="button"
                                        onclick="selectColor(null)"
                                        class="w-8 h-8 rounded-full border-2 border-gray-500 flex items-center justify-center hover:border-gray-400 transition-colors duration-150"
                                        title="No color">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5 text-gray-400" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor">
                                        <path stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <?php
                                // Colores predefinidos que mantengan la estética
                                $colors = [
                                    'bg-blue-500' => 'Blue',
                                    'bg-green-500' => 'Green',
                                    'bg-yellow-500' => 'Yellow',
                                    'bg-red-500' => 'Red',
                                    'bg-purple-500' => 'Purple',
                                    'bg-pink-500' => 'Pink',
                                    'bg-indigo-500' => 'Indigo',
                                    'bg-teal-500' => 'Teal'
                                ];
                                
                                foreach ($colors as $colorClass => $colorName): ?>
                                    <button type="button"
                                            onclick="selectColor('<?= $colorClass ?>')"
                                            class="w-8 h-8 <?= $colorClass ?> rounded-full hover:ring-2 ring-offset-2 ring-offset-gray-700 ring-white transition-all duration-150 color-option"
                                            title="<?= $colorName ?>">
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" id="selected_color" name="color" value="">
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8">
                            <button type="submit"
                                    class="w-full bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-700 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                Create Event
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </aside>
    </div>
</body>
</html>

<script>

    function newEventForm() {
        const emptyState = document.getElementById('emptyState');
        const form = document.getElementById('newEventForm');
        
        emptyState.classList.add('opacity-0');
        
        setTimeout(() => {
            emptyState.classList.add('hidden');
            form.classList.remove('hidden');
            setTimeout(() => {
                form.classList.remove('opacity-0');
                // Inicializamos los campos de fecha y hora
                initializeDateTime();
                // Focuseamos el título primero
                document.getElementById('title').focus();
            }, 50);
        }, 300);
    }

    function initializeDateTime() {
        const now = new Date();
        
        // Inicializamos el date picker
        const picker = new Litepicker({
            element: document.getElementById('display_date'),
            format: 'YYYY-MM-DD',
            numberOfMonths: 1,
            numberOfColumns: 1,
            singleMode: true,
            autoApply: true,
            showWeekNumbers: false,
            plugins: ['mobilefriendly'],
            setup: (picker) => {
                picker.on('selected', updateTimestamp);
            }
        });
        
        // Inicializamos los valores
        const timeInput = document.getElementById('display_time');
        timeInput.value = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
        document.getElementById('display_date').value = now.toISOString().split('T')[0];
        
        // Actualizamos el timestamp completo
        updateTimestamp();
        
        // Agregamos listener para cambios en la hora
        timeInput.addEventListener('change', updateTimestamp);
    }

    function updateTimestamp() {
        const date = document.getElementById('display_date').value;
        const time = document.getElementById('display_time').value;
        const timestamp = `${date} ${time}:00`;
        document.getElementById('display_timestamp').value = timestamp;
    }

    function closeEventForm() {
        const emptyState = document.getElementById('emptyState');
        const form = document.getElementById('newEventForm');
        
        // Fade out del form
        form.classList.add('opacity-0');
        
        // Después de la transición, ocultamos form y mostramos empty state
        setTimeout(() => {
            form.classList.add('hidden');
            emptyState.classList.remove('hidden');
            // Pequeño timeout para asegurar que la transición funcione
            setTimeout(() => {
                emptyState.classList.remove('opacity-0');
            }, 50);
        }, 300);
    }

    function selectIcon(iconName) {
        // Removemos la selección anterior
        document.querySelectorAll('.icon-option').forEach(btn => {
            btn.classList.remove('bg-gray-600');
        });
        
        // Actualizamos la selección
        if (iconName) {
            const selectedBtn = document.querySelector(`[title="${iconName}"]`);
            if (selectedBtn) selectedBtn.classList.add('bg-gray-600');
        }
        
        // Actualizamos el input hidden
        document.getElementById('selected_icon').value = iconName || '';
    }

    function selectColor(colorClass) {
        // Removemos la selección anterior
        document.querySelectorAll('.color-option').forEach(btn => {
            btn.classList.remove('ring-2');
        });
        
        // Actualizamos la selección
        if (colorClass) {
            const selectedBtn = document.querySelector(`.${colorClass.replace(/\s+/g, '.')}`);
            if (selectedBtn) selectedBtn.classList.add('ring-2');
        }
        
        // Actualizamos el input hidden
        document.getElementById('selected_color').value = colorClass || '';
    }

    // picker de fechas para filtro
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
                document.getElementById("date_start").value = date1.dateInstance.toISOString();
                document.getElementById("date_end").value = date2.dateInstance.toISOString();
            });
        }
    });

    // Sistema de manejo de tags
    let selectedTags = new Set();
    let newTags = new Set();

    function addTag(tagName) {
        // Normalizamos el tag (trim, lowercase)
        tagName = tagName.trim().toLowerCase();
        if (!tagName) return;

        // Evitamos duplicados
        if (selectedTags.has(tagName)) return;

        // Agregamos el tag
        selectedTags.add(tagName);

        // Si es un tag nuevo, lo agregamos a newTags
        if (!isExistingTag(tagName)) {
            newTags.add(tagName);
        }

        // Actualizamos la UI
        updateTagsUI();
        // Actualizamos los inputs hidden
        updateHiddenInputs();
    }

    function removeTag(tagName) {
        selectedTags.delete(tagName);
        newTags.delete(tagName);
        updateTagsUI();
        updateHiddenInputs();
    }

    function isExistingTag(tagName) {
        // Convertimos los tags existentes a un array de nombres en lowercase
        const existingTags = Array.from(document.querySelectorAll('#tagSuggestions button'))
            .map(btn => btn.textContent.toLowerCase());
        return existingTags.includes(tagName.toLowerCase());
    }

    function updateTagsUI() {
        const container = document.getElementById('selectedTags');
        container.innerHTML = '';

        selectedTags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'inline-flex items-center gap-1 px-2 py-1 rounded-full bg-blue-500/20 text-blue-300 text-sm';
            tagElement.innerHTML = `
                ${tag}
                <button type="button" 
                        onclick="removeTag('${tag}')"
                        class="hover:text-blue-200 transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="h-4 w-4" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="currentColor">
                        <path stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>`;
            container.appendChild(tagElement);
        });
    }

    function updateHiddenInputs() {
        document.getElementById('tagList').value = Array.from(selectedTags).join(',');
        document.getElementById('newTags').value = Array.from(newTags).join(',');
    }

    // Manejo del input de tags
    document.getElementById('tagInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const tagName = this.value.replace(',', '');
            addTag(tagName);
            this.value = '';
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