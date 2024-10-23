@extends('layouts.main')
@section('main-container')
    <div class="container mt-4">

        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="alert alert-primary mb-4 text-center">

                </div>


                <form action="">

                    <div class="form-group mb-3">
                        <select id="country-dropdown" class="form-control">
                            <option value="">Select Country</option>
                            @foreach ($countries as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select id="state-dropdown" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="city-dropdown" class="form-control">
                        </select>
                    </div>
                    
                    <button type="button" class="btn btn-primary" style="width:100% ">save</button>
                </form>




            </div>

        </div>

    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {



            $('#country-dropdown').on('change', function() {

                var idCountry = this.value;

                $("#state-dropdown").html('');

                $.ajax({

                    url: "{{ url('api/fetch-states') }}",

                    type: "POST",

                    data: {

                        country_id: idCountry,

                        _token: '{{ csrf_token() }}'

                    },

                    dataType: 'json',

                    success: function(result) {

                        $('#state-dropdown').html(
                            '<option value="">Select State</option>');

                        $.each(result.states, function(key, value) {

                            $("#state-dropdown").append('<option value="' + value

                                .id + '">' + value.name + '</option>');

                        });

                        $('#city-dropdown').html('<option value="">Select City</option>');

                    }

                });

            });


            $('#state-dropdown').on('change', function() {

                var idState = this.value;

                $("#city-dropdown").html('');

                $.ajax({

                    url: "{{ url('api/fetch-cities') }}",

                    type: "POST",

                    data: {

                        state_id: idState,

                        _token: '{{ csrf_token() }}'

                    },

                    dataType: 'json',

                    success: function(res) {

                        $('#city-dropdown').html('<option value="">-- Select City --</option>');

                        $.each(res.cities, function(key, value) {

                            $("#city-dropdown").append('<option value="' + value

                                .id + '">' + value.name + '</option>');

                        });

                    }

                });

            });



        });
    </script>
@endsection
