<?php
// Database connection
$servername = "localhost"; // Replace with your server details
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "pharma_db"; // Replace with your database name
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $brand_name = $_POST['brand_name'];
    $lot_no = $_POST['lot_no'];
    $mfg_date = $_POST['mfg_date'];
    $expiry_date = $_POST['expiry_date'];
    $packing = $_POST['packing'];
    $storage_temp = $_POST['storage_temp'];
    $rh = $_POST['rh'];
    $description = $_POST['description'];
    $identification = $_POST['identification'];
    $weight = $_POST['weight'];
    $disintegration_time = $_POST['disintegration_time'];
    $moisture_content = $_POST['moisture_content'];
    $dosage_unit = $_POST['dosage_unit'];
    $bacterial_count = $_POST['bacterial_count'];
    $molds_yeast_count = $_POST['molds_yeast_count'];
    $salmonella = $_POST['salmonella'];
    $escherichia_coli = $_POST['escherichia_coli'];
    $staphylococcus_aureus = $_POST['staphylococcus_aureus'];
    $sodium_ascorbate = $_POST['sodium_ascorbate'];
    $zinc_sulfate = $_POST['zinc_sulfate'];
    $first_test_ = $_POST['first_test'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO products (product_name, brand_name, lot_no, mfg_date, expiry_date, packing, storage_temp, rh, description, identification, weight, disintegration_time, moisture_content, dosage_unit, bacterial_count, molds_yeast_count, salmonella, escherichia_coli, staphylococcus_aureus,sodium_ascorbate, zinc_sulfate,first_test) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");
    $stmt->bind_param("ssssssssssssssssssssss", $product_name, $brand_name, $lot_no, $mfg_date, $expiry_date, $packing, $storage_temp, $rh, $description, $identification, $weight, $disintegration_time, $moisture_content, $dosage_unit, $bacterial_count, $molds_yeast_count, $salmonella, $escherichia_coli, $staphylococcus_aureus,$sodium_ascorbate, $zinc_sulfate,$first_test);

    // Execute the query
    if ($stmt->execute()) {
        echo "New product added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stability</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center">EURASIA RESEARCH PHARMA CORPORATION</h2>

    <!-- Add Product Button -->
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProductModal">
        <i class="bi bi-plus"></i> Add Product
      </button>
    </div>

    <!-- Table -->
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Product Name</th>
          <th>Brand Name</th>
          <th>MFG DATE</th>
          <th>EXPIRY DATE</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
        <!-- Fetch and display data from the database -->
        <?php
        $sql = "SELECT id,  product_name, brand_name, mfg_date, expiry_date FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                      <td>" . $row['product_name'] . "</td>
                      <td>" . $row['brand_name'] . "</td>
                      <td>" . $row['mfg_date'] . "</td>
                      <td>" . $row['expiry_date'] . "</td>
                      <td>
                      <a href='view_product.php?id=" . $row['id'] . "' class='text-info mr-2'>
                      <i class='bi bi-eye'></i>
                      </a>
                      <a href='edit_product.php?id=" . $row['id'] . "' class='text-primary mr-2'>
                          <i class='bi bi-pencil-square'></i>
                        </a>
                        <a href='delete_product.php?id=" . $row['id'] . "' class='text-danger' onclick='return confirm(\"Are you sure?\")'><i class='bi bi-trash'></i></a>
                      </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No Products Available</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <!-- Modal Structure -->
  <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form inside the modal -->
          <form method="POST" action="add_product.php">
            <div class="form-group">
              <label for="productName">Product Name</label>
              <input type="text" class="form-control" id="productName" name="product_name" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
              <label for="brandName">Brand Name</label>
              <input type="text" class="form-control" id="brandName" name="brand_name" placeholder="Enter brand name" required>
            </div>
            <div class="form-group">
              <label for="lotNo">Lot No.</label>
              <input type="number" class="form-control" id="lotNo" name="lot_no" required>
            </div>
            <div class="form-group">
              <label for="mfgDate">MFG Date</label>
              <input type="date" class="form-control" id="mfgDate" name="mfg_date" required>
            </div>
            <div class="form-group">
              <label for="expiryDate">Expiry Date</label>
              <input type="date" class="form-control" id="expiryDate" name="expiry_date" required>
            </div>
            <div class="form-group">
              <label for="packing">Packing</label>
              <input type="text" class="form-control" id="packing" name="packing" placeholder="Enter packing details">
            </div>
            <div class="form-group">
              <label for="storageTemp">Storage Temp</label>
              <input type="text" class="form-control" id="storageTemp" name="storage_temp" placeholder="Enter storage temperature">
            </div>
            <div class="form-group">
              <label for="rh">RH</label>
              <input type="text" class="form-control" id="rh" name="rh" placeholder="Enter RH">
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter product description"></textarea>
            </div>
            <div class="form-group">
              <label for="identification">Identification</label>
              <input type="text" class="form-control" id="identification" name="identification" placeholder="Enter product identification">
            </div>
            <div class="form-group">
              <label for="weight">WEIGHT per CAPSULE with Empty capsule</label>
              <input type="text" class="form-control" id="weight" name="weight" placeholder="WEIGHT per CAPSULE with Empty capsule">
            </div>
            <div class="form-group">
              <label for="disintegrationTime">Disintegration Time</label>
              <input type="text" class="form-control" id="disintegrationTime" name="disintegration_time" placeholder="Enter disintegration time">
            </div>
            <div>
              <p><b>MICROBIAL LIMITS</p></b>
            </div>
            <div class="form-group">
              <label for="moistureContent">Moisture Content</label>
              <input type="text" step="0.01" class="form-control" id="moistureContent" name="moisture_content" placeholder="Enter moisture content">
            </div>
            <div class="form-group">
              <label for="dosageUnit">Dosage Unit</label>
              <input type="text" class="form-control" id="dosageUnit" name="dosage_unit" placeholder="Enter dosage unit">
            </div>
            <div class="form-group">
              <label for="bacterialCount">Bacterial Count</label>
              <input type="number" class="form-control" id="bacterialCount" name="bacterial_count" placeholder="Enter bacterial count">
            </div>
            <div class="form-group">
              <label for="moldsYeastCount">Molds/Yeast Count</label>
              <input type="number" class="form-control" id="moldsYeastCount" name="molds_yeast_count" placeholder="Enter molds/yeast count">
            </div>
            <div class="form-group">
              <label for="salmonella">Salmonella</label>
              <select class="form-control" id="salmonella" name="salmonella">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="form-group">
              <label for="escherichiaColi">Escherichia Coli</label>
              <select class="form-control" id="escherichiaColi" name="escherichia_coli">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="form-group">
              <label for="staphylococcusAureus">Staphylococcus Aureus</label>
              <select class="form-control" id="staphylococcusAureus" name="staphylococcus_aureus">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>

            <div>
              <p><b>ASSAY</p></b>
            </div>

            <div class="form-group">
              <label for="sodiumAscorbate">Sodium Ascorbate</label>
              <input type="text" class="form-control" id="sodiumAscorbate" name="sodium_ascorbate" placeholder="Sodium Ascorbate">
            </div>

            <div class="form-group">
              <label for="zincSulfate">Zinc Sulfate</label>
              <input type="text" class="form-control" id="zincSulfate" name="zinc_sulfate" placeholder="zinc sulfate">
            </div>

            <div class="form-group">
              <label for="firstTest">1st Testing</label>
              <input type="date" class="form-control" id="firstTest" name="first_test" placeholder="1st Testing">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>

