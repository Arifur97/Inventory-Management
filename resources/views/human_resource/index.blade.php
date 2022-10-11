@extends('layout.main')
@section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif


<body>
    <div class="background-image">
    </div>
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

        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-md-4">

                    <div class="colored-box">
                        
                        {{-- <div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;">
                            <div class="mCSB_draggerContainer">
                                <div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; height: 234px; top: 0px; display: block; max-height: 491px;">
                                    <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                </div>
                                <div class="mCSB_draggerRail"></div>

                            </div>
                        </div> --}}

                        <i class="fa fa-clock-o"></i>
                        <h3>{{trans('file.Time Attendance')}}</h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2">{{trans('file.Clock In Date')}} <span class="float-right"> 1</span></p>
                            <p class="mt-2">{{trans('file.Clock In Time')}} <span class="float-right">2</span></p>
                            <p class="mt-2">{{trans('file.Clock Out Date')}} <span class="float-right">3</span></p>
                            <p class="mt-2">{{trans('file.Clock Out Time')}} <span class="float-right">4</span></p>
                            <p class="mt-2">{{trans('file.Hours')}} <span class="float-right">4</span></p>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="colored-box">
                        <i class="fa fa-bullhorn"></i>
                        <h3>{{trans('file.Announcements')}}</h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> 1</span></p>
                            <p class="mt-2">{{trans('file.Sale')}} <span class="float-right">2</span></p>
                            <p class="mt-2">{{trans('file.Paid')}} <span class="float-right">3</span></p>
                            <p class="mt-2">{{trans('file.Tax')}} <span class="float-right">4</span></p>
                            <p class="mt-2">{{trans('file.Discount')}} <span class="float-right">5</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="colored-box">
                        <i class="fa fa-address-book-o"></i>
                        <h3>{{trans('file.Extensions')}}</h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> 1</span></p>
                            <p class="mt-2">{{trans('file.Sale')}} <span class="float-right">2</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="colored-box">
                        <i class="fa fa-tasks"></i>
                        <h3>{{trans('file.Pending Tasks')}}</h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> 1</span></p>
                            <p class="mt-2">{{trans('file.Sale')}} <span class="float-right">2</span></p>
                            <p class="mt-2">{{trans('file.Paid')}} <span class="float-right">3</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="colored-box">
                        <i class="fa fa-random"></i>
                        <h3>{{trans('file.Workflow Tasks')}}</h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> 1</span></p>
                            <p class="mt-2">{{trans('file.Sale')}} <span class="float-right">2</span></p>
                            <p class="mt-2">{{trans('file.Paid')}} <span class="float-right">3</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="colored-box">
                        <i class="fa fa-bell-o"></i>
                        <h3>{{trans('file.Reminders')}}</h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> 1</span></p>
                            <p class="mt-2">{{trans('file.Sale')}} <span class="float-right">2</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

@endsection