// Add this code to your WordPress theme's functions.php file or in a custom plugin
function display_external_data_shortcode() {
    // Replace the below values with your actual external database credentials
    $servername = "localhost";
    $username = "singxkmc_clinics_wb_admin";
    $password = "Admin@123!";
    $dbname = "singxkmc_clinics_wb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query the external_table and retrieve data
    $sql = "SELECT * FROM countries";
    $result = $conn->query($sql);

    // Code to format and display the retrieved data
    $output = '';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $column1_value = $row["column1"];
            $column2_value = $row["column2"];

            // Format the retrieved data as needed
            $output .= "Column1: " . $column1_value . "<br>";
            $output .= "Column2: " . $column2_value . "<br>";
        }
    } else {
        $output = "No results";
    }

    // Close the database connection
    $conn->close();

    return $output;
}
add_shortcode('external_data', 'display_external_data_shortcode');