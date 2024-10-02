<?php
function getsensorData()
{
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'machine_health_monitoring');

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Perform a query to fetch the data
    $query = "SELECT * FROM sensordata";
    $result = mysqli_query($conn, $query);

    // Create an array to hold the data
    $data = array();

    // Add the column headers to the data array
    $data[] = ['id', 'current_value', 'voltage_value', 'rpm_value', 'temperature_value', 'noise_value'];

    // Fetch the data rows and add them to the data array
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                $row['id'], 
                (int)$row['current_value'], 
                (int)$row['voltage_value'], 
                (int)$row['rpm_value'], 
                (int)$row['temperature_value'], 
                (int)$row['noise_value']
            ];
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Return the data as JSON only if data is available
    if (!empty($data)) {
        return json_encode($data);
    } else {
        return null;
    }
}

$sensorData = getsensorData(); // Fetch the sensor data

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  
  <link href="assets/img/drill.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  
</head>
<style>
  body {
    background: url('bg1.png') no-repeat center center fixed;
    background-size: cover;
  }
</style>
<body>


  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">Machine Monitor</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="pages-error-404.html">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar --> 

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <li class="nav-item dropdown pe-3">
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->



 
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->      
      <li class="nav-item">
        <a class="nav-link " data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="charts-chartjs.php" class="active">
              <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
          </li>
      
      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Developers Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->
    </ul>
  </aside>
  
<!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">       
            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">Introduction :</h5>
                      <p style="font-size: 16px; line-height: 1.6;">
                          <strong style="font-size: 18px;">Introduction to Machine Health Monitoring</strong>
                          <br><br>
                          <span style="font-weight: bold;">Machine Health Monitoring</span> is a critical practice in modern industrial environments, aimed at ensuring the optimal performance and longevity of machinery. By continuously tracking key operational parameters such as <strong style="color: #007bff;">temperature</strong>, <strong style="color: #007bff;">vibration</strong>, <strong style="color: #007bff;">current</strong>, <strong style="color: #007bff;">voltage</strong>, and <strong style="color: #007bff;">noise levels</strong>, machine health monitoring systems detect early signs of wear, malfunction, or inefficiency. This real-time data collection allows maintenance teams to <strong>anticipate failures</strong> and schedule preventive interventions, minimizing unexpected downtimes and repair costs.
                          <br><br>
                          Advancements in <span style="font-weight: bold; color: #28a745;">IoT</span> and sensor technologies have revolutionized machine health monitoring, enabling automated data collection, <strong style="color: #17a2b8;">remote diagnostics</strong>, and <span style="font-weight: bold; color: #17a2b8;">predictive maintenance</span> through machine learning algorithms. This proactive approach not only boosts <strong>operational efficiency</strong> but also enhances <span style="font-weight: bold; color: #ffc107;">safety</span> and <span style="font-weight: bold; color: #ffc107;">sustainability</span> by reducing energy consumption and extending machine life.
                          <br><br>
                          Industries such as <strong style="color: #dc3545;">manufacturing</strong>, <strong style="color: #dc3545;">energy</strong>, and <strong style="color: #dc3545;">transportation</strong> are increasingly adopting machine health monitoring systems to optimize productivity and maintain consistent performance.
                      </p>
                  </div>
              </div>
          </div>
<!-- End Reports -->

  <div class="row">
    <!-- First Container (Recent Data) -->
    <div class="col-12">
        <div class="card recent-sales overflow-auto">
            <div class="card-body">
                <h5 class="card-title">Recent Data</h5>

                <table class="table table-borderless datatable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Temp</th>
                            <th scope="col">Noise</th>
                            <th scope="col">Current</th>
                            <th scope="col">Voltage</th>
                            <th scope="col">RPM</th>
                        </tr>
                    </thead>
                    <tbody id="data-table">
                        <!-- PHP code to dynamically generate rows -->
                        <?php
                        if (!empty($sensorData)) {
                            $sensorDataArray = json_decode($sensorData, true);
                            $rows = array_slice($sensorDataArray, 1);

                            foreach ($rows as $row) {
                                echo '<tr>';
                                foreach ($row as $cell) {
                                    echo '<td>' . $cell . '</td>';
                                }
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6" class="no-data">No data found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- End of Recent Data Container -->

    <!-- Second Container (Data Flow) -->
    <div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Data Flow Diagram <span>| Machine Health Monitoring System</span></h5>
            <p>
                The data flow diagram for the Machine Health Monitoring System outlines how sensor data (Current, Voltage, RPM, Temperature, and Noise) is collected, processed, and transmitted for analysis. Below is an overview of the data flow for each parameter.
            </p>

            <div class="activity">
                <div class="activity-item d-flex">
                    <div class="activite-label">Week 1</div>
                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                    <div class="activity-content">
                        <strong>Current:</strong> Data from current sensors is recorded and sent to the central database for analysis.
                    </div>
                </div><!-- End Data Flow item-->

                <div class="activity-item d-flex">
                    <div class="activite-label">Week 2</div>
                    <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                    <div class="activity-content">
                        <strong>Voltage:</strong> Voltage levels are measured continuously and monitored for anomalies.
                    </div>
                </div><!-- End Data Flow item-->

                <div class="activity-item d-flex">
                    <div class="activite-label">Week 3</div>
                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                    <div class="activity-content">
                        <strong>Temperature:</strong> Temperature sensors collect thermal data to prevent overheating and mechanical wear.
                    </div>
                </div><!-- End Data Flow item-->

                <div class="activity-item d-flex">
                    <div class="activite-label">Week 4</div>
                    <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                    <div class="activity-content">
                        <strong>RPM:</strong> RPM data is gathered to track motor or machine speed and ensure smooth operation.
                    </div>
                </div><!-- End Data Flow item-->

                <div class="activity-item d-flex">
                    <div class="activite-label">Week 5</div>
                    <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                    <div class="activity-content">
                        <strong>Noise:</strong> Noise levels are monitored to detect abnormal mechanical conditions.
                    </div>
                </div><!-- End Data Flow item-->

                <div class="activity-item d-flex">
                    <div class="activite-label">Week 6</div>
                    <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                    <div class="activity-content">
                        <strong>Data Transmission:</strong> All collected data is sent to the cloud/server for real-time monitoring and predictive maintenance analysis.
                    </div>
                </div><!-- End Data Flow item-->
            </div>
        </div>
    </div><!-- End Data Flow -->
</div>


    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
 <!-- ======= Footer ======= -->
 <footer id="footer" class="footer">
  <div class="copyright"><strong><span>Machine Monitor</span></strong>. All Rights Reserved
  </div>
</footer>
<!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>