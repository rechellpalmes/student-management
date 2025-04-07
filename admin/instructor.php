<h1 class="page-header">Dashboard</h1>

<?php  
// Ensure session is started
if (!isset($_SESSION)) {
    session_start();
}

$userid = $_SESSION['ACCOUNT_ID']; 

// Adjusted SQL Query with proper joins
$sql = "SELECT * 
        FROM useraccounts u
        JOIN tblinstructorsubject i ON u.ACCOUNT_ID = i.ACCOUNT_ID
        JOIN tblsection sec ON sec.SECTIONID = i.SECTIONID  -- Assuming SECTIONID is in tblsection
        JOIN `subject` s ON i.SUBJ_ID = s.SUBJ_ID
        JOIN `course` c ON s.COURSE_ID = c.COURSE_ID
        WHERE u.ACCOUNT_ID = '{$userid}'";
$mydb->setQuery($sql);
$res = $mydb->loadSingleResult();
?>  

<div class="table-responsive">      
    <table id="dash-table" class="table table-bordered table-hover" style="font-size:12px" cellspacing="0">
        <thead>
            <tr> 
                <th>Subject</th> 
                <th>Unit</th>
                <th>Pre-Requisite</th>
                <th>Course</th>
                <th>Year Level</th> 
                <th>Section</th> 
                <th>Semester</th> 
            </tr> 
        </thead> 
        <tbody>
            <?php  
            // Fetch subjects with the correct join conditions
            $sql = "SELECT *, s.YEARLEVEL AS 'LEVEL'
                    FROM useraccounts u
                    JOIN tblinstructorsubject i ON u.ACCOUNT_ID = i.ACCOUNT_ID
                    JOIN tblsection sec ON sec.SECTIONID = i.SECTIONID  -- Corrected the join here
                    JOIN `subject` s ON i.SUBJ_ID = s.SUBJ_ID
                    JOIN `course` c ON s.COURSE_ID = c.COURSE_ID
                    WHERE u.ACCOUNT_ID = '{$userid}'
                    GROUP BY s.SUBJ_ID";
            $mydb->setQuery($sql);
            $res = $mydb->loadResultList();

            if ($res) {
                foreach ($res as $row) {
                    echo '<tr>';  
                    echo '<td><a href="index.php?view=grades&id=' . htmlspecialchars($row->SUBJ_ID) . '"> ' . htmlspecialchars($row->SUBJ_CODE) . ' | ' . htmlspecialchars($row->SUBJ_DESCRIPTION) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row->UNIT) . '</td>';
                    echo '<td>' . htmlspecialchars($row->PRE_REQUISITE) . '</td>';
                    echo '<td>' . htmlspecialchars($row->COURSE_NAME) . '</td>'; 
                    echo '<td>' . htmlspecialchars($row->LEVEL) . '</td>';
                    echo '<td>' . htmlspecialchars($row->SECTION) . '</td>';
                    echo '<td>' . htmlspecialchars($row->SEMESTER) . '</td>';  
                    echo '</tr>'; 
                }
            } else {
                echo '<tr><td colspan="7" class="text-center">No data available</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#dash-table').DataTable({
            "paging": true,          // Enable pagination
            "searching": true,       // Enable searching
            "ordering": true,        // Enable sorting
            "info": true,            // Display table info (e.g., showing 1 to 10 of 50 entries)
            "lengthChange": true,    // Allow changing the number of records per page
            "columnDefs": [
                { "targets": 0, "orderable": false }  // Disable sorting for the first column (Subject)
            ]
        });

        // Initialize Select2 if needed
        // Example: $('#your-select-element').select2();
    });
</script>
