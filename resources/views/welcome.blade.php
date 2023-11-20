@extends('layouts.app')

@section('content')
    <!-- Existing content -->

    <div class="row">
        <div class="col-md-6">
            <!-- Existing form -->

            <!-- New AJAX form for project creation and editing -->
            <form id="projectForm">
                @csrf
                <input type="hidden" id="projectId" name="projectId">
                <div class="mb-3">
                    <label for="name" class="form-label">Project Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn">Add Project</button>
            </form>
        </div>

        <div class="col-md-6 border-left">
            <h2>Project List </h2>
            <table class="table" id="projectsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- AJAX script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to fetch and display projects
            function fetchProjects() {
                $.ajax({
                    url: 'http://localhost/testapi/api/getallprojects',
                    type: 'POST',
                    success: function (data) {
                        var tableBody = $('#projectsTable tbody');
                        tableBody.empty();
    
                        $.each(data, function (index, project) {
                            tableBody.append('<tr>' +
                                '<td>' + project.id + '</td>' +
                                '<td>' + project.name + '</td>' +
                                '<td>' +
                                    '<button class="btn btn-danger" onclick="deleteProject(' + project.id + ')">Delete</button> ' +
                                    '<button class="btn btn-primary" onclick="updateProject(' + project.id + ')">Edit</button>' +
                                '</td>' +
                                '</tr>');
                        });
                    }
                });
            }
    
            // Initial fetch of projects
            fetchProjects();
    
            // AJAX form submission for adding or editing a project
            $('#projectForm').submit(function (e) {
                e.preventDefault();
    
                console.log('Form submitted');
    
                var url = 'http://localhost/testapi/api/addproject';
                var method = 'POST';
    
                // Check if projectId is present, indicating an edit operation
                if ($('#projectId').val()) {
                    url = 'http://localhost/testapi/api/updateproject';
                }
    
                // Include the id field in the data
                var data = $(this).serialize();
                if ($('#projectId').val()) {
                    data += '&id=' + $('#projectId').val();
                }
    
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function (data) {
                        console.log('AJAX request successful');
                        fetchProjects();
                        $('#projectForm')[0].reset();
                        $('#projectId').val('');
                        $('#submitBtn').html('Add Project');
                    },
                    error: function (xhr, status, error) {
                        // Handle validation errors
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            console.log(errors);
                            // Display errors to the user as needed
                        } else {
                            // Handle other types of errors
                            console.log(error);
                        }
                    }
                });
            });
        });
    
        // Function to delete a project
        function deleteProject(id) {
            $.ajax({
                url: 'http://localhost/testapi/api/deleteproject?id=' + id,
                type: 'POST', // Use POST for deletion
                success: function () {
                    console.log('AJAX request successful');
                    location.reload();
                    fetchProjects();
                }
            });
        }
    
        // Function to edit a project
        function updateProject(id) {
            // Fetch project details by ID and populate the form for editing
            $.ajax({
                url: 'http://localhost/testapi/api/getallprojects?id=' + id,
                type: 'POST', // Use POST for updating
                success: function (project) {
                    $('#projectId').val(project.id);
                    $('#name').val(project.name);
                    $('#submitBtn').html('Update Project');
                    
                }
                
            });
        }
    </script>
@endsection
