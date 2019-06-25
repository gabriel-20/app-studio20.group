@extends('adminlte::page')

@section('title', 'Shift Report')

@section('content_header')
    <h1>Shift Report</h1>
@stop

@section('content')

<div class="col-lg-12">

    <div class="row">
        <div class="col-lg-6">

            <table class="table">
                <thead>
                <tr>
                    <th>Suport</th>
                    <th>Login</th>
                    <th>Logout</th>
                </tr>
                </thead>
                @foreach($trRes as $trainer)

                    <tr>
                        <td>{{$trainer->name}}</td>
                        <td>{{$trainer->date}}</td>
                        <td>{{$trainer->end_date}}</td>
                    </tr>

                @endforeach
            </table>
        </div>
    </div>

  <h3>Selected Date:  <span id="selectDate">{{ $tday }}</span> </h3>

  <p>Date: <input type="text" id="datepicker"></p>

  <table id="table_id" class="display" style="display: block;overflow-x: auto;white-space: nowrap;">
    <thead>
        <tr>
            <th>Studio</th>
            <th>Shift</th>
            <th>Models</th>
            <th>Suport</th>
            <th>Suport in charge</th>
            <th>Arrival Time</th>
            <th>Login Time</th>
            <th>Pre Login Time</th>
            <th>Login Time Period</th>
            <th>Log off Time Period</th>
            <th>Online Time</th>
            <th>Logout Time</th>
            <th>Breaks total time</th>
            <th>Income last logout</th>
            <th>Offline Income</th>
            <th>Room</th>
            <th>Price </th>
            <th>Award points </th>
            <th>Place in Awards</th>
            <th>Average shift Sales</th>
            <th>Total Shift Sales</th>
            <th>Shift/Average</th>
            <th>Field1</th>
            <th>Field2</th>
            <th>Field3</th>
            <th>Field4</th>
            <th>Field5</th>
            <th>Field6</th>
            <th>Total Period Sales</th>
        </tr>
    </thead>
    <tbody>

    @foreach ($inShift as $shift)
        <tr>
            <td>{{$shift->studioName}}</td>
            <td>T1</td>
            <td onclick="getShiftTimeline('{{$shift->model}}');">{{$shift->model}}</td>
            <td>{{$shift->support}}</td>
            <td>{{$shift->support_main}}</td>
            <td>{{$shift->arrival_time}}</td>
            <td>{{$shift->login_time}}</td>
            <td>{{$shift->pre_login_time}}</td>
            <td>{{$shift->login_time_period_before}}</td>
            <td>{{$shift->login_time_period_after}}</td>
            <td>{{$shift->total_time_shift_w}}</td>
            <td>{{$shift->logout_time}}</td>
            <td>{{$shift->total_break_time_shift}}</td>
            <td>{{$shift->income_last_logout}}</td>
            <td>{{$shift->offline_income}}</td>
            <td>{{$shift->room}}</td>
            <td>{{$shift->price_minute_awemp}}</td>
            <td>{{$shift->awd_points}}</td>
            <td>{{$shift->place_awd}}</td>
            <td>${{$shift->avg_shift_sales}}</td>
            <td>${{$shift->total_this_shift}}</td>
            <td>{{$shift->shift_avg}}%</td>
            <td style="max-width: 20px;overflow: hidden;" data-toggle="tooltip" data-placement="bottom" title="{{$shift->field1}}">{{$shift->field1}}</td>
            <td style="max-width: 20px;overflow: hidden;" data-toggle="tooltip" data-placement="bottom" title="{{$shift->field1}}">{{$shift->field2}}</td>
            <td style="max-width: 20px;overflow: hidden;" data-toggle="tooltip" data-placement="bottom" title="{{$shift->field1}}">{{$shift->field3}}</td>
            <td style="max-width: 20px;overflow: hidden;" data-toggle="tooltip" data-placement="bottom" title="{{$shift->field1}}">{{$shift->field4}}</td>
            <td style="max-width: 20px;overflow: hidden;" data-toggle="tooltip" data-placement="bottom" title="{{$shift->field1}}">{{$shift->field5}}</td>
            <td style="max-width: 20px;overflow: hidden;" data-toggle="tooltip" data-placement="bottom" title="{{$shift->field1}}">{{$shift->field6}}</td>
            <td>${{$shift->total_period}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
            <tr>
                <th>Studio</th>
                <th>Shift</th>
                <th>Models</th>
                <th>Suport</th>
                <th>Suport in charge</th>
                <th>Arrival Time</th>
                <th>Login Time</th>
                <th>Pre Login Time</th>
                <th>Login Time</th>
                <th>Log off</th>
                <th>Online Time</th>
                <th>Logout Time</th>
                <th>Breaks total time</th>
                <th>Income last logout</th>
                <th>Offline Income</th>
                <th>Room</th>
                <th>Price </th>
                <th>Award points </th>
                <th>Place in Awards</th>
                <th>Average shift Sales</th>
                <th>Total Shift Sales</th>
                <th>Shift/Average</th>
                <th>Total Period Sales</th>
            </tr>
        </tfoot>
</table>

</div>

<div class="col-lg-12" id="timeline" style="background:white;height:50px;padding:0px">

</div>
<div class="col-lg-12" id="time" style="height: 20px;padding: 0px;">
    <div style="height: 2px;width: 33.33%;background:red;display: inline-block;">{{ $yday }}</div>
    <div style="height: 2px;width: 33.1%;background:blue;display: inline-block;"><b>{{ $tday }}</b></div>
    <div style="height: 2px;width: 33%;display: inline-block;background:yellow;">{{ $tmrw }}</div>
</div>


@stop

@section('adminlte_js')

<script>

// buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print'
//         ],

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready( function () {
    $('#table_id').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ],
        initComplete: function () {
            this.api().columns([0]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );


$('#datepicker').datepicker( {
        dateFormat: "yy-mm-dd",
        onSelect: function(date) {
            window.location.href = ( '/admin/shiftreport/'+date);
        }
    });

function getShiftTimeline(modelname){

    let selDate = $('#selectDate').text();

    console.log(modelname);

    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "http://app.studio20.group/admin/ajaxAdminData",
                    method: 'post',
                    data: {modelname: modelname, getshifttimeline: selDate},
                    success: function (html) {
                        //console.log('return: '+html);
                        let len = html.length;
                                                
                        if(len > 0){


                            // for(let i=0; i<len; i++){
                            // let mname = html[i].modelname; 
                            // let sstart = html[i].status_start;
                            // let send = html[i].status_end;
                            // let diff = send - sstart;
                            // let lstat = html[i].last_status;
                            // let rdate = html[i].date;
                            // console.log('return: '+mname);
                            // console.log('return: '+sstart);
                            // console.log('return: '+send);
                            // console.log('return: '+lstat);
                            // console.log('return: '+rdate);
                            // }

                            generateChart(html);
                        }


                    }
                });

}

function generateChart(dataTime){

    let tmline = $("#timeline");

    tmline.empty();

    let daySec = 86400;
    let totalSec = 3 * daySec;

    let selDate = $('#selectDate').text();
    console.log(selDate);

    let today = new Date(selDate+"T00:00:00").getTime()/1000;
    console.log("today: "+today);
    let yday = today - 86400;
    console.log("yday: "+yday);
    let tmorrow = today + 86400;
    console.log("tmorrow: "+tmorrow);
    let tmorrow2 = tmorrow + 86400;
    console.log("tmorrow2 :"+tmorrow2);


    let fElemWidth = ( (dataTime[0].status_start - yday) * 100 ) / totalSec;

    let felem = $('<div/>',{ style:"height:50px;display:inline-block;background:grey;width:"+ fElemWidth +"%;"});

    tmline.append(felem);

    for(let i=1; i<dataTime.length; i++){

        let mname = dataTime[i].modelname; 
        let sstart = dataTime[i].status_start;
        let send = dataTime[i].status_end;
        let diff = send - sstart;
        let lstat = dataTime[i].last_status;
        let rdate = dataTime[i].date;

        let color = 'blue';
        if (lstat == 'offline') color = 'red'; 

        // if ( (i + 1 < dataTime.length) && (today >= sstart) && (today <= dataTime[i+1].status_start) || 
        //     (i + 1 < dataTime.length) && (tmorrow >= sstart) && (tmorrow <= dataTime[i+1].status_start) ) {
        //     let elemWidth = ( (diff - (today - sstart)) * 100 ) / totalSec;
        //     let elem = $('<div/>',{ style:"height:50px;display:inline-block;background:"+color+";width:"+ elemWidth +"%;"});
        //     tmline.append(elem);

        //     elem = $('<div/>',{ style:"height:60px;display:inline-block;background:black;width:2px;"});
        //     tmline.append(elem);

        //     elemWidth = ( (diff - (send - today)) * 100 ) / totalSec;
        //     elem = $('<div/>',{ style:"height:50px;display:inline-block;background:"+color+";width:"+ elemWidth +"%;"});
        //     tmline.append(elem);


        // } else {

            let elemWidth = ( diff * 100 ) / totalSec;
            let dateStart = new Date(sstart * 1000);
            let dateEnd = new Date(send * 1000);

            let elem = $('<div/>',{title: dateStart+' - '+dateEnd, style:"height:50px;display:inline-block;background:"+color+";width:"+ elemWidth +"%;"});

            tmline.append(elem);
        //}
        

        
        console.log("start status :"+lstat + " time : " + sstart);
        console.log("last status :"+lstat + " time : " + send);

    }




}


</script>

@stop
