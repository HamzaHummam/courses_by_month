<b>Courses by Month Block Plugin for Moodle</b>
<br>
This Moodle plugin displays courses organized by month, grouped by categories, in a clean and visually appealing table format. It's designed to help students, teachers, and administrators quickly view and plan for upcoming or ongoing courses.

Features
Monthly Course View: Courses are displayed in a calendar-style table with months as columns.
Category Grouping: Courses are organized by their categories for better clarity.
Highlight Active Courses: Courses with upcoming or ongoing start dates are highlighted.
Customizable: Admins can configure settings such as date ranges and color themes.
Installation
Download the Plugin
Clone or download this repository as a .zip file.

bash
Copy code
git clone https://github.com/HamzaHummam/courses-by-month.git
Place the Plugin in Moodle
Extract the folder and move it to your Moodle installation under:

bash
Copy code
moodle/blocks/courses_by_month
Install the Plugin

Log in to Moodle as an administrator.
Navigate to Site Administration > Notifications.
Follow the on-screen instructions to complete the installation.
Add the Block

Go to the Moodle page where you want the block to appear.
Use the "Add a Block" option and select "Courses by Month".
Configuration
Highlight Dates: Customize colors for active or overdue courses in the plugin settings.
Date Range: Define the months displayed (e.g., current academic year).
Visibility: Restrict access to specific roles (e.g., students or teachers).
Screenshots

How It Works
Data Fetching: The plugin queries Moodle’s database to retrieve course information, including categories, start dates, and visibility status.
Rendering: The data is rendered in a table with months as columns and categories as rows.
Highlights: Active and overdue courses are styled with distinct colors.
Development
This plugin was developed using:

Moodle Coding Standards: Ensures compatibility and security.
PHP and SQL: For data processing and querying.
Moodle Templates: For dynamic rendering of the table.
File Structure<br><br>
blocks/courses_by_month/
<br>
├── block_courses_by_month.php     # Main logic for the plugin.
<br>
├── version.php                    # Plugin version details.
<br>
├── lang/
<br>
│   └── en/
<br>
│       └── block_courses_by_month.php  # Language strings.
<br>
├── db/
<br>
│   └── access.php                 # Defines permissions.
<br>
└── styles.css                     # CSS for table styling.
<br><br>
Contributing
We welcome contributions! Please follow these steps:

Fork this repository.
Create a new branch for your feature or bug fix:
Copy code
git checkout -b feature-name
Submit a pull request with a detailed description of the changes.
License
This plugin is licensed under GPLv3.

Support
If you encounter any issues or have feature requests, please open an issue on this repository or contact the maintainer at hamzahummam16@gmail.com.
