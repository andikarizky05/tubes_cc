<?php
session_start();
include("connection.php");
include("conn.php");

// Function to connect to the database (adjust according to your database settings)
function connectToDatabase()
{
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'tubespw';

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}

// Check if the user is logged in and has the 'user' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Check if 'mobil_id' is set
if (!isset($_POST['mobil_id'])) {
    // Redirect if not set
    header("Location: index2.php");
    exit();
}

// Get car data based on 'mobil_id'
$mobil_id = $_POST['mobil_id'];
$connection = connectToDatabase();
$query_mobil = "SELECT * FROM mobil WHERE id = '$mobil_id'";
$result_mobil = mysqli_query($connection, $query_mobil);

// Check if the query was successful
if (!$result_mobil) {
    die("Query error: " . mysqli_error($connection));
}

// Check if there are results
if (mysqli_num_rows($result_mobil) > 0) {
    // Get car data
    $mobil = mysqli_fetch_assoc($result_mobil);

    // Close the connection after obtaining car data
    mysqli_close($connection);
} else {
    // Redirect if the car is not found
    header("Location: index2.php");
    exit();
}

// Process the purchase form only if the method is POST and 'beli' is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['beli'])) {
    // Get purchase data from the form
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $no_telepon = isset($_POST['no_telepon']) ? $_POST['no_telepon'] : '';

    // Save purchase data to the 'pembelian' table in the database
    $connection = connectToDatabase();

    // Get the current date
    $tanggal_pembelian = date("Y-m-d");

    $sql = "INSERT INTO pembelian (user_id, mobil_id, alamat, no_telepon, tanggal_pembelian) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);

    // Get user_id and username from the session
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown';


    if ($user_id !== null) {
        $stmt->bind_param("iisss", $user_id, $mobil_id, $alamat, $no_telepon, $tanggal_pembelian);

        if ($stmt->execute()) {
            // Data successfully saved
            echo "Pembelian mobil berhasil!";
        } else {
            // There was an error while saving data
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $connection->close();
    } else {
        echo "Error: User ID is not valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speedster Motors</title>

    <!--  - favicon -->
    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

    <!-- - custom css link  -->
    <link rel="stylesheet" href="css/style_sakkarepmu.css">

    <!-- - google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>
    <div class="product-container">
        <div class="container">
            <div class="banner">

                <div class="container">
                    <div class="product-main">
                        <br />
                        <br />
                        <div class="product-grid">
          
                                    <h1>Halaman Pembelian</h1>

                                    <!-- Display purchase page content as needed -->
                                    <p>Lengkapi Data Anda</p>

                                    <!-- Purchase Form -->
                                    <form action="" method="post">
                                        <label for="alamat">Alamat:</label>
                                        <input type="text" name="alamat" required>

                                        <label for="no_telepon">Nomor Telepon:</label>
                                        <input type="text" name="no_telepon" required>

                                        <!-- Hidden fields for mobil_id -->
                                        <input type="hidden" name="mobil_id" value="<?php echo $mobil_id; ?>">

                                        <!-- Display information about the car to be purchased -->
                                        <!-- <p>Nama Pembeli: <?php echo $username; ?></p> -->
                                        <!-- <p>Nama Pembeli: <?php echo isset($username['username']) ? $username['username'] : 'Unknown'; ?></p> -->
                                        <p>Nama Mobil: <?php echo isset($mobil['nama_mobil']) ? $mobil['nama_mobil'] : 'Unknown'; ?></p>

                                        <input type="submit" name="beli" value="Beli Sekarang">

                                        <!-- Cancel button to go back to the detail page -->
                                        <a href="detail_mobil.php?id=<?php echo $mobil_id; ?>">Batal</a>
                                    </form>
            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>