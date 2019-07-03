@extends('adminlte::page')

@section('title', 'Trainers')

@section('content_header')
    <h1>Trainers List</h1>
@stop

@section('content')


<table id="myTable" class="table table-striped table-bordered" style="width:100%">
<thead>
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Studio</th> 
    <th>Email</th>
    <th>Phone</th>
    <th>Job Title</th>
    <th>Models</th>
    <th>Date</th>
  </tr>
  </thead>

  <tbody>
  @foreach ($trainers as $trainer)
  <tr >
    <td>{{ $trainer->id }}</td>
    <td onclick="window.location='{{ url("admin/edittrainer/$trainer->id") }}'">{{ $trainer->name }}</td> 
    <td onclick="window.location='{{ url("admin/edittrainer/$trainer->id") }}'">{{ $trainer->sName }}</td>
    <td onclick="window.location='{{ url("admin/edittrainer/$trainer->id") }}'">{{ $trainer->email }}</td>
    <td onclick="window.location='{{ url("admin/edittrainer/$trainer->id") }}'">{{ $trainer->phone }}</td>
    <td onclick="window.location='{{ url("admin/timetable/$trainer->id") }}'">{{ $trainer->type }}</td>
    <td>{{ strlen($trainer->mymodels) > 50 ? substr($trainer->mymodels,0,50)."..." : $trainer->mymodels }}<button class="btn btn-success" style="float:right" onclick="window.location='{{ url("admin/edittrainermodels/$trainer->id") }}'">Edit</button></td>
    <td onclick="window.location='{{ url("admin/edittrainer/$trainer->id") }}'">{{ $trainer->created_at }}</td>
  </tr>
  @endforeach
  </tbody>

  <tfoot>
            <tr>
            <th>#</th>
            <th>Name</th>
            <th>Studio</th> 
            <th>Email</th>
            <th>Phone</th>
            <th>Shift</th>
            <th>Models</th>
            <th>Date</th>
            </tr>
        </tfoot>
  
</table>
    

@stop


@section('adminlte_js')


<script>

    $(document).ready(function() {

        $('#myTable').DataTable( {
            "order": [[ 0, "asc" ]]
        } );
    } );


</script>
@stop


