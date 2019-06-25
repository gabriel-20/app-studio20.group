@extends('adminlte::page')

@section('title', 'Time Schedule')

@section('content_header')
    <h1>Time Schedule</h1>
@stop



@section('content')

<h2>{{ $trainer->name }}</h2>
<h4>{{ $trainer->shiftName }}</h4>


<div>
    <button class="btn btn-default" onclick="draw(0);">Saptamana Para</button>
    <button class="btn btn-default" onclick="draw(1);">Saptamana Impara</button>
    <button class="btn btn-default" onclick="changeday_night(0);">Day</button>
    <button class="btn btn-default" onclick="changeday_night(1);">Night</button>
</div>

        <table id="mytable" class="table">
                      
        
        </table>

<div><button class="col-lg-3 btn-info btn" onclick="save();"> Save</button></div>
@stop




@section('adminlte_js')
<script>

let table = $('#mytable');
let days = ["Luni","Marti","Miercuri","Joi","Vineri","Sambata","Duminica"];
let hours = 19;
let days1 = ["Luni","Marti","Sambata","Duminica"];
let days2 = ["Miercuri","Joi","Vineri"];
let thead;
let ddn = 0;
let week = 0;


    function draw(mweek){
        week = mweek;
        table.empty();

        let tbody = $('<tbody>',{});
        let mydays = [];
        if (mweek == 0) mydays = days1;
        else mydays = days2;
        
            days.forEach(function(day) {
            let tr = $('<tr>',{});
            let tdh = $('<td>',{text:day});

            tr.append(tdh);
            for(i = 0; i < hours; i++){
                let style = "background:magenta";
                if ( (i < 1) || (i > 12) || (mydays.includes(day)) ) style = "background:white";
                
                let tdc = $('<td>',{text:'', style:style});
                tr.append(tdc);
            }
            
            tbody.append(tr);

        });

        table.append(thead);
        table.append(tbody);




    }

    $(document).ready(function() {
        changeday_night(1);
        draw(0);

    } );

    function changeday_night(daynight){
        ddn = daynight;
        if (daynight)     thead = "<thead><tr><th></th><th>06:00</th><th>07:00</th><th>08:00</th><th>09:00</th><th>10:00</th><th>11:00</th><th>12:00</th><th>13:00</th><th>14:00</th><th>15:00</th><th>16:00</th><th>17:00</th><th>18:00</th><th>19:00</th><th>20:00</th><th>21:00</th><th>22:00</th><th>23:00</th><th>24:00</th></tr></thead>";
            else     thead = "<thead><tr><th></th><th>18:00</th><th>19:00</th><th>20:00</th><th>21:00</th><th>22:00</th><th>23:00</th><th>24:00</th><th>01:00</th><th>02:00</th><th>03:00</th><th>04:00</th><th>05:00</th><th>06:00</th><th>07:00</th><th>08:00</th><th>09:00</th><th>10:00</th><th>11:00</th><th>12:00</th></tr></thead>";

    }

    function save(){

        let id = '{{ $trainer->id }}';
        let shift_value = week + '' + ddn;
        console.log(shift_value);

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "../ajaxAdminData",
                    method: 'post',
                    data: {trainer_id: id, shift: shift_value},
                    success: function (html) {
                        console.log('return: '+html);
                        if (html == 'success') alert('Models updated successfully!');
                        else alert('Something went wrong..');
                    }
                });


    }


</script>
@stop


