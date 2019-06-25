@extends('adminlte::page')

@section('title', 'Edit Trainer Models')

@section('content_header')
    <h1>Trainer <=> Models</h1>
@stop

@section('content')
<h2>{{ $trainer->name}}</h2>
<h4>{{ $studio->name}}</h4>

<div class="col-sm-12 col-lg-5" style="border: 2px solid black;">

    <table style="width:100%;height:150px;" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>My Models</th>
            </tr>
        </thead>

        <tbody  id ="mytable">
        @foreach($mymodels as $mmodel)
            <tr><td onclick="mymodels(this);">{{ $mmodel }}</td></tr>
        @endforeach
        </tbody>
    </table>
    
</div>

<div class="col-sm-12 col-lg-1" style="text-align:center">
    <div> >> </div>
    <div> << </div>
    <div> <button class="btn btn-success" onclick="save();">Save</button> </div>
</div>



<div class="col-sm-12 col-lg-6" style="max-height:600px; overflow:scroll;border: 2px solid black;">

    <table style="width:100%;height:150px;" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Models in {{ $studio->name}}</th><th>Status</th>
            </tr>
        </thead>

        <tbody>
        @foreach($allmodels as $model => $trainers)
            <tr><td onclick="models(this);">{{ $model }}</td><td>{{ $trainers }}</td></tr>
        @endforeach
        </tbody>
    </table>

</div>

@stop


@section('adminlte_js')

<script>

let id = '{{ $trainer->id}}';

    function mymodels(e){

        $(e).closest('tr').remove();

    }

    function models(e){

        let elem = e.innerText;
        let tr = $('<tr>');
        let td = $('<td>', { text: elem,  on: {    click: function() {     $(this).closest('tr').remove();    } } } );
        tr.append(td);
        $('#mytable').parent().append(tr);

    }

    function save(){

        let my_array = [];

        let all_td = $("#mytable td");

        all_td.each(function() {
            let v = $(this)[0].innerText;
            if (!my_array.includes(v)) my_array.push(v);
        });

        console.log('before '+my_array);
        if (!Array.isArray(my_array) || !my_array.length) {
            my_array = '';
            console.log('hereeee '+my_array);
        } else my_array = my_array.join();
        
        console.log('after '+my_array);

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "../ajaxAdminData",
                    method: 'post',
                    data: {trainer: id, mymodels: my_array},
                    success: function (html) {
                        console.log('return: '+html);
                        if (html == 'success') alert('Models updated successfully!');
                        else alert('Something went wrong..');
                    }
                });

    }

</script>

@stop