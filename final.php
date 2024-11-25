<!-- Page after we log in -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard for Admin</title>
    <link rel="stylesheet" href="../Login/css/finalcss.css">
</head>

<body onload="initClock()">

<?php
// Start the session
session_start();


// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!-- Your dashboard content goes here -->

    <header>
        <div >
        <div class="col-md-12 text-center"><h1 style="padding-left: 570px">Attendance Management System</h1></div>
        <script>
            function logout() {
                window.location.href = "logout.php";
            }
        </script>
        <div class="log"><button type="button" class="log" onclick= "logout()" style=" padding: 15px;
            margin-left: 1200px;
            margin-bottom: -27px;
            margin-top: -30px">Log Out</button></div>
    </div>
    </header>
    <!--digital clock start-->
    <section class="clockk">
        <clock>
            <div class="datetime">
                <div class="date">
                    <span id="dayname">Day</span>,
                    <span id="month">Month</span>
                    <span id="daynum">00</span>,
                    <span id="year">Year</span>
                </div>
                <div class="time">
                    <span id="hour">00</span>:
                    <span id="minutes">00</span>:
                    <span id="seconds">00</span>
                    <span id="period">AM</span>
                </div>
            </div>
        </clock>
    </section>
    <!--digital clock end-->
    <!-- BUTTON -->


    <div class="button-container">
        <button type="button" class="btn" onclick="location.href='qrgeneration.php'">
            Generate QR code <br>for Students
        </button>
        <button type="button" class="btn" onclick="location.href='qr.php'">
            Scan QR Code <br>for Attendance
        </button>
        <button type="button" class="btn" onclick="location.href='view.php'">
            List of Students
        </button>
        <button type="button" onclick="location.href='record.php'">
            View <br>Student's Attendance
        </button>
    </div>
    </div>



    </div>
    <!-- END OF BUTTON -->
    <script type="text/javascript">
        function updateClock() {
            var now = new Date();
            var dname = now.getDay(),
                mo = now.getMonth(),
                dnum = now.getDate(),
                yr = now.getFullYear(),
                hou = now.getHours(),
                min = now.getMinutes(),
                sec = now.getSeconds(),
                pe = "AM";

            if (hou >= 12) {
                pe = "PM";
            }
            if (hou == 0) {
                hou = 12;
            }
            if (hou > 12) {
                hou = hou - 12;
            }

            Number.prototype.pad = function (digits) {
                for (var n = this.toString(); n.length < digits; n = 0 + n);
                return n;
            }

            var months = ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October", "November", "December"];
            var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
            var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
            for (var i = 0; i < ids.length; i++)
                document.getElementById(ids[i]).firstChild.nodeValue = values[i];
        }

        function initClock() {
            updateClock();
            window.setInterval("updateClock()", 1);
        }
    </script>
</body>

</html>