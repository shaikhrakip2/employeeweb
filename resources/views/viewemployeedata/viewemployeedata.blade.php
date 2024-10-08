@extends('layouts.main')
@section('main-container')


<table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead>
        <tr>
            <th>ID No</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Mobile No</th>
            <th>Image</th>
            <th>City</th>
            <th>State</th>
            <th>Created_at</th>
            <th>Updated_at</th>
        </tr>
    </thead>
    <tbody>

        <form action="{{ route('viewemployeedata', $user->id) }}">
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td><img src="{{ Storage::url($user->image) }}" alt="user Image {{ $user->image }}" style="max-width: 50px; height: 40px;"></td>
                <td>{{ $user->city }}</td>
                <td>{{ $user->state }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
            </tr>
        </form>
    </tbody>
</table>



@endsection
