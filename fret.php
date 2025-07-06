<?php
// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "flowers");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get flower name and selected language
$flower = $_POST['s'] ?? ''; // Using null coalescing operator for safety
$lang = $_POST['lang'] ?? 'en'; // Default to English if not set

// --- TRANSLATION DATA ---
// Define your translations for the labels here
$translations = [
    'en' => [
        'flower_name_label' => 'Flower Name',
        'soil_type_label' => 'Soil Type',
        'fertility_level_label' => 'Fertility Level',
        'irrigation_methods_label' => 'Irrigation Methods',
        'climatic_conditions_label' => 'Climatic Conditions',
        'possible_pests_label' => 'Possible Pests',
        'control_measures_label' => 'Control Measures',
        'reference_label' => 'Reference',
        'no_info_found' => 'No information found for',
    ],
    'te' => [ // Telugu translations
        'flower_name_label' => 'పువ్వు పేరు',
        'soil_type_label' => 'నేల రకం',
        'fertility_level_label' => 'నేల సారవంతం',
        'irrigation_methods_label' => 'నీటిపారుదల పద్ధతులు',
        'climatic_conditions_label' => 'వాతావరణ పరిస్థితులు',
        'possible_pests_label' => 'సంభావ్య తెగుళ్ళు',
        'control_measures_label' => 'నియంత్రణ చర్యలు',
        'reference_label' => 'సూచన',
        'no_info_found' => 'కు ఎటువంటి సమాచారం దొరకలేదు',
    ],
    'hi' => [ // Hindi translations
        'flower_name_label' => 'फूल का नाम',
        'soil_type_label' => 'मिट्टी का प्रकार',
        'fertility_level_label' => 'उर्वरता स्तर',
        'irrigation_methods_label' => 'सिंचाई के तरीके',
        'climatic_conditions_label' => 'जलवायु परिस्थितियाँ',
        'possible_pests_label' => 'संभावित कीट',
        'control_measures_label' => 'नियंत्रण उपाय',
        'reference_label' => 'संदर्भ',
        'no_info_found' => 'के लिए कोई जानकारी नहीं मिली',
    ],
    'ur' => [ // Urdu translations
        'flower_name_label' => 'پھول کا نام',
        'soil_type_label' => 'مٹی کی قسم',
        'fertility_level_label' => 'زرخیزی کی سطح',
        'irrigation_methods_label' => 'آبپاشی کے طریقے',
        'climatic_conditions_label' => 'آب و ہوا کے حالات',
        'possible_pests_label' => 'ممکنہ کیڑوں',
        'control_measures_label' => 'کنٹرول کے اقدامات',
        'reference_label' => 'حوالہ',
        'no_info_found' => 'کے لیے کوئی معلومات نہیں ملی',
    ],
];

// Get the current language's translations, default to English if the language array doesn't exist
$current_translations = $translations[$lang] ?? $translations['en'];

// Decide the table based on language
switch ($lang) {
    case 'te': $table = 'telugu_fd'; break;
    case 'hi': $table = 'hindi_fd'; break;
    case 'ur': $table = 'urdu_fd'; break;
    default: $table = 'flowers_data'; // Default to 'flowers_data' for 'en' and any other unknown lang
}

// Prepare the query
// Using backticks around table name in case it's a reserved word or contains special characters (good practice)
$stmt = $conn->prepare("SELECT * FROM `$table` WHERE flower_name = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("s", $flower);

if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

$result = $stmt->get_result();

// Check and display results
if ($result->num_rows > 0) {
    echo "<style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; color: #333; line-height: 1.6; }
        .flower-card { background: #fff; padding: 25px; margin: 20px auto; border-radius: 10px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 800px; }
        .flower-card h2 { color: #0056b3; margin-top: 0; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .flower-card img { max-width: 100%; height: auto; border-radius: 8px; display: block; margin: 15px auto 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .label { font-weight: bold; color: #555; display: inline-block; min-width: 150px; }
        p { margin-bottom: 10px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>";

    while ($row = $result->fetch_assoc()) {
        echo "<div class='flower-card'>";
        // Use the translated label for the flower name
        echo "<h2>" . htmlspecialchars($current_translations['flower_name_label']) . ": " . htmlspecialchars($row['flower_name']) . "</h2>";

        // Use flower_name as identifier for image
        // Assuming image.php handles image retrieval based on flower name and table
        echo "<img src='image.php?name=" . urlencode($row['flower_name']) . "&table=" . urlencode($table) . "' alt='Image of " . htmlspecialchars($row['flower_name']) . "'>";

        // Use translated labels for other fields
        echo "<p><span class='label'>" . htmlspecialchars($current_translations['soil_type_label']) . ":</span> " . htmlspecialchars($row['soil_type']) . "</p>";
        echo "<p><span class='label'>" . htmlspecialchars($current_translations['fertility_level_label']) . ":</span> " . htmlspecialchars($row['fertility_level']) . "</p>";
        echo "<p><span class='label'>" . htmlspecialchars($current_translations['irrigation_methods_label']) . ":</span> " . htmlspecialchars($row['irrigation_methods']) . "</p>";
        echo "<p><span class='label'>" . htmlspecialchars($current_translations['climatic_conditions_label']) . ":</span> " . htmlspecialchars($row['climatic_conditions']) . "</p>";
        echo "<p><span class='label'>" . htmlspecialchars($current_translations['possible_pests_label']) . ":</span> " . htmlspecialchars($row['possible_pests']) . "</p>";
        echo "<p><span class='label'>" . htmlspecialchars($current_translations['control_measures_label']) . ":</span> " . htmlspecialchars($row['control_measures']) . "</p>";

        
        if (!empty($row['Soil_fertility'])) {
            echo "<p><span class='label'>" . htmlspecialchars($current_translations['reference_label']) . ":</span> <a href='" . htmlspecialchars($row['Soil_fertility']) . "' target='_blank'>" . htmlspecialchars(parse_url($row['Soil_fertility'], PHP_URL_HOST)) . "</a></p>";
        }

        echo "</div>";
    }
} else {
    // Use translated "No information found" message
    echo "<style>body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; color: #333; line-height: 1.6; }</style>";
    echo "<p>" . htmlspecialchars($current_translations['no_info_found']) . " <strong>" . htmlspecialchars($flower) . "</strong>.</p>";
}

$stmt->close();
$conn->close();
?>