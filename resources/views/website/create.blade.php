@extends('website.layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .remove-btn {
            cursor: pointer;
            color: red;
        }
    </style>
</head>

<body>

    @section('content')
        <div class="mt-5">
            <h2>Create Approval Flow Discount Program</h2>
            <form id="dynamic-form" action="{{ route('internal.update') }}" method="post" enctype="multipart/form-data"
                style="margin-top: 10px">
                {{ method_field('put') }}
                {{ csrf_field() }}
                <div id="forms-container">
                    @foreach ($data as $index => $item)
                    <div class="form-group row" data-index="{{ $index }}">
                        <div class="col-md-5">
                            <label for="level-{{ $index }}" style="font-weight: bold">LEVEL</label>
                            <input class="form-control" id="level-{{ $index }}" size="16" type="number" name="forms[{{ $index }}][level]"
                            placeholder="Title of the about" value="{{ $item->level }}" required>
                        </div>
                        <div class="col-md-5">
                            <label for="title_name-{{ $index }}" style="font-weight: bold">ASSIGNED TITLE</label>
                            <input class="form-control" id="title_name-{{ $index }}" size="16" type="text" name="forms[{{ $index }}][title_name]"
                                placeholder="Title of the about" value="{{ $item->title_name }}" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <span class="remove-btn" onclick="removeForm(this)">&#10006;</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary" id="add-form-btn">Add Form</button>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>

       
        <script>
            let formIndex = {{ count($data) }};

            $('#add-form-btn').on('click', function() {
                const formsContainer = $('#forms-container');
                const newForm = `
                <div class="form-group row" data-index="${formIndex}">
                    <div class="col-md-5">
                        <label for="level-${formIndex}">Level</label>
                        <input type="number" id="level-${formIndex}" name="forms[${formIndex}][level]" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label for="title_name-${formIndex}">Title Name</label>
                        <input type="text" id="title_name-${formIndex}" name="forms[${formIndex}][title_name]" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <span class="remove-btn" onclick="removeForm(this)">&#10006;</span>
                    </div>
                </div>
                `;
                formsContainer.append(newForm);
                formIndex++;
            });

            function removeForm(element) {
                $(element).closest('.form-group').remove();
            }

            // Optional: If you want to allow inline editing
            $('#forms-container').on('change', '.form-group', function() {
                let index = $(this).data('index');
                let levelInput = $(this).find(`#level-${index}`);
                let titleNameInput = $(this).find(`#title_name-${index}`);

                // Add your inline editing logic here
                // Example: Open a modal to edit or make the input fields editable
                // You could use a modal or other UI elements to handle this
            });
        </script>

    @stop

</body>

</html>
