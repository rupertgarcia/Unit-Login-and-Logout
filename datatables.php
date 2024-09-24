<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal with DataTable</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> <!-- DataTables CSS -->
</head>
<body>
    <div class="container-wrapper">
        <!-- Modal for Check Records with DataTable -->
        <div class="modal fade" id="checkRecordsModal" tabindex="-1" role="dialog" aria-labelledby="checkRecordsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkRecordsModalLabel">Check Records</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- DataTable inside modal -->
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Asset Tag</th>
                                    <th>Brand</th>
                                    <th>Date Logged In</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>1234</td>
                                    <td>AT-4567</td>
                                    <td>Dell</td>
                                    <td>2024-09-24 10:00 AM</td>
                                </tr>
                                <tr>
                                    <td>Jane Doe</td>
                                    <td>5678</td>
                                    <td>AT-8910</td>
                                    <td>HP</td>
                                    <td>2024-09-24 12:00 PM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Check Records button -->
        <button id="checkRecordsBtn" class="btn btn-info mt-3">Check Records</button>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> <!-- Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->

    <script>
    // Initialize DataTable
    $(document).ready(function() {
        // Initialize DataTable when modal is shown
        $('#checkRecordsModal').on('shown.bs.modal', function () {
            $('#example').DataTable();
        });

        // Check Records button click handler to show the modal
        document.getElementById("checkRecordsBtn").addEventListener("click", function() {
            $('#checkRecordsModal').modal('show');
        });
    });
    </script>
</body>
</html>
