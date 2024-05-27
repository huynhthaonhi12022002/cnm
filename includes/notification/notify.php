<?php
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case '0' : {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('delete-alert').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('delete-alert').style.display = 'none';
                }, 1500); // Thời gian chờ 3000 miliseconds (3 giây) trước khi ẩn thông báo
            });
            </script>";
          break; 
        }
        case '1' : { 
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('success-alert').style.display = 'block';
                    setTimeout(function() {
                        document.getElementById('success-alert').style.display = 'none';
                    }, 1500); // Thời gian chờ 3000 miliseconds (3 giây) trước khi ẩn thông báo
                });
            </script>";
          break; 
        }
        case '2' : { 
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('update-alert').style.display = 'block';
                        setTimeout(function() {
                            document.getElementById('update-alert').style.display = 'none';
                        }, 1500); // Thời gian chờ 3000 miliseconds (3 giây) trước khi ẩn thông báo
                    });
                </script>";
          break; 
        }
        case '3' : { 
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('download-alert').style.display = 'block';
                        setTimeout(function() {
                            document.getElementById('download-alert').style.display = 'none';
                        }, 1500); // Thời gian chờ 3000 miliseconds (3 giây) trước khi ẩn thông báo
                    });
                </script>";
          break; 
        }
    }
}