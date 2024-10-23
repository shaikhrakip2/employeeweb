@extends('layouts.main')
@section('main-container')
    {{-- <script>
    new DataTable('#example', {
        responsive: true
    });

</script> --}}
    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Designation</th>
                <th>Company</th>
                <th>Working_experience</th>
                <th>country</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mobiledeveloper as $key => $mobiledev)
                <tr>
                    <td>{{ $mobiledev->name }}</td>
                    <td>{{ $mobiledev->email }}</td>
                    <td>{{ $mobiledev->phone }}</td>
                    <td>{{ $mobiledev->address }}</td>
                    <td>{{ $mobiledev->designation }}</td>
                    <td>{{ $mobiledev->company }}</td>
                    <td>{{ $mobiledev->working_experience }}</td>
                    {{-- <td>{{ $mobiledev->countries }}</td> --}}


                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
