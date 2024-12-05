<?php
defined('MOODLE_INTERNAL') || die();

class block_courses_by_month extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_courses_by_month');
    }

    public function get_content() {
        global $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        // Add inline CSS for styling
        $this->content = new stdClass();
        $this->content->text = '';

        $this->content->text .= '<style>
            .course-category {
                margin-bottom: 20px;
            }
            .scrollable-table {
                overflow-x: auto;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td {
                padding: 8px 12px;
                border: 1px solid #ddd;
                text-align: center;
            }
            .clickable-course {
                color: #0066cc;
                text-decoration: none;
            }
            .clickable-course:hover {
                text-decoration: underline;
            }
            .past-course {
                background-color: #f8d7da;
                color: #721c24;
            }
            .current-course {
                background-color: #d4edda;
                color: #155724;
            }
            .future-course {
                background-color: #fff3cd;
                color: #856404;
            }
        </style>';

        // Fetch categories from the database
        $categories = $DB->get_records_sql("
            SELECT c.id, c.name 
            FROM {course_categories} c 
            WHERE c.visible = 1
        ");

        // Fetch courses by category, including start and end dates
        $courses = $DB->get_records_sql("
            SELECT c.id, c.fullname, c.shortname, c.startdate, c.enddate, c.category
            FROM {course} c
            WHERE c.visible = 1
        ");

        // Loop through each category and display it
        foreach ($categories as $category) {
            // Filter courses by the current category
            $category_courses = array_filter($courses, function($course) use ($category) {
                return $course->category == $category->id;
            });

            if (!empty($category_courses)) {
                // Start the section for each category
                $this->content->text .= html_writer::start_tag('section', ['class' => 'course-category']);
                // $this->content->text .= html_writer::tag('h3', $category->name);

                // Create scrollable table for this category
                $this->content->text .= html_writer::start_tag('div', ['class' => 'scrollable-table']);

                // Create the table structure
                $table = html_writer::start_tag('table', ['class' => 'table table-bordered table-striped']);
                $table .= html_writer::start_tag('thead');
                $table .= html_writer::start_tag('tr');

                // First column will be course name, then the months
                $table .= html_writer::tag('th', $category->name);
                $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                foreach ($months as $month) {
                    $table .= html_writer::tag('th', $month);
                }
                $table .= html_writer::end_tag('tr');
                $table .= html_writer::end_tag('thead');

                $table .= html_writer::start_tag('tbody');

                // Loop through the courses of this category
                foreach ($category_courses as $course) {
                    $course_row = html_writer::start_tag('tr');
                    
                    // Make course name clickable
                    $course_url = new moodle_url('/course/view.php', array('id' => $course->id));
                    $course_link = html_writer::link($course_url, $course->fullname, ['class' => 'clickable-course']);
                    $course_row .= html_writer::tag('td', $course_link);

                    // Loop through the months and check if the course starts in this month
                    for ($month = 1; $month <= 12; $month++) {
                        // Get the start and end month
                        $start_month = date('m', $course->startdate);
                        $end_month = date('m', $course->enddate);
                        $current_date = time(); // Get the current timestamp for comparison
                        $course_start_date = $course->startdate;
                        $course_end_date = $course->enddate;

                        // Compare if the course starts or ends in this month
                        $course_cell_class = '';
                        $course_start_date_formatted = date('d-M', $course->startdate); // Format as 'day-month'

                        if (($start_month == $month)) {
                            // Determine if the course is past, current, or future
                            if ($course_end_date < $current_date) {
                                $course_cell_class = 'past-course';
                            } elseif ($course_start_date > $current_date) {
                                $course_cell_class = 'future-course';
                            } else {
                                $course_cell_class = 'current-course';
                            }

                            // Display the start date in the respective month cell with class for past, current, or future
                            $course_row .= html_writer::tag('td', $course_start_date_formatted, ['class' => $course_cell_class]);
                        } else {
                            $course_row .= html_writer::tag('td', '');
                        }
                    }

                    $course_row .= html_writer::end_tag('tr');
                    $table .= $course_row;
                }

                $table .= html_writer::end_tag('tbody');
                $table .= html_writer::end_tag('table');

                $this->content->text .= $table;
                $this->content->text .= html_writer::end_tag('div');
                $this->content->text .= html_writer::end_tag('section');
            }
        }

        return $this->content;
    }

    public function applicable_formats() {
        return array(
            'all' => true, // Allow the block to be added to all pages
        );
    }
}
