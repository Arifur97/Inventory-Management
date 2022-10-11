@extends('layout.main')
@section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif

    <div class="dashboard-background-image"></div>
    <div class="row">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="dashboard-text float-left mt-4">
                        <h3>{{Auth::user()->name}}  <span>{{trans('file.dashboard')}}</span></h3>
                    </div>
                    <div class="filter-toggle btn-group">
                        <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d')}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Today')}}</button>
                        <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d', strtotime(' -7 day'))}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Last 7 Days')}}</button>
                        <button class="btn btn-secondary date-btn active" data-start_date="{{date('Y').'-'.date('m').'-'.'01'}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.This Month')}}</button>
                        <button class="btn btn-secondary date-btn" data-start_date="{{date('Y').'-01'.'-01'}}" data-end_date="{{date('Y').'-12'.'-31'}}">{{trans('file.This Year')}}</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Logo Preloader -->
        {{-- <div class="logo-container">
            <span class="spinner"></span>
            <span class="background"></span>
            <img class="logo" src="{{asset('public/images/LogoHeader.png') }}" height="28" />
        </div> --}}


      <!-- Counts Section -->
      <section class="dashboard-counts">
        <div class="container-fluid">
          <div class="row">

          <!-- Above 4 sections-->
          

            <div class="col-md-12 form-group">
              <div class="row">
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center"  style="background: linear-gradient(180deg, #149e8e 2%, #42df90 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-graph-bar" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{ trans('file.revenue') }}</strong></div>
                    <div class="count-number revenue-data">{{number_format((float)$revenue, 2, '.', '')}}</div>
                  </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center" style="background: linear-gradient(180deg, #f8501c 2%, #ffab1d 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-media-loop" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{trans('file.Purchase')}}</strong></div>
                    <div class="count-number purchase_return-data">{{number_format((float)$total_purchase, 2, '.', '')}}</div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center" style="background: linear-gradient(180deg, #892168 2%, #ff3b57 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-return" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{trans('file.Expense')}}</strong></div>
                    <div class="count-number return-data">{{number_format((float)$expense, 2, '.', '')}}</div>
                  </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center" style="background: linear-gradient(180deg, #548af0 2%, #2dc8ed 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-trophy" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{trans('file.Estimated Profit')}}</strong></div>
                    <div class="count-number profit-data">{{number_format((float)$profit_rpe, 2, '.', '')}}</div>
                  </div>
                </div>
              </div>
            </div>

             <!-- Below 4 sections -->

            <div class="col-md-12 form-group mt-2">
              <div class="row">
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center"  style="background: linear-gradient(180deg, #149e8e 2%, #42df90 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-graph-bar" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{ trans('file.revenue') }}</strong></div>
                    <div class="count-number revenue-data">{{number_format((float)$revenue, 2, '.', '')}}</div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center" style="background: linear-gradient(180deg, #892168 2%, #ff3b57 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-return" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{trans('file.Sale Return')}}</strong></div>
                    <div class="count-number return-data">{{number_format((float)$return, 2, '.', '')}}</div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center" style="background: linear-gradient(180deg, #f8501c 2%, #ffab1d 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-media-loop" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{trans('file.Purchase Return')}}</strong></div>
                    <div class="count-number purchase_return-data">{{number_format((float)$purchase_return, 2, '.', '')}}</div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center" style="background: linear-gradient(180deg, #548af0 2%, #2dc8ed 80%); border-radius: 20px 20px 20px 20px">
                    <div class="icon"><i class="dripicons-trophy" style="color: whitesmoke"></i></div>
                    <div class="name"><strong style="color: whitesmoke">{{trans('file.profit')}}</strong></div>
                    <div class="count-number profit-data">{{number_format((float)$profit, 2, '.', '')}}</div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Testing Border effect -->
            {{-- <style type="text/css" media="screen">
                ul, li {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }
                ul {
                    margin: 20px auto;
                    width: 1260px;
                    text-align: center;
                }
                li {
                    display: inline;
                    margin: 0 10px;
                }
            </style>
        <link rel="stylesheet" type="text/css" href="border.css">
        <body>
            <ul>
                <li><img src="wordle.png" alt="" class="glass" /></li>
                <li><img src="wordle.png" alt="" class="aluminium" /></li>
                <li><img src="wordle.png" alt="" class="transparent" /></li>
                <li><img src="wordle.png" alt="" class="red transparent" /></li>
                <li><img src="wordle.png" alt="" class="yellow transparent" /></li>
                <li><img src="wordle.png" alt="" class="green transparent" /></li>
                <li><img src="wordle.png" alt="" class="blue transparent" /></li>
            </ul>
        </body> --}}



        {{-- <link rel="stylesheet" type="text/css" href="border.css"> --}}

        <!-- Cash Flow Card -->

            <div class="col-md-7 mt-4">
              <div class="card line-chart-example">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.Cash Flow')}}</h4>
                </div>

                <div class="card-body">
                  @php
                    if($general_setting->theme == 'default.css'){
                      $color = '#BF1919';
                      $color_rgba = 'rgb(191,25,25)';
                    }
                    elseif($general_setting->theme == 'green.css'){
                        $color = '#5AC18E';
                        $color_rgba = 'rgb(90,193,142)';
                    }
                    elseif($general_setting->theme == 'blue.css'){
                        $color = '#5AC18E';
                        $color_rgba = 'rgb(90,193,142)';
                    }
                    elseif($general_setting->theme == 'dark.css'){
                        $color = '#5AC18E';
                        $color_rgba = 'rgb(90,193,142)';
                    }
                  @endphp
                  <canvas id="cashFlow" data-color = "{{$color}}" data-color_rgba = "{{$color_rgba}}" data-recieved = "{{json_encode($payment_recieved)}}" data-sent = "{{json_encode($payment_sent)}}" data-month = "{{json_encode($month)}}" data-label1="{{trans('file.Payment Recieved')}}" data-label2="{{trans('file.Payment Sent')}}"></canvas>
                </div>

              </div>
            </div>

            <div class="col-md-5 mt-4">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{date('F')}} {{date('Y')}}</h4>
                </div>
                <div class="pie-chart mb-2">
                    <canvas id="transactionChart" data-color = "{{$color}}" data-color_rgba = "{{$color_rgba}}" data-revenue={{$revenue}} data-purchase={{$purchase}} data-expense={{$expense}} data-label1="{{trans('file.Purchase')}}" data-label2="{{trans('file.revenue')}}" data-label3="{{trans('file.Expense')}}" width="100" height="95"> </canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- weekly report -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.weekly report')}}</h4>
                </div>
                <div class="card-body">
                <div>
                  <canvas id="weeklyGraph"></canvas>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script>

          var timeFormat = 'YYYY-MM-DD';

          let today = new Date();
          let todayMinus1 = new Date();
          let todayMinus2 = new Date();
          let todayMinus3 = new Date();
          let todayMinus4 = new Date();
          let todayMinus5 = new Date();
          let todayMinus6 = new Date();

          todayMinus1.setDate(today.getDate() - 1);
          todayMinus2.setDate(today.getDate() - 2);
          todayMinus3.setDate(today.getDate() - 3);
          todayMinus4.setDate(today.getDate() - 4);
          todayMinus5.setDate(today.getDate() - 5);
          todayMinus6.setDate(today.getDate() - 6);
          const labels = [
              today.toLocaleDateString(),
              todayMinus1.toLocaleDateString(),
              todayMinus2.toLocaleDateString(),
              todayMinus3.toLocaleDateString(),
              todayMinus4.toLocaleDateString(),
              todayMinus5.toLocaleDateString(),
              todayMinus6.toLocaleDateString()
          ];

          let weeklyData = {};

          $.ajax({
            url: window.location.href + "/v1/weekly-graph",
            success: function(result){
              let tempWeeklyData = JSON.parse(result);
              weeklyData = Object.values(tempWeeklyData);

              const weeklyGraphData = {
                  labels: labels,
                  datasets: [
                      {
                          label: "Sale",
                          data: weeklyData,
                          backgroundColor: 'rgba(90,193,142, 1)',
                          borderColor: 'rgba(90,193,142, 1)',
                      },
                  ]
              };

              var weeklyGraphConfig = {
                  type: 'bar',
                  data: weeklyGraphData,
                  options: {
                      responsive: true,
                      scales: {
                          yAxes: {
                              beginAtZero: true
                          }
                      }
                  }
              };

              var myChart = new Chart(
                  document.getElementById('weeklyGraph'),
                  weeklyGraphConfig
              );
            }
          });

        </script>

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.yearly report')}}</h4>
                </div>
                <div class="card-body">
                  <canvas id="saleChart" data-sale_chart_value = "{{json_encode($yearly_sale_amount)}}" data-purchase_chart_value = "{{json_encode($yearly_purchase_amount)}}" data-label1="{{trans('file.Purchased Amount')}}" data-label2="{{trans('file.Sold Amount')}}"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Recent Transaction')}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.latest')}} 5</div>
                  </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab">{{trans('file.Sale')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#purchase-latest" role="tab" data-toggle="tab">{{trans('file.Purchase')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#quotation-latest" role="tab" data-toggle="tab">{{trans('file.Quotation')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#payment-latest" role="tab" data-toggle="tab">{{trans('file.Payment')}}</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade show active" id="sale-latest">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th style="border-radius: 5px 0px 0px 5px">{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th style="border-radius: 0px 5px 5px 0px">{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_sale as $sale)
                            <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
                            <tr>
                              <td>{{ date($general_setting->date_format, strtotime($sale->created_at->toDateString())) }}</td>
                              <td>{{$sale->reference_no}}</td>
                              <td>{{$customer->name}}</td>
                              @if($sale->sale_status == 1)
                              <td><div class="badge badge-success">{{trans('file.Completed')}}</div></td>
                              @elseif($sale->sale_status == 2)
                              <td><div class="badge badge-danger">{{trans('file.Pending')}}</div></td>
                              @else
                              <td><div class="badge badge-warning">{{trans('file.Draft')}}</div></td>
                              @endif
                              <td>{{$sale->grand_total}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="purchase-latest">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th style="border-radius: 5px 0px 0px 5px">{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Supplier')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th style="border-radius: 0px 5px 5px 0px">{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_purchase as $purchase)
                            <?php $supplier = DB::table('suppliers')->find($purchase->supplier_id); ?>
                            <tr>
                              <td>{{date($general_setting->date_format, strtotime($purchase->created_at->toDateString())) }}</td>
                              <td>{{$purchase->reference_no}}</td>
                              @if($supplier)
                                <td>{{$supplier->name}}</td>
                              @else
                                <td>N/A</td>
                              @endif
                              @if($purchase->status == 1)
                              <td><div class="badge badge-success">Recieved</div></td>
                              @elseif($purchase->status == 2)
                              <td><div class="badge badge-success">Partial</div></td>
                              @elseif($purchase->status == 3)
                              <td><div class="badge badge-danger">Pending</div></td>
                              @else
                              <td><div class="badge badge-danger">Ordered</div></td>
                              @endif
                              <td>{{$purchase->grand_total}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="quotation-latest">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th style="border-radius: 5px 0px 0px 5px">{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th style="border-radius: 0px 5px 5px 0px">{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_quotation as $quotation)
                            <?php $customer = DB::table('customers')->find($quotation->customer_id); ?>
                            <tr>
                              <td>{{date($general_setting->date_format, strtotime($quotation->created_at->toDateString())) }}</td>
                              <td>{{$quotation->reference_no}}</td>
                              <td>{{$customer->name}}</td>
                              @if($quotation->quotation_status == 1)
                              <td><div class="badge badge-danger">Pending</div></td>
                              @else
                              <td><div class="badge badge-success">Sent</div></td>
                              @endif
                              <td>{{$quotation->grand_total}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="payment-latest">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th style="border-radius: 5px 0px 0px 5px">{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Amount')}}</th>
                              <th style="border-radius: 0px 5px 5px 0px">{{trans('file.Paid By')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_payment as $payment)
                            <tr>
                              <td>{{date($general_setting->date_format, strtotime($payment->created_at->toDateString())) }}</td>
                              <td>{{$payment->payment_reference}}</td>
                              <td>{{$payment->amount}}</td>
                              <td>{{$payment->paying_method}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Best Seller').' '.date('F')}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.top')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="border-radius: 5px 0px 0px 5px">{{trans('file.SL No')}}</th>
                          <th>{{trans('file.Product Details')}}</th>
                          <th style="border-radius: 0px 5px 5px 0px">{{trans('file.qty')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($best_selling_qty as $key=>$sale)
                        <?php $product = DB::table('products')->find($sale->product_id); ?>
                        <tr>
                          <td>{{$key + 1}}</td>
                          <td>{{$product->name}}<br>[{{$product->code}}]</td>
                          <td>{{$sale->sold_qty}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Best Seller').' '.date('Y'). '('.trans('file.qty').')'}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.top')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="border-radius: 5px 0px 0px 5px">{{trans('file.SL No')}}</th>
                          <th>{{trans('file.Product Details')}}</th>
                          <th style="border-radius: 0px 5px 5px 0px">{{trans('file.qty')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($yearly_best_selling_qty as $key => $sale)
                        <?php $product = DB::table('products')->find($sale->product_id); ?>
                        <tr>
                          <td>{{$key + 1}}</td>
                          <td>{{$product->name}}<br>[{{$product->code}}]</td>
                          <td>{{$sale->sold_qty}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Best Seller').' '.date('Y') . '('.trans('file.price').')'}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.top')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="border-radius: 5px 0px 0px 5px">{{trans('file.SL No')}}</th>
                          <th>{{trans('file.Product Details')}}</th>
                          <th style="border-radius: 0px 5px 5px 0px">{{trans('file.grand total')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($yearly_best_selling_price as $key => $sale)
                        <?php $product = DB::table('products')->find($sale->product_id); ?>
                        <tr>
                          <td>{{$key + 1}}</td>
                          <td>{{$product->name}}<br>[{{$product->code}}]</td>
                          <td>{{number_format((float)$sale->total_price, 2, '.', '')}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </div>

      </section>


<script type="text/javascript">
    // Show and hide color-switcher
    $(".color-switcher .switcher-button").on('click', function() {
        $(".color-switcher").toggleClass("show-color-switcher", "hide-color-switcher", 300);
    });

    // Color Skins
    $('a.color').on('click', function() {
        /*var title = $(this).attr('title');
        $('#style-colors').attr('href', 'css/skin-' + title + '.css');
        return false;*/
        $.get('setting/general_setting/change-theme/' + $(this).data('color'), function(data) {
        });
        var style_link= $('#custom-style').attr('href').replace(/([^-]*)$/, $(this).data('color') );
        $('#custom-style').attr('href', style_link);
    });

    $(".date-btn").on("click", function() {
        $(".date-btn").removeClass("active");
        $(this).addClass("active");
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        $.get('dashboard-filter/' + start_date + '/' + end_date, function(data) {
            dashboardFilter(data);
        });
    });

    function dashboardFilter(data){
        $('.revenue-data').hide();
        $('.revenue-data').html(parseFloat(data[0]).toFixed(2));
        $('.revenue-data').show(500);

        $('.return-data').hide();
        $('.return-data').html(parseFloat(data[1]).toFixed(2));
        $('.return-data').show(500);

        $('.profit-data').hide();
        $('.profit-data').html(parseFloat(data[2]).toFixed(2));
        $('.profit-data').show(500);

        $('.purchase_return-data').hide();
        $('.purchase_return-data').html(parseFloat(data[3]).toFixed(2));
        $('.purchase_return-data').show(500);
    }
</script>
@endsection
