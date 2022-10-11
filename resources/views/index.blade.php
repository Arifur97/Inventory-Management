@extends('layout.main')
@section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('clock_out'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('clock_out') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<body>
    <div class="background-image"></div>
    <br>
    <br>
    <div class="container-fluid">
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="float-left dashboard-text">
                    <h3>{{trans('file.welcome')}} <span>{{Auth::user()->name}}</span> </h3>
                </div>
            </div>
        </div>
    </div>

    <!--- Inventory section -->
    <section class="dashboard-counts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 form-group">
                    <div class="row">
                        <!-- Count item widget-->
                        <div class="col-md-6">
                            <div class="colored-box">
                                <i class="fa fa-clock-o main-icon" @if ($lastAttendance->status == 2 ) style="color: #16d39a" @else style="color: #ff3b57" @endif></i>
                                <h3>{{trans('file.Clock In/Out')}}</h3>
                                <hr>
                                <div class="wrapper col-md-12">
                                    @if ($lastAttendance->status == 2)
                                        <a href="{{ route('attendance.checkin') }}" class="float-right btn btn-outline-clock" ><i class="fa fa-sign-in mr-1" aria-hidden="true"></i> {{trans('file.Clock-In')}}</a>
                                        <p class="clock-text">Last clock-out at:
                                            <span class="d-block checkin-time"> {{ $lastAttendance->checkout }}</span>
                                            <span class="d-block">{{ date('d-m-Y', strtotime($lastAttendance->date)) }}</span>
                                        </p>
                                    @else
                                        <button type="button" class="float-right btn btn-outline-clock-out" data-toggle="modal" data-target="#attendanceCheckoutModal"><i class="fa fa-sign-out mr-1" aria-hidden="true"></i>
                                            {{trans('file.Clock-Out')}}
                                        </button>
                                        <p class="clock-out-text">Last clock-in at:
                                            <span class="d-block checkout-time">{{ $lastAttendance->checkin }}</span>
                                            <span class="d-block">{{ date('d-m-Y', strtotime($lastAttendance->date)) }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="colored-box">
                                <i class="fa fa-star main-icon"></i>
                                <h3>{{trans('file.Shortcuts')}}</h3>
                                <hr>
                                <div class="mt-3">
                                  @foreach ($form_name_data as $formName)
                                    <a href="{{ $formName->form_link }}" title="{{ $formName->name }}" target="_blank" class="btn btn-primary mr-2"><i class="{{ $formName->icon }} mr-1"></i> {{ $formName->name }}</a>
                                  @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="colored-box">
                                <i class="fa fa-phone main-icon"></i>
                                <h3>{{trans('file.Contacts')}}</h3>
                                <hr>
                                <div class="mt-3"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="colored-box">
                                <i class="fa fa-bullhorn main-icon"></i>
                                <h3>{{trans('file.Announcements')}}</h3>
                                <hr>
                                <div class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="colored-box">
                                <i class="fa fa-calendar main-icon"></i>
                                <h3>{{trans('file.Calendar')}}</h3>
                                <hr>
                                <div class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="colored-box colored-box-2">
                                <i class="fa fa-tasks main-icon"></i>
                                <h3>{{trans('file.Tasks')}}</h3>
                                <hr>
                                <div class="mt-3">
                                    <div class="table-responsive">
                                        <table id="home_task-table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>{{trans('file.Date')}}</th>
                                                    <th>{{trans('file.Title')}}</th>
                                                    <th>{{trans('file.Employee')}}</th>
                                                    <th>{{trans('file.Status')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lims_task_list as $key=>$task)
                                                <tr>
                                                    <td>{{ date('d-M-y', strtotime($task->date)) ?? "" }}</td>
                                                    <td>{{ $task->title ?? "" }}</td>
                                                    <td>{{ $task->employee->name ?? "" }}</td>
                                                    @if($task->status == 0)
                                                        <td><div class="badge badge-danger">{{trans('file.Draft')}}</div></td>
                                                    @elseif($task->status == 1)
                                                        <td><div class="badge badge-bule">{{trans('file.In Process')}}</div></td>
                                                    @elseif($task->status == 2)
                                                        <td><div class="badge badge-success">{{trans('file.Completed')}}</div></td>
                                                    @else
                                                        <td><div class="badge badge-success">{{trans('file.Completed')}}</div></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--- attendence modal --->
    <div class="modal fade" id="attendanceCheckoutModal" tabindex="-1" role="dialog" aria-labelledby="attendanceCheckoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="attendanceCheckoutModalLabel">Clock-Out</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('attendance.checkout') }}" method="post">
                @csrf
                <div class="form-group">
                  <label>Note:</label>
                  <textarea name="note" rows="3" class="form-control"></textarea>
                </div>
                <div class="form-group float-right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>

   <!--- sales section --->

<style>
    .colored-box-2 .table-responsive{
        overflow-x: hidden!important;
        overflow-y: auto!important;
    }
    .colored-box-2 .pagination,
    .colored-box-2 .dataTables_info,
    .colored-box-2 #home_task-table_length label{
        display: none!important;
    }
    #home_task-table_wrapper .col-md-6:first-child{
       display: none;
    }
    #home_task-table_wrapper .col-md-6{
        max-width: 100%!important;
        margin: auto!important;
    }
    #home_task-table_wrapper{
        padding: 0!important;
        margin: 0!important;
    }
    #home_task-table{
        margin-top: 0!important;
    }
</style>

<script>
     $('#home_task-table').DataTable( {

    } );
</script>

</body>

@endsection
