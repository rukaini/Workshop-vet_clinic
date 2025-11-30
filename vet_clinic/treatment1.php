<?php
//treatment1.php

include 'connection.php';
include 'vetheader.php';



$insert_success = false;
$insert_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // NOTE: Removed real_escape_string as prepared statements handle escaping securely.
    $treatmentID = $_POST['treatmentID'] ?? '';
    $treatmentDate = $_POST['treatmentDate'] ?? '';
    $treatmentDescription = $_POST['treatmentDescription'] ?? '';
    $treatmentStatus = $_POST['treatmentStatus'] ?? '';
    $diagnosis = $_POST['diagnosis'] ?? '';
    // Ensure treatmentFee is treated as a float
    $treatmentFee = (float)($_POST['treatmentFee'] ?? 0.00); 
    $vetID = $_POST['vetID'] ?? '';
    $appointmentID = $_POST['appointmentID'] ?? '';

    $sql_insert = "INSERT INTO TREATMENT (treatmentID, treatmentDate, treatmentDescription, treatmentStatus, diagnosis, treatmentFee, vetID, appointmentID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql_insert)) {
        // Bind parameters: s-string, d-double/float
        $stmt->bind_param("sssssdds", $treatmentID, $treatmentDate, $treatmentDescription, $treatmentStatus, $diagnosis, $treatmentFee, $vetID, $appointmentID);

        if ($stmt->execute()) {
            $insert_success = true;
        } else {
            $insert_error = "Error executing insertion: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $insert_error = "Error preparing statement: " . $conn->error;
    }
}

?>
        
        <?php 
        // Display status messages
        if ($insert_success) {
            echo '<div class="success-message rounded-md font-semibold">Treatment record added successfully!</div>';
        }
        if ($insert_error) {
            echo '<div class="error-message rounded-md font-semibold">Insertion Failed: ' . htmlspecialchars($insert_error) . '</div>';
        }
        ?>

        <div class="card bg-white p-6 md:p-8 rounded-lg mb-10">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-3" style="color: var(--primary-color);">Add New Treatment</h2>
            
            <form action="" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                
                <?php 
                // Define form fields structure
                $fields = [
                    ['name' => 'treatmentID', 'label' => 'Treatment ID', 'type' => 'date', 'placeholder' => 'T01', 'required' => true, 'span' => 1],
                    ['name' => 'treatmentDate', 'label' => 'Date', 'type' => 'date', 'placeholder' => '', 'required' => true, 'span' => 1],
                    ['name' => 'treatmentFee', 'label' => 'Fee (RM)', 'type' => 'number', 'step' => '0.01', 'placeholder' => '50.00', 'required' => true, 'span' => 1],
                    ['name' => 'treatmentStatus', 'label' => 'Status', 'type' => 'select', 'options' => ['Pending', 'In Progress', 'Completed', 'Cancelled'], 'required' => true, 'span' => 1],
                    ['name' => 'diagnosis', 'label' => 'Diagnosis', 'type' => 'text', 'placeholder' => 'Fever, broken leg, etc.', 'required' => false, 'span' => 2],
                    ['name' => 'vetID', 'label' => 'Vet ID', 'type' => 'text', 'placeholder' => '1', 'required' => true, 'span' => 1],
                    ['name' => 'appointmentID', 'label' => 'Appointment ID', 'type' => 'text', 'placeholder' => 'A001', 'required' => true, 'span' => 1],
                ];

                foreach ($fields as $field) {
                    echo '<div class="lg:col-span-' . $field['span'] . '">';
                    echo '<label for="' . $field['name'] . '" class="block text-sm font-medium text-gray-700">' . $field['label'] . '</label>';
                    
                    if ($field['type'] === 'select') {
                        echo '<select name="' . $field['name'] . '" id="' . $field['name'] . '" ' . ($field['required'] ? 'required' : '') . ' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">';
                        foreach ($field['options'] as $option) {
                            echo '<option value="' . $option . '">' . $option . '</option>';
                        }
                        echo '</select>';
                    } else {
                        $step = $field['step'] ?? '';
                        echo '<input type="' . $field['type'] . '" name="' . $field['name'] . '" id="' . $field['name'] . '" ' . ($field['required'] ? 'required' : '') . ' placeholder="' . $field['placeholder'] . '" step="' . $step . '" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">';
                    }
                    echo '</div>';
                }
                ?>

                <div class="lg:col-span-4">
                    <label for="treatmentDescription" class="block text-sm font-medium text-gray-700">Description / Procedure</label>
                    <textarea name="treatmentDescription" id="treatmentDescription" rows="3" required placeholder="Detailed notes on the procedure..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"></textarea>
                </div>

                <div class="lg:col-span-4 mt-6">
                    <button type="submit" style="background-color: var(--primary-color);" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-lg font-semibold text-white hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 ease-in-out">
                        Add Treatment Record
                    </button>
                </div>
            </form>
        </div>


        <div class="card bg-white p-6 md:p-8 rounded-lg mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-3" style="color: var(--primary-color);">Existing Treatments</h2>
            
            <?php
            // Prepare the SELECT query
            $sql_select = "SELECT treatmentID, treatmentDate, treatmentDescription, treatmentStatus, diagnosis, treatmentFee, vetID FROM TREATMENT ORDER BY treatmentDate DESC";
            $result = $conn->query($sql_select);

            if ($result && $result->num_rows > 0) {
                echo '<div class="overflow-x-auto">';
                echo '<table class="min-w-full divide-y divide-gray-200">';
                echo '<thead class="bg-blue-50">'; // Light blue header background
                echo '<tr>';
                echo '<th class="px-3 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>';
                echo '<th class="px-3 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>';
                echo '<th class="px-3 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>';
                echo '<th class="px-3 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description / Diagnosis</th>';
                echo '<th class="px-3 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fee</th>';
                echo '<th class="px-3 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Vet</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody class="bg-white divide-y divide-gray-100">';

                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Determine the color for the status pill based on the status value
                    $status_class = match ($row['treatmentStatus']) {
                        'Completed' => 'bg-green-50 text-green-700 ring-1 ring-green-600/20',
                        'In Progress' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20',
                        'Pending' => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20',
                        default => 'bg-gray-50 text-gray-700 ring-1 ring-gray-600/20',
                    };

                    echo '<tr>';
                    // Treatment ID
                    echo '<td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">' . htmlspecialchars($row['treatmentID']) . '</td>';
                    
                    // Date
                    echo '<td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600">' . htmlspecialchars($row['treatmentDate']) . '</td>';

                    // Status (Pill)
                    echo '<td class="px-3 md:px-6 py-4 whitespace-nowrap">';
                    echo '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ' . $status_class . '">';
                    echo htmlspecialchars($row['treatmentStatus']);
                    echo '</span>';
                    echo '</td>';

                    // Diagnosis / Description
                    $display_text = !empty($row['diagnosis']) ? htmlspecialchars($row['diagnosis']) : htmlspecialchars($row['treatmentDescription']);
                    echo '<td class="px-3 md:px-6 py-4 text-sm text-gray-600 max-w-xs overflow-hidden text-ellipsis">' . $display_text . '</td>';

                    // Fee
                    echo '<td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">RM ' . number_format($row['treatmentFee'], 2) . '</td>';
                    
                    // Vet ID
                    echo '<td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600">' . htmlspecialchars($row['vetID']) . '</td>';

                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>'; // End overflow-x-auto
            } else {
                echo '<p class="text-gray-500 py-4">No treatment records found in the database. Add one using the form above!</p>';
            }

            // Close connection
            $conn->close();
            ?>
        </div>

    </div>


<?php
include 'footer.php';
?>

</body>
</html>

