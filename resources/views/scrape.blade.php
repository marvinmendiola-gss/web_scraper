@extends('layout')

@section('content')
  @if(!empty($result))
    <table class="table table-striped header-fixed">
        <thead class="thead-dark">
        <tr>
            <th>Company Name</th>
            <th>URL</th>
            <th>Date Of Establishment</th>
            <th>Number Of Members</th>
            <th>Address</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($result as $data)
            <tr>
                <td @if($data['company_name'] == '') class="table-warning" @endif>{{ $data['company_name'] }}</td>
                <td @if($data['url'] == '') class="table-warning" @endif>{{ $data['url'] }}</td>
                <td @if($data['founded'] == '') class="table-warning" @endif>{{ $data['founded'] }}</td>
                <td @if($data['members'] == '') class="table-warning" @endif>{{ $data['members'] }}</td>
                <td @if($data['address'] == '') class="table-warning" @endif>{{ $data['address'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
  @endif
@endsection
