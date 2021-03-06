@extends('layouts.master')
@section('style')
    <link href="{{ URL::asset('/css/bootstrap-datepicker.css')}}" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
        </div>
    @endif
    @if (Session::get('noresult'))
        <div class="alert alert-warning">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>{{ Session::get('noresult')}}</strong>

        </div>
    @endif
    @if (isset($noResult))
        <div class="alert alert-warning">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>{{$noResult['noresult']}}</strong>

        </div>
    @endif



    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> Attendance List</h2>

                </div>
                <div class="box-content">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form role="form" action="{{url('/attendance/list')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="class">Class</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>

                                            @if(isset($classes2))
                                                {{ Form::select('class',$classes2,$formdata->class,['class'=>'form-control','id'=>'class','required'=>'true'])}}
                                            @else


                                                <select id="class" id="class" name="class" required="true" class="form-control" >
                                                    @foreach($classes as $class)
                                                        <option value="{{$class->code}}">{{$class->name}}</option>
                                                    @endforeach

                                                </select>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="section">Section</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <?php  $data=[
                                                    'A'=>'A',
                                                 
                                            ];?>
                                            {{ Form::select('section',$data,$formdata->section,['class'=>'form-control','id'=>'section','required'=>'true'])}}


                                        </div>
                                    </div>
                                </div>

                               <?php /* <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="shift">Shift</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <?php  $data=[
                                                    'Day'=>'Day',
                                                    'Morning'=>'Morning'
                                            ];?>
                                            {{ Form::select('shift',$data,$formdata->shift,['class'=>'form-control','id'=>'shift','required'=>'true'])}}


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> */ ?>
                        <div class="row">
                            <div class="col-md-12">
                                {{--<div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="session">session</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text" id="session" required="true" class="form-control datepicker2" name="session" value="{{$formdata->session}}"   data-date-format="yyyy">
                                        </div>
                                    </div>
                                </div>--}}

                                <input type="hidden" id="session"  class="form-control " name="session" value="{{get_current_session()->id}}"   data-date-format="yyyy">


                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="dob">Date</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text"  id="date" class="form-control datepicker" name="date" required  data-date-format="dd-mm-yyyy" value="{{$formdata->date}}">
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                <button class="btn btn-primary" id="btnPrint"  type="button"><i class="glyphicon glyphicon-print"></i>Print List</button>
                               &nbsp;
                                <button class="btn btn-primary"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
                              </div>
                            </div>
                        </div>
                    </form>
                    @if($attendance)
                        <div class="row">
                            <div class="col-md-12">
                                <table id="attendanceList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Regi No</th>
                                        <th>Roll No</th>
                                        <th>Name</th>
                                        <th>Is Present</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($attendance as $atd)
                                        <tr>
                                            <td>{{$atd->regiNo}}</td>
                                            <td>{{$atd->rollNo}}</td>
                                            <td>{{$atd->firstName}} {{$atd->middleName}} {{$atd->lastName}}</td>
                                            <td>
                                              @if($atd->status=="Present")
                                              <span class="text-success">Present</span>
                                              @else

                                              <span class="text-danger">Absent</span>

                                              @endif
                                            </td>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{ URL::asset('/js/bootstrap-datepicker.js')}}"></script>
     <script type="text/javascript">
        $( document ).ready(function() {

               getsections();
              $('#class').on('change',function() {
                getsections();
              });
            $(".datepicker2").datepicker( {
                format: " yyyy", // Notice the Extra space at the beginning
                viewMode: "years",
                minViewMode: "years",
                autoclose:true

            });
            $(".datepicker").datepicker({
                autoclose:true,
                todayHighlight: true

            });

            $('#attendanceList').dataTable({

                 //pagingType: "simple",
                //"pageLength": 5,
              //  "pagingType": "full_numbers",
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ],
                 "sPaginationType": "bootstrap",
            });

            $( "#btnPrint" ).click(function() {
                var aclass  =   $('#class').val();
                var section =   $('#section').val();
                //var shift = $('#shift').val();
                var shift   = 'Morning';
                var session = $('#session').val().trim();
                var subject = $('#subject').val();
                var atedate = $('#date').val().trim();

                if(aclass!="" && section !="" && shift !="" && session !="" && atedate!="")
                {

                   var exurl="{{url('/attendance/printlist')}}"+'/'+aclass+'/'+section+'/'+shift+'/'+session+'/'+atedate;

                    var win = window.open(exurl, '_blank');
                    win.focus();

                }
                else
                {
                    alert('Not valid');
                }
            });

        });


function getsections()
{
    var aclass = $('#class').val();
   // alert(aclass);
    $.ajax({
      url: "{{url('/section/getList')}}"+'/'+aclass,
      data: {
        format: 'json'
      },
      error: function(error) {
        alert("Please fill all inputs correctly!");
      },
      dataType: 'json',
      success: function(data) {
        $('#section').empty();
       //$('#section').append($('<option>').text("--Select Section--").attr('value',""));
        $.each(data, function(i, section) {
          //console.log(student);
         
          
            var opt="<option value='"+section.id+"'>"+section.name + " </option>"

        
          //console.log(opt);
          $('#section').append(opt);

        });
        //console.log(data);

      },
      type: 'GET'
    });
};

    </script>
@stop
