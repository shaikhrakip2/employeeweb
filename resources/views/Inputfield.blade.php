<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ url('bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        h5 {
            position: relative;
            left: 50%;
            transform: translate(-50%);
        }
    </style>
</head>
<body>  
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="padding-top: 20px">

                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Inputfield</button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                    aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasRightLabel">Input field</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">

                        <div class="container">
                            <div class="row" style="width: 100%">
                                <form action="" class="field_wrapper">
                                    <div class="col-sm-12" style="display: flex; gap:10px">
                                        <input type="text" name="field_name[]" class="form-control"
                                            placeholder="Enter Your Name" value="" />
                                        <a href="javascript:void(0);" class="add_button btn btn-primary"
                                            title="Add field">+</a>
                                        {{-- <a href="javascript:void(0);" class="remove_button btn btn-danger">-</a> --}}
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var maxField = 10;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            var fieldHTML =
                ' <div class="row"><form action="" class="field_wrapper"><div class="col-sm-12" style="display: flex; padding-top: 20px; gap: 10px"><input type="text" name="field_name[]" class="form-control" placeholder="Enter Your Name" value="" /><a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field">+</a><a href="javascript:void(0);" class="remove_button btn btn-danger">-</a></div></form></div>';

            var x = 1;
            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    $(wrapper).append(fieldHTML);
                } else {
                    alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
                }
            });

            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            });
        });


        
    </script>
</body>
</html>
