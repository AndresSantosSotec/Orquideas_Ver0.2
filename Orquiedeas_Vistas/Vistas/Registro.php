<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="p-4">

    <!-- Button to test Bootstrap -->
    <button class="btn btn-primary" id="bootstrapBtn">Test Bootstrap</button>
    
    <!-- Button to test jQuery -->
    <button class="btn btn-secondary" id="jqueryBtn">Test jQuery</button>
    
    <!-- Button to test SweetAlert -->
    <button class="btn btn-success" id="sweetAlertBtn">Test SweetAlert</button>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // jQuery Test
        $(document).ready(function() {
            $('#jqueryBtn').click(function() {
                $(this).text('jQuery Working!');
            });
        });

        // SweetAlert Test
        $('#sweetAlertBtn').click(function() {
            Swal.fire({
                title: 'SweetAlert2 Working!',
                text: 'This is a success message!',
                icon: 'success',
                confirmButtonText: 'Cool'
            });
        });

        // Bootstrap Test
        document.getElementById('bootstrapBtn').addEventListener('click', function() {
            this.innerHTML = "Bootstrap Working!";
            this.classList.remove('btn-primary');
            this.classList.add('btn-danger');
        });
    </script>

</body>
</html>
