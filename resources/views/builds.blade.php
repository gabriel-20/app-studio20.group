@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <h1>Clients Online</h1>
@stop

@section('content')

    <table  class="table" style="width:100%">
        <tr>
            <th>socket id</th>
            <th>name</th>
            <th>type</th>
            <th>build</th>
            <th>action</th>
        </tr>
        <tbody id="myTable"></tbody>

    </table>

@stop

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://work.studio20.group:3000/socket.io/socket.io.js"></script>
<script>

    let socket = io("https://work.studio20.group:3000", {
        reconnection: true,
        reconnectionDelay: 1000,
        reconnectionDelayMax : 5000,
        reconnectionAttempts: 99999
    } );

    let trainers = {};
    let models = {};


    socket.on('allbuilds_response', (data) => {

        let mytable = $("#myTable");
        mytable.empty();

        console.log(data);
        let all = data.all;
        let thRow = '';

        for (let i = 0; i < all.length; i++) {

            let socket = all[i].id;
            let name = all[i].name;
            let type = all[i].type;
            let build = all[i].build;

            let tr = $('<tr/>', {});
            let td1 = $('<td/>', {text: socket});
            let td2 = $('<td/>', {text: name});
            let td3 = $('<td/>', {text: type});
            let td4 = $('<td/>', {text: build});
            let td5 = $('<button/>', {text: "Close App", click: function () { closeApp(socket); } });

            tr.append(td1,td2,td3,td4,td5);
            mytable.append(tr);

        }


    });

    function closeApp(id){

        console.log(id);
        socket.emit('closeapp',{ id });
    }

    $(document).ready(function(){

        socket.emit("allbuilds");

    });



</script>