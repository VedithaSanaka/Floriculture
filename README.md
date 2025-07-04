# Floriculture
# Flourishing Florals : Enhancing Floriculture Productivity Through Sustainable Practices
Overview
This project is a web application designed to provide comprehensive information about various flowering plants and a dynamic planting calendar based on geographical regions. Users can search for specific flowers and view details such as soil type, fertility level, irrigation methods, climatic conditions, possible pests, and control measures. A key feature includes multilingual support for both the displayed flower data and the user interface labels.

The application also offers a planting calendar that dynamically updates based on the selected region, showcasing the best times to plant various flowering plants throughout the year.

Features
Flower Information Retrieval: Fetches detailed information about flowering plants from a MySQL database.

Multilingual Support:

Data: Retrieves flower-specific data in English, Telugu, Hindi, and Urdu (based on selected language).

UI Labels: Dynamically translates display labels (e.g., "Soil Type", "Fertility Level") into the selected language.

Dynamic Planting Calendar: Displays a month-by-month planting schedule for flowering plants based on selected regions (Coastal, Drought-Prone, Wet Region, Hill Region).

Secure Database Interaction: Utilizes PHP's mysqli with prepared statements to prevent SQL injection vulnerabilities.

User-Friendly Interface: Simple HTML forms for search and region selection.

Basic Styling: (Mention if you have a Flower.css or similar for basic aesthetics).

Technologies Used
Frontend:

HTML5

CSS3 (Flower.css for styling)

JavaScript (for dynamic calendar and UI translations on the frontend)

Backend:

PHP (for server-side processing and database interaction)

Database:

MySQL / MariaDB (for storing flower details and language-specific data)

