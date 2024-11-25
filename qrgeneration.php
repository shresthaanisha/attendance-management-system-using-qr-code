<?php
  include "connect.php";
  ob_start();
  session_start();
  ?>
<html lang="en" >
	
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>QR Code Generator</title>
	<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'> -->
	<link rel='stylesheet' href='css\style.css'>
</head>
<body>
<?php 
  // Check if the user is not logged in
  if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
}
  ?>

  <div class="container">
    <div class="title">Student Registration</div>
    <?php
    $id = "";
    $full_name = "";
    $email = "";
    $course = "";
    $sem = "";
    $phone = "";
    $address = "";
    $age = "";


    if (isset($_POST["btnsubmit"])) {
      $id = $_POST["id"];
      $full_name = $_POST["full_name"];
      $email = $_POST["email"];
      $course = $_POST["course"];
      $sem = $_POST["semester"];
      $phone = $_POST["phone"];
      $address = $_POST["student_address"];
      $age = $_POST["age"];

      /*echo "<pre>";
                                                     var_dump($_POST);
                                                     echo "</pre>";*/
    }
    ?>
    <div class="content">
      <form autocomplete="off" class="form" role="form" action="qrgeneration.php" method="post">
        <div class="user-information">
          <div class="box-card">
            <label class="col-lg-3 col-form-label form-control-label">Id</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" value="<?php echo $id; ?>" name="id">
            </div>
          </div>
          <div class="box-card">
            <label class="col-lg-3 col-form-label form-control-label">Full Name</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" value="<?php echo $full_name; ?>" name="full_name">
            </div>
          </div>
          <div class="box-card">
    <label class="col-lg-3 col-form-label form-control-label">Course</label>
    <div class="col-lg-9">
        <select class="form-control" name="course" style="
            padding: 10px 109px;
            border-radius: 5px;
            border: 1px solid;
            border-bottom-width: 2px;
            transition: all 0.3s ease;
            border-color: #95b8d1 ;
        ">
            <!-- Add options for each course -->
            <option value="CSIT" <?php echo ($course === 'CSIT') ? 'selected' : ''; ?>>BSC.CSIT</option>
            <option value="BCA" <?php echo ($course === 'BCA') ? 'selected' : ''; ?>>BCA</option>
            <option value="BBM" <?php echo ($course === 'BBM') ? 'selected' : ''; ?>>BBM</option>
            <option value="BBA" <?php echo ($course === 'BBA') ? 'selected' : ''; ?>>BBA</option>
            <!-- Add more options as needed -->
        </select>
    </div>
</div>
<div class="box-card">
    <label class="col-lg-3 col-form-label form-control-label">Semester</label>
<div class="col-lg-9">
        <select class="form-control" name="semester" style="
            padding: 10px 109px;
            border-radius: 5px;
            border: 1px solid;
            border-bottom-width: 2px;
            transition: all 0.3s ease;
            border-color: #95b8d1 ;
        
        ">
            <!-- Add options for each course -->
            <option value="first" <?php echo ($sem === 'first') ? 'selected' : ''; ?>>First</option>
            <option value="second" <?php echo ($sem === 'second') ? 'selected' : ''; ?>>Second</option>
            <option value="third" <?php echo ($sem === 'third') ? 'selected' : ''; ?>>Third</option>
            <option value="fourth" <?php echo ($sem === 'fourth') ? 'selected' : ''; ?>>Fourth</option>
            <option value="fifth" <?php echo ($sem === 'fifth') ? 'selected' : ''; ?>>Fifth</option>
            <option value="sixth" <?php echo ($sem === 'sixth') ? 'selected' : ''; ?>>Sixth</option>
            <option value="seventh" <?php echo ($sem === 'seventh') ? 'selected' : ''; ?>>Seventh</option>
            <option value="eighth" <?php echo ($sem === 'eighth') ? 'selected' : ''; ?>>Eighth</option>
            <!-- Add more options as needed -->
        </select>
    </div>
</div>
          <div class="box-card">
            <label class="col-lg-3 col-form-label form-control-label">Phone Number</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" data-numeric-input value="<?php echo $phone; ?>" name="phone">
            </div>
          </div>
          <div class="box-card">
            <label class="col-lg-3 col-form-label form-control-label">Address</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" value="<?php echo $address ?>" name="student_address">
            </div>
          </div>
          <div class="box-card">
            <label class="col-lg-3 col-form-label form-control-label">Age</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" data-numeric-input value="<?php echo $age; ?>" name="age" min="1"
                max="100">
            </div>
          </div>
          <div class="box-card">
            <label class="col-lg-3 col-form-label form-control-label">Email</label>
            <div class="col-lg-9">
              <input class="form-control" type="text"  value="<?php echo $email; ?>" name="email">
            </div>
          </div>
           <div class="box-card">
           
          </div>
          <br>
          <div class="button">
			<!-- style="display: block; margin: auto;" -->
            <input type="submit" name="btnsubmit" value="Generate QR code">
          </div>
      </form>
      <?php
      include "phpqrcode/qrlib.php";


      $PNG_TEMP_DIR = 'temp/';
      if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

      $filename = $PNG_TEMP_DIR . 'test.png';


      if (isset($_POST["btnsubmit"])) {


        $id = $_POST["id"];
        $full_name = $_POST["full_name"];
        $email = $_POST["email"];
        $course = $_POST["course"];
        $sem = $_POST["semester"];
        $phone = $_POST["phone"];
        $address = $_POST["student_address"];
        $age = $_POST["age"];

        // Validate that required fields are not empty
        if (empty($id) || empty($full_name) || empty($course) || empty($email) || empty($course) || empty($phone) || empty($address) || empty($age)) {
          // $_SESSION['valid_form_values'] = $_POST;
          header('location:qrgeneration.php?val=true');
          exit(0);
        }
        if (!preg_match('/^98\d{8}$/', $phone)) {
          // $_SESSION['valid_form_values'] = $_POST;
          header('location:qrgeneration.php?ph=true');
          exit(0);
        } 
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          header('location:qrgeneration.php?em=true');
          exit(0);
      }
        else {
          $check = "SELECT id FROM students WHERE id ='$id'";
          $check_run = $conn->query($check);


          if ($check_run->num_rows == 0) {
            $codeString = $_POST["id"] . "_";
            $codeString .= $_POST["full_name"] . "\n";

            $filename = $PNG_TEMP_DIR . 'test' . md5($codeString) . '.png';

            QRcode::png($codeString, $filename);
      
            echo '<img src="' . $PNG_TEMP_DIR . basename($filename) . '" /><hr/>';





            //Read the QR code image as binary data
            //$qrCodeImage = file_get_contents($filename);
      
            // Encode the binary data as base64 (optional)
            //$qrCodeImageBase64 = base64_encode($qrCodeImage);
      
            $sql = "INSERT INTO students (id, full_name, course, semester, phone, student_address, age, email, qrcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
              die("Error in preparing statement: " . $conn->error);
            }

            // Bind the data to the statement
            $stmt->bind_param("ssssssiss", $id, $full_name, $course, $sem, $phone, $address, $age, $email, $filename);

            // Execute the statement
            if ($stmt->execute()) {
              // echo "Data inserted into the database successfully.";
            } else {
              echo "Error: " . $stmt->error;
            }

            // Close the statement and database connection
            $stmt->close();
          } else {
            header('location:qrgeneration.php?error=true');
            exit(0);
          }


        }

      }
      if (isset($_GET['error'])) {
        echo '<p style="color: red;">Student Id already registered</p>';
      }

      if (isset($_GET['ph'])) {
        echo '<p style="color: red;">Invalid phone number </p>';
      }

      if (isset($_GET['val'])) {
        echo '<p style="color: red;">Please fill in all required fields.</p>';
      }
      if (isset($_GET['em'])) {
        echo '<p style="color: red;">Invalid Email format</p>';
      }
      ?>
      <script>

        document.addEventListener('DOMContentLoaded', function () {
          // Function to validate numeric input and restrict the range
          function validateNumericInputs(dataAttribute) {
            var inputs = document.querySelectorAll('[' + dataAttribute + ']');

            inputs.forEach(function (input) {
              input.addEventListener('input', function (e) {
                // Remove non-numeric characters using a regular expression
                this.value = this.value.replace(/[^0-9]/g, '');

                // Get the min and max attributes
                var min = parseFloat(this.getAttribute('min'));
                var max = parseFloat(this.getAttribute('max'));

                // Parse the input value as a float
                var value = parseFloat(this.value);

                // Check if the value is within the specified range
                if (!isNaN(value)) {
                  if (!isNaN(min) && value < min) {
                    this.value = min.toString();
                  } else if (!isNaN(max) && value > max) {
                    this.value = max.toString();
                  }
                }
              });
            });
          }

          // Call the function with the common data attribute
          validateNumericInputs('data-numeric-input');
        });

        function goBack() {
          window.location.href = "final.php";
        }

        //remove any error msg after reload
        document.addEventListener('DOMContentLoaded', function () {
          // Array of parameter names to remove
          const parametersToRemove = ['error'];

          // Function to remove specified parameters from the URL
          function removeURLParameters() {
            const urlParams = new URLSearchParams(window.location.search);

            parametersToRemove.forEach(function (param) {
              if (urlParams.has(param)) {
                urlParams.delete(param);
              }
            });

            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.history.replaceState({}, document.title, newUrl);
          }

          // Call the function to remove parameters after page load
          removeURLParameters();
        });

        history.pushState(null, null, location.href);
        window.onpopstate = function () {
          history.go(1);
        };

      </script>
      
    </div> <!--/content-->
	<div class="dash">
		<button onclick="goBack()" style ="
      border-radius: 8px;
    " >Go To Dashboard</button>
	</div>
  </div><!--/container-->

</body>
</html>