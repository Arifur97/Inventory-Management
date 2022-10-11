<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @if($userGeneralSetting->company->favicon??false)
        <link rel="icon" type="image/png" href="{{ url('/companies/favicon', $userGeneralSetting->company->favicon) }}" />
    @elseif ($general_setting->site_logo)
        <link rel="icon" type="image/png" href="{{url('/icon', $general_setting->site_icon)}}" />
    @endif
    @if($userGeneralSetting->company->name??false)
        <title>{{$userGeneralSetting->company->name}} - InfinityERP</title>
    @elseif ($general_setting->site_title)
        <title>{{$general_setting->site_title}}</title>
    @endif

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/vendor/bootstrap/css/bootstrap-datepicker.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/vendor/jquery-timepicker/jquery.timepicker.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/vendor/bootstrap/css/awesome-bootstrap-checkbox.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/vendor/bootstrap/css/bootstrap-select.min.css') ?>" type="text/css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo asset('/vendor/font-awesome/css/font-awesome.min.css') ?>" type="text/css">
    <!-- Drip icon font-->
    <link rel="stylesheet" href="<?php echo asset('/vendor/dripicons/webfont.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?php echo asset('/css/grasp_mobile_progress_circle-1.0.0.min.css') ?>" type="text/css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?php echo asset('/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') ?>" type="text/css">
    <!-- virtual keybord stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('/vendor/keyboard/css/keyboard.css') ?>" type="text/css">
    <!-- date range stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('/vendor/daterange/css/daterangepicker.min.css') ?>" type="text/css">
    <!-- table sorter stylesheet-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/vendor/datatable/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo asset('/css/style.default.css') ?>" id="theme-stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/css/dropzone.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('/css/style.css') ?>">

    <script type="text/javascript" src="<?php echo asset('/vendor/jquery/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/jquery/jquery-ui.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/jquery/bootstrap-datepicker.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/jquery/jquery.timepicker.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/popper.js/umd/popper.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/keyboard/js/jquery.keyboard.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/keyboard/js/jquery.keyboard.extension-autocomplete.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/js/grasp_mobile_progress_circle-1.0.0.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/jquery.cookie/jquery.cookie.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/chart.js/Chart.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo asset('/js/charts-custom.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/js/front.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/daterange/js/moment.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/daterange/js/knockout-3.4.2.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/daterange/js/daterangepicker.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/js/dropzone.js') ?>"></script>

    <!-- table sorter js-->
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/pdfmake.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/vfs_fonts.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/dataTables.bootstrap4.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/dataTables.buttons.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/buttons.bootstrap4.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/buttons.colVis.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/buttons.html5.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/buttons.print.min.js') ?>"></script>

    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/sum().js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/vendor/datatable/dataTables.checkboxes.min.js') ?>"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('/css/custom-'.$general_setting->theme) ?>" type="text/css" id="custom-style">
</head>

  <body onload="myFunction()">
    <div id="loader"></div>
      <!-- Side Navbar -->
      <nav class="side-navbar">
        <div class="side-navbar-wrapper">
          <!-- Sidebar Header    -->
          <!-- Sidebar Navigation Menus-->
          <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">
              <li><a href="{{url('/')}}"> <i class="fa fa-home" aria-hidden="true"></i><span>{{ __('file.home') }}</span></a></li>

              <li class=""><a href="#dashboardmenu" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-meter" aria-hidden="true"></i><span>{{trans('file.dashboard')}}</span></a>
                <ul id="dashboardmenu" class="collapse list-unstyled ">
                  <li>
                      <a href="#managmentmenu" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-globe" aria-hidden="true"></i><span>{{trans('file.Management')}}</span>
                      </a>
                        <ul id="managmentmenu" class="collapse list-unstyled ">
                          <li id="management-menu"><a href="{{route('dashboard.index')}}">{{trans('file.Management')}}</a></li>
                          <li id="profit-loss-report-menu">
                              {!! Form::open(['route' => 'report.profitLoss', 'method' => 'post', 'id' => 'profitLoss-report-form']) !!}
                              <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                              <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                              <a id="profitLoss-link" href="">{{trans('file.Summary Report')}}</a>
                              {!! Form::close() !!}
                          </li>
                        </ul>
                  </li>
                  <li>
                      <a href="#hrmenu" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-globe" aria-hidden="true"></i><span>{{trans('file.Human Resource')}}</span>
                      </a>
                      <ul id="hrmenu" class="collapse list-unstyled ">
                        <li id="hr-menu"><a href="{{route('human_resource.index')}}">{{trans('file.HR Dashboard')}}</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="#inventorymenu" aria-expanded="false" data-toggle="collapse">
                          <i class="dripicons-list" aria-hidden="true"></i><span>{{trans('file.Inventory')}}</span>
                      </a>
                        <ul id="inventorymenu" class="collapse list-unstyled ">
                          <li id="warehouse-stock-report-menu">
                            <a href="{{route('report.warehouseStock')}}">{{trans('file.Warehouse Stock Chart')}}</a>
                          </li>
                          <li id="best-seller-report-menu">
                              <a href="{{url('report/best_seller')}}">{{trans('file.Best Seller')}}</a>
                          </li>
                        </ul>
                  </li>

                  <li>
                      <a href="#productionmenu" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-cogs" aria-hidden="true"></i><span>{{trans('file.Production')}}</span>
                      </a>
                        <ul id="productionmenu" class="collapse list-unstyled ">
                            <li id="work-order-menu"><a href="{{route('workorder.index')}}">{{trans('file.Work Order')}}</a></li>
                        </ul>
                  </li>

                  {{-- <li id="sale-menu"><a href="#">{{trans('file.Sale')}}</a></li>
                  <li id="purchase-menu"><a href="#">{{trans('file.Purchase')}}</a></li>
                  <li id="inventory-menu"><a href="#">{{trans('file.Inventory')}}</a></li> --}}

                </ul>
              </li>


               <?php
                  $role = DB::table('roles')->find(Auth::user()->role_id);
                  $category_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'category'],
                        ['role_id', $role->id] ])->first();
                  $index_permission = DB::table('permissions')->where('name', 'products-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();

                  $print_barcode = DB::table('permissions')->where('name', 'print_barcode')->first();
                      $print_barcode_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $print_barcode->id],
                          ['role_id', $role->id]
                      ])->first();

                  $stock_count = DB::table('permissions')->where('name', 'stock_count')->first();
                      $stock_count_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $stock_count->id],
                          ['role_id', $role->id]
                      ])->first();

                    $adjustment = DB::table('permissions')->where('name', 'adjustment')->first();
                    $adjustment_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $adjustment->id],
                        ['role_id', $role->id]
                    ])->first();
              ?>
              @if($category_permission_active || $index_permission_active || $print_barcode_active || $stock_count_active || $adjustment_active)

            <!--  Inventory start -->

            @if($category_permission_active || $index_permission_active || $print_barcode_active || $stock_count_active || $adjustment_active)
            <li><a href="#product" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-list"></i><span>{{__('file.Inventory')}}</span><span></a>
              <ul id="product" class="collapse list-unstyled ">

                  <!-- Product Sub menu -->
                  @if($index_permission_active)
                  <li>
                      <a href="#productMenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-diamond" aria-hidden="true"></i><span>{{trans('file.product')}}</span>
                    </a>
                        <ul id="productMenu" class="collapse list-unstyled ">
                          <li id="product-list-menu"><a href="{{route('products.index')}}">{{__('file.product_list')}}</a></li>
                              @if($index_permission_active)

                              <?php
                                  $add_permission = DB::table('permissions')->where('name', 'products-add')->first();
                                  $add_permission_active = DB::table('role_has_permissions')->where([
                                      ['permission_id', $add_permission->id],
                                      ['role_id', $role->id]
                                  ])->first();
                              ?>
                              <!--
                              @if($add_permission_active)
                              <li id="product-create-menu"><a href="{{route('products.create')}}">{{__('file.add_product')}}</a></li>
                              @endif
                              --!>
                              @endif
                              <!--
                              @if($category_permission_active)
                              <li id="category-menu"><a href="{{route('category.index')}}">{{__('file.category')}}</a></li>
                              @endif
                              --!>
                            @if($print_barcode_active)
                            <li id="printBarcode-menu"><a href="{{route('product.printBarcode')}}">{{__('file.print_barcode')}}</a></li>
                            @endif
                        </ul>
                </li>
                @endif

                <!-- End of Product Sub menu -->

                <!-- Stock Sub Menu -->

                  @if($index_permission_active)
                  <li>
                      <a href="#stockMenu" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-cubes" aria-hidden="true"></i><span>{{trans('file.stock')}}</span>
                      </a>
                        <ul id="stockMenu" class="collapse list-unstyled ">
                          @if($index_permission_active)
                          <li id="transfer-list-menu"><a href="{{route('transfers.index')}}">{{trans('file.Transfer List')}}</a></li>
                          @endif
                          @if($adjustment_active)
                          <li id="adjustment-list-menu"><a href="{{route('qty_adjustment.index')}}">{{trans('file.Adjustment List')}}</a></li>

                          <li id="shelflocation-create-menu"><a href="{{route('product.shelf_location')}}">{{trans('file.Shelf Location')}}</a></li>

                          @endif
                          @if($stock_count_active)
                              <li id="stock-count-menu"><a href="{{route('stock-count.index')}}">{{trans('file.Stock Count')}}</a></li>
                          @endif
                      </ul>
                  </li>
                  @endif

              <li>
                <a href="#itemrequirementmenu" aria-expanded="false" data-toggle="collapse">
                  <i class="dripicons-document"></i><span>{{trans('file.Item Requirement')}}</span>
                </a>
                  <ul id="itemrequirementmenu" class="collapse list-unstyled ">
                    <li id="item-requirement-menu"><a href="{{route('item_requirement.index')}}">{{trans('file.Item Requirement')}}</a></li>
                </ul>
              </li>

                  <?php
                      $brand_permission = DB::table('permissions')->where('name', 'brand')->first();
                      $brand_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $brand_permission->id],
                                  ['role_id', $role->id]
                              ])->first();
                      $unit_permission = DB::table('permissions')->where('name', 'unit')->first();
                      $unit_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $unit_permission->id],
                                  ['role_id', $role->id]
                              ])->first();
                  ?>

                  <!-- Transfer Sub menu -->
                          @if($index_permission_active)
                          <li>
                              <a href="#transfer" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span></a>
                                  <ul id="transfer" class="collapse list-unstyled ">
                                    @if($category_permission_active)
                                    <li id="category-menu"><a href="{{route('category.index')}}">{{__('file.category')}}</a></li>
                                    @endif
                                    @if($brand_permission_active)
                                    <li id="brand-menu"><a href="{{route('brand.index')}}">{{trans('file.Brand')}}</a></li>
                                    @endif
                                    @if($unit_permission_active)
                                    <li id="unit-menu"><a href="{{route('unit.index')}}">{{trans('file.Unit')}}</a></li>
                                    <!--  color menu  -->
                                    <li id="color-menu"><a href="{{route('color.index')}}">{{trans('file.Colors')}}</a></li>
                                    <!--  size menu  -->
                                    <li id="size-menu"><a href="{{route('size.index')}}">{{trans('file.Sizes')}}</a></li>
                                    @endif
                                    <!--
                                      <li id="transfer-list-menu"><a href="{{route('transfers.index')}}">{{trans('file.Transfer List')}}</a></li>
                                      <?php
                                          $add_permission = DB::table('permissions')->where('name', 'transfers-add')->first();
                                          $add_permission_active = DB::table('role_has_permissions')->where([
                                              ['permission_id', $add_permission->id],
                                              ['role_id', $role->id]
                                          ])->first();
                                      ?>
                                      @if($add_permission_active)
                                      <li id="transfer-create-menu"><a href="{{route('transfers.create')}}">{{trans('file.Add Transfer')}}</a></li>
                                      <li id="transfer-import-menu"><a href="{{url('transfers/transfer_by_csv')}}">{{trans('file.Import Transfer By CSV')}}</a></li>
                                      @endif
                                    --!>
                                  </ul>
                          </li>
                  @endif

                  <!-- End of Transfer Sub menu -->




              </ul>
            </li>
            @endif

            <!-- end inventory -->
            @endif


              <!-- Purchase Menu Start -->
              <?php
                $index_permission = DB::table('permissions')->where('name', 'purchases-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $index_permission->id],
                        ['role_id', $role->id]
                    ])->first();

              ?>
              @if($index_permission_active)
              <li><a href="#purchase" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-credit-card" aria-hidden="true"></i><span>{{trans('file.Purchase')}}</span></a>
                <ul id="purchase" class="collapse list-unstyled ">

                    <li>
                        <a href="#suppliermenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-address-book" aria-hidden="true"></i><span>{{trans('file.Supplier')}}</span>
                        </a>
                          <ul id="suppliermenu" class="collapse list-unstyled ">
                            @if($index_permission_active)
                            <li id="supplier-list-menu"><a href="{{route('supplier.index')}}">{{trans('file.Supplier List')}}</a></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                      <a href="#purchasecontact" aria-expanded="false" data-toggle="collapse">
                        <i class="dripicons-document" aria-hidden="true"></i><span>{{trans('file.Purchase Contract')}}</span>
                      </a>
                        <ul id="purchasecontact" class="collapse list-unstyled ">
                          <li id="sale-contact-menu"><a href="#">{{trans('file.Purchase Contract')}}</a></li>
                      </ul>
                    </li>

                    <li>
                        <a href="#purchasesubmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-credit-card" aria-hidden="true"></i><span>{{trans('file.Purchase')}}</span>
                        </a>
                          <ul id="purchasesubmenu" class="collapse list-unstyled ">
                            @if($index_permission_active)
                            <li id="supplier-list-menu"><a href="{{route('purchases.index')}}">{{trans('file.Purchase List')}}</a></li>
                            @endif
                            @if($index_permission_active)
                            <li id="supplier-list-menu"><a href="{{route('purchase_receiving.index')}}">{{trans('file.Receiving List')}}</a></li>
                            @endif
                        </ul>
                    </li>

                  <?php
                    $add_permission = DB::table('permissions')->where('name', 'purchases-add')->first();
                    $add_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $add_permission->id],
                        ['role_id', $role->id]
                    ])->first();
                  ?>

                  <!-- Purchase Menu End -->

                    <?php
                        $sale_return_index_permission = DB::table('permissions')->where('name', 'returns-index')->first();

                        $sale_return_index_permission_active = DB::table('role_has_permissions')->where([
                                ['permission_id', $sale_return_index_permission->id],
                                ['role_id', $role->id]
                            ])->first();

                        $purchase_return_index_permission = DB::table('permissions')->where('name', 'purchase-return-index')->first();

                        $purchase_return_index_permission_active = DB::table('role_has_permissions')->where([
                                    ['permission_id', $purchase_return_index_permission->id],
                                    ['role_id', $role->id]
                                ])->first();
                    ?>

              @if($sale_return_index_permission_active || $purchase_return_index_permission_active)
              <li><a href="#return" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-return"></i><span>{{trans('file.return')}}</span></a>
                <ul id="return" class="collapse list-unstyled ">
                  @if($purchase_return_index_permission_active)
                  <li id="purchase-return-menu"><a href="{{route('return-purchase.index')}}">{{trans('file.Purchase Return')}}</a></li>
                  @endif
                </ul>
              </li>
              @endif

              <li>
                <a href="#requestquotation" aria-expanded="false" data-toggle="collapse">
                  <i class="dripicons-document"></i><span>{{trans('file.RFQ')}}</span>
                </a>
                  <ul id="requestquotation" class="collapse list-unstyled ">
                    <li id="requestquotation-menu"><a href="{{route('quotation_supplier.index')}}">{{trans('file.RFQ')}}</a></li>
                </ul>
              </li>
              <li>
                <a href="#quotationsubmenu" aria-expanded="false" data-toggle="collapse">
                  <i class="dripicons-document"></i><span>{{trans('file.Quotation')}}</span>
                </a>
                  <ul id="quotationsubmenu" class="collapse list-unstyled ">
                    <li id="quotation-create-menu"><a href="{{route('quotation_supplier.index')}}">{{trans('file.Supplier Quotation')}}</a></li>
                </ul>
              </li>
              <li>
                <a href="#pursetupubmenu" aria-expanded="false" data-toggle="collapse">
                <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span>
                </a>
                  <ul id="pursetupubmenu" class="collapse list-unstyled ">
                    <li id="supplier-group-menu"><a href="#">{{trans('file.Supplier Group')}}</a></li>
                </ul>
              </li>

                </ul>
              </li>
              @endif
              <?php
                $sale_index_permission = DB::table('permissions')->where('name', 'sales-index')->first();
                $sale_index_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $sale_index_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                $gift_card_permission = DB::table('permissions')->where('name', 'gift_card')->first();
                $gift_card_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $gift_card_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                $coupon_permission = DB::table('permissions')->where('name', 'coupon')->first();
                $coupon_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $coupon_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                $delivery_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'delivery'],
                        ['role_id', $role->id] ])->first();

                $sale_add_permission = DB::table('permissions')->where('name', 'sales-add')->first();
                $sale_add_permission_active = DB::table('role_has_permissions')->where([
                    ['permission_id', $sale_add_permission->id],
                    ['role_id', $role->id]
                ])->first();
              ?>
              @if($sale_index_permission_active || $gift_card_permission_active || $coupon_permission_active || $delivery_permission_active)
              <li><a href="#sale" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-shopping-cart" aria-hidden="true"></i><span>{{trans('file.Sale')}}</span></a>
                <ul id="sale" class="collapse list-unstyled ">
                  <li>
                    <a href="#customersubmenu" aria-expanded="false" data-toggle="collapse">
                      <i class="fa fa-address-book-o" aria-hidden="true"></i><span>{{trans('file.Customer')}}</span>
                    </a>
                      <ul id="customersubmenu" class="collapse list-unstyled ">
                      <li id="customer-list-menu"><a href="{{route('customer.index')}}">{{trans('file.Customer List')}}</a></li>
                        <li id="biller-list-menu"><a href="{{route('biller.index')}}">{{trans('file.Biller List')}}</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="#salecontacts" aria-expanded="false" data-toggle="collapse">
                      <i class="dripicons-document" aria-hidden="true"></i><span>{{trans('file.Sale Contract')}}</span>
                    </a>
                      <ul id="salecontacts" class="collapse list-unstyled ">
                        <li id="sale-contact-menu"><a href="{{route('sale_contract.index')}}">{{trans('file.Sale Contract')}}</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="#salesubmenu" aria-expanded="false" data-toggle="collapse">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i><span>{{trans('file.Sale')}}</span>
                    </a>
                      <ul id="salesubmenu" class="collapse list-unstyled ">
                        @if($sale_index_permission_active)
                        <li id="sale-list-menu"><a href="{{route('sales.index')}}">{{trans('file.Sale List')}}</a></li>
                        @endif
                        @if($sale_add_permission_active)
                        <li><a href="{{route('sale.pos')}}">POS</a></li>
                        @endif
                        @if($delivery_permission_active)
                        <li id="delivery-menu"><a href="{{route('delivery.index')}}">{{trans('file.Delivery List')}}</a></li>
                        @endif
                    </ul>
                  </li>

                  <li>
                    <a href="#salereturnmenu" aria-expanded="false" data-toggle="collapse">
                      <i class="dripicons-return"></i><span>{{trans('file.Return')}}</span>
                    </a>
                      <ul id="salereturnmenu" class="collapse list-unstyled ">
                        @if($sale_index_permission_active)
                        <li id="sale-return-menu"><a href="{{route('return-sale.index')}}">{{trans('file.Sales Return')}}</a></li>
                        @endif
                    </ul>
                  </li>

                  <li>
                    <a href="#quotationmenu" aria-expanded="false" data-toggle="collapse">
                      <i class="dripicons-document"></i><span>{{trans('file.Quotation')}}</span>
                    </a>
                      <ul id="quotationmenu" class="collapse list-unstyled ">
                        <li id="quotation-list-menu"><a href="{{route('quotations.index')}}">{{trans('file.Quotation List')}}</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="#workordermenu" aria-expanded="false" data-toggle="collapse">
                      <i class="fa fa-file-word-o" aria-hidden="true"></i><span>{{trans('file.Work Order')}}</span>
                    </a>
                      <ul id="workordermenu" class="collapse list-unstyled ">
                        @if($sale_index_permission_active)
                        <li id="work-order-menu">
                          <a href="{{route('workorder.index')}}">{{trans('file.Work Order List')}}</a>
                      </li>
                        @endif
                    </ul>
                  </li>

                  <li>
                    <a href="#salesetupmenu" aria-expanded="false" data-toggle="collapse">
                      <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span>
                    </a>
                      <ul id="salesetupmenu" class="collapse list-unstyled ">
                        @if($sale_index_permission_active)
                        <li id="customer-group-menu"><a href="{{route('customer_group.index')}}">{{trans('file.Customer Group')}}</a></li>
                        <li id="gift-card-menu"><a href="{{route('gift_cards.index')}}">{{trans('file.Gift Card List')}}</a> </li>
                        <li id="coupon-menu"><a href="{{route('coupons.index')}}">{{trans('file.Coupon List')}}</a> </li>
                        <li id="ordertype-menu"><a href="{{route('ordertype.index')}}">{{trans('file.Order Type')}}</a></li>
                        <li id="reward-point-setting-menu"><a href="{{route('setting.rewardPoint')}}">{{trans('file.Reward Point Setting')}}</a></li>
                        <li id="pos-setting-menu"><a href="{{route('setting.pos')}}">POS {{trans('file.settings')}}</a></li>
                        @endif

                    </ul>
                  </li>
                </ul>
              </li>
              @endif

              <?php
                $index_permission = DB::table('permissions')->where('name', 'expenses-index')->first();
                $index_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $index_permission->id],
                        ['role_id', $role->id]
                    ])->first();
              ?>
              @if($index_permission_active)
              <li><a href="#expense" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-money" aria-hidden="true"></i><span>{{trans('file.Expense')}}</span></a>
                <ul id="expense" class="collapse list-unstyled ">
                  <li>
                      <a href="#expensesunmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-money" aria-hidden="true"></i><span>{{trans('file.Expense')}}</span>
                      </a>
                        <ul id="expensesunmenu" class="collapse list-unstyled ">
                          @if($sale_index_permission_active)
                          <li id="exp-list-menu"><a href="{{route('expenses.index')}}">{{trans('file.Expense List')}}</a></li>
                          @endif

                      </ul>
                    </li>
                    <li>
                      <a href="#expensesetup" aria-expanded="false" data-toggle="collapse">
                      <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span>
                      </a>
                        <ul id="expensesetup" class="collapse list-unstyled ">
                          @if($sale_index_permission_active)
                          <li id="exp-cat-menu"><a href="{{route('expense_categories.index')}}">{{trans('file.Expense Category')}}</a></li>
                          @endif

                      </ul>
                    </li>
                </ul>
              </li>
              @endif


              @if($index_permission_active)
              <li><a href="#production" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-cogs" aria-hidden="true"></i><span>{{trans('file.Production')}}</span></a>
                <ul id="production" class="collapse list-unstyled ">
                  <li>
                      <a href="#bom" aria-expanded="false" data-toggle="collapse">
                        <i class="dripicons-list" aria-hidden="true"></i><span>{{trans('file.BOM')}}</span>
                      </a>
                        <ul id="bom" class="collapse list-unstyled ">
                          @if($sale_index_permission_active)
                          <li id="bom-list-menu"><a href="#">{{trans('file.BOM')}}</a></li>
                          @endif

                      </ul>
                    </li>
                    <li>
                      <a href="#productionsetup" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span>
                      </a>
                        <ul id="productionsetup" class="collapse list-unstyled ">
                          @if($sale_index_permission_active)
                          <li id="project-list-menu"><a href="#">{{trans('file.BOM Conversion')}}</a></li>
                          @endif
                      </ul>
                    </li>

                </ul>
              </li>
              @endif

              @if($index_permission_active)
              <li><a href="#projectmenu" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-building" aria-hidden="true"></i><span>{{trans('file.Project')}}</span></a>
                <ul id="projectmenu" class="collapse list-unstyled ">
                  <li>
                      <a href="#projectsubmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-building-o" aria-hidden="true"></i><span>{{trans('file.Project')}}</span>
                      </a>
                        <ul id="projectsubmenu" class="collapse list-unstyled ">
                          @if($sale_index_permission_active)
                          <li id="project-list-menu"><a href="#">{{trans('file.Project List')}}</a></li>
                          @endif
                      </ul>
                    </li>
                    <li>
                      <a href="#projectsetup" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span>
                      </a>
                        <ul id="projectsetup" class="collapse list-unstyled ">
                          @if($sale_index_permission_active)
                          <li id="project-list-menu"><a href="#">{{trans('file.Cost Code')}}</a></li>
                          @endif
                      </ul>
                    </li>

                </ul>
              </li>
              @endif


            <!-- Human Resource HRM Permissions -->

              <?php
                $department = DB::table('permissions')->where('name', 'department')->first();
                $department_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $department->id],
                        ['role_id', $role->id]
                    ])->first();
                $index_employee = DB::table('permissions')->where('name', 'employees-index')->first();
                $index_employee_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $index_employee->id],
                        ['role_id', $role->id]
                    ])->first();
                $attendance = DB::table('permissions')->where('name', 'attendance')->first();
                $attendance_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $attendance->id],
                        ['role_id', $role->id]
                    ])->first();
                $payroll = DB::table('permissions')->where('name', 'payroll')->first();
                $payroll_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $payroll->id],
                        ['role_id', $role->id]
                    ])->first();
              ?>

            <!-- Human Resource HRM -->
              @if(Auth::user()->role_id != 5)
              <li class=""><a href="#hrm" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-users" aria-hidden="true"></i><span>Human Resource</span></a>
                <ul id="hrm" class="collapse list-unstyled ">
                    <li>
                      <a href="#payrollmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-money" aria-hidden="true"></i><span>{{trans('file.Payroll')}}</span>
                      </a>
                        <ul id="payrollmenu" class="collapse list-unstyled ">
                          @if($payroll_active)
                          <li id="payroll-menu"><a href="{{route('payroll.index')}}">{{trans('file.Payroll')}}</a></li>
                          @endif

                      </ul>
                    </li>
                    <li>
                      <a href="#attendancemenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-clock-o" aria-hidden="true"></i><span>{{trans('file.Attendance')}}</span>
                      </a>
                        <ul id="attendancemenu" class="collapse list-unstyled ">
                        @if($attendance_active)
                        <li id="attendance-menu"><a href="{{route('attendance.index')}}">{{trans('file.Attendance')}}</a></li>
                        <li id="holiday-menu"><a href="{{route('holidays.index')}}">{{trans('file.Holiday')}}</a></li>
                        @endif
                      </ul>
                    </li>
                    <li>
                        <a href="#taskmenu" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-clock-o" aria-hidden="true"></i><span>{{trans('file.Task')}}</span>
                        </a>
                          <ul id="taskmenu" class="collapse list-unstyled ">
                            <li id="attendance-menu"><a href="{{route('task.index')}}">{{trans('file.Task List')}}</a></li>
                        </ul>
                      </li>
                    <li>
                      <a href="#hrmsetupmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span>
                      </a>
                        <ul id="hrmsetupmenu" class="collapse list-unstyled ">
                          @if($department_active)
                          <li id="dept-menu"><a href="{{route('departments.index')}}">{{trans('file.Department')}}</a></li>
                          @endif
                          @if($index_employee_active)
                          <li id="employee-menu"><a href="{{route('designation.index')}}">{{trans('file.Designation')}}</a></li>
                          <li id="employee-menu"><a href="{{route('employees.index')}}">{{trans('file.Employee')}}</a></li>

                          <li id="hrm-setting-menu"><a href="{{route('setting.hrm')}}"> {{trans('file.HRM Setting')}}</a></li>
                          @endif
                      </ul>
                    </li>
                </ul>
              </li>
              @endif
            <!--    end HRM     --!>






            <!-- Finance Accounting permissions -->
              <?php
                $index_permission = DB::table('permissions')->where('name', 'account-index')->first();
                $index_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $index_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                $money_transfer_permission = DB::table('permissions')->where('name', 'money-transfer')->first();
                $money_transfer_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $money_transfer_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                $balance_sheet_permission = DB::table('permissions')->where('name', 'balance-sheet')->first();
                $balance_sheet_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $balance_sheet_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                $account_statement_permission = DB::table('permissions')->where('name', 'account-statement')->first();
                $account_statement_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $account_statement_permission->id],
                        ['role_id', $role->id]
                    ])->first();

              ?>

            <!-- Finance -->
              @if($index_permission_active || $balance_sheet_permission_active || $account_statement_permission_active || $money_transfer_permission_active)
              <li class=""><a href="#account" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-briefcase" aria-hidden="true"></i><span>{{trans('file.Accounting')}}</span></a>
                <ul id="account" class="collapse list-unstyled ">

                    <li>
                      <a href="#financialmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-university" aria-hidden="true"></i><span>{{trans('file.Financial')}}</span>
                      </a>
                        <ul id="financialmenu" class="collapse list-unstyled ">
                          @if($account_statement_permission_active)
                          <li id="account-statement-menu"><a id="account-statement" href="">{{trans('file.Account Statement')}}</a></li>
                          @endif
                          @if($balance_sheet_permission_active)
                          <li id="balance-sheet-menu"><a href="{{route('accounts.balancesheet')}}">{{trans('file.Balance Sheet')}}</a></li>
                          @endif
                          @if($money_transfer_permission_active)
                          <li id="money-transfer-menu"><a href="{{route('money-transfers.index')}}">{{trans('file.Money Transfer')}}</a></li>
                          @endif
                      </ul>
                    </li>

                    <li>
                      <a href="#financialsetup" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-cog" aria-hidden="true"></i><span>{{trans('file.Setup')}}</span>
                      </a>
                        <ul id="financialsetup" class="collapse list-unstyled ">
                        @if($index_permission_active)
                        <li id="account-list-menu"><a href="{{route('accounts.index')}}">{{trans('file.Account List')}}</a></li>
                        @endif
                        <li id="account-list-menu"><a href="{{route('accounts-categories.index')}}">{{trans('file.Account Categories')}}</a></li>
                      </ul>
                    </li>
                </ul>
               </li>
                @endif

            <!-- Organization permissions Temporary from general settings -->
            <!--
              <li><a href="#setting" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-gear"></i><span>{{trans('file.settings')}}</span></a>
                <ul id="setting" class="collapse list-unstyled ">
                  <?php
                      $general_setting_permission = DB::table('permissions')->where('name', 'general_setting')->first();
                      $general_setting_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $general_setting_permission->id],
                                  ['role_id', $role->id]
                              ])->first();
                  ?>
            -->

            <!-- Organization menu -->
              @if($general_setting_permission_active)
              <li class=""><a href="#organization-menu" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-sitemap" aria-hidden="true"></i><span>{{trans('file.Organization')}}</span></a>
                <ul id="organization-menu" class="collapse list-unstyled ">
                    <li><a href="#announcement-menu" aria-expanded="false" data-toggle="collapse"><i class="fa fa-bullhorn" aria-hidden="true"></i><span>{{trans('file.Announcement')}}</span></a>
                        <ul id="announcement-menu" class="collapse list-unstyled ">
                          @if($general_setting_permission_active)
                          <li id="anouncement"><a id="announcement" href="{{route('announcement.index')}}">{{trans('file.Announcement')}}</a></li>
                          @endif
                        </ul>
                    </li>
                </ul>
               </li>
              @endif
            <!-- End of Organization menu -->


            <!-- Documents menu -->

              @if($general_setting_permission_active)
              <li class=""><a href="#document-menu" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-folder-open" aria-hidden="true"></i><span>{{trans('file.Documents')}}</span></a>
                <ul id="document-menu" class="collapse list-unstyled ">
                    <li>
                      <a href="#employee-doc-menu" aria-expanded="false" data-toggle="collapse"><i class="fa fa-user" aria-hidden="true"></i><span>{{trans('file.Employee Documents')}}</span></a>
                    </li>
                    <li>
                      <a href="{{route('documents.index')}}"><i class="fa fa-user" aria-hidden="true"></i><span>{{trans('file.Documents')}}</span></a>
                    </li>
                </ul>
               </li>
              @endif

            <!-- End of Documents menu -->

            <!-- Support menu -->
                @if($general_setting_permission_active)
                <li class=""><a href="#support-menu" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-life-ring" aria-hidden="true"></i><span>{{trans('file.Support')}}</span></a>
                <ul id="support-menu" class="collapse list-unstyled ">
                    <li><a href="#support-ticket-menu" aria-expanded="false" data-toggle="collapse"><i class="fa fa-ticket" aria-hidden="true"></i><span>{{trans('file.Support Ticket')}}</span></a>
                        <ul id="support-ticket-menu" class="collapse list-unstyled">
                            <li id="purchase-return-menu"><a href="{{route('support_ticket.index')}}">{{trans('file.Ticket')}}</a></li>
                        </ul>
                    </li>
                </ul>
                </li>
                @endif
            <!-- End of Support menu -->


            <!-- Reports Permissions -->
              <?php
                $profit_loss_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'profit-loss'],
                        ['role_id', $role->id] ])->first();
                $best_seller_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'best-seller'],
                        ['role_id', $role->id] ])->first();
                $warehouse_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'warehouse-report'],
                        ['role_id', $role->id] ])->first();
                $warehouse_stock_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'warehouse-stock-report'],
                        ['role_id', $role->id] ])->first();
                $product_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'product-report'],
                        ['role_id', $role->id] ])->first();
                $daily_sale_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'daily-sale'],
                        ['role_id', $role->id] ])->first();
                $monthly_sale_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'monthly-sale'],
                        ['role_id', $role->id]])->first();
                $daily_purchase_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'daily-purchase'],
                        ['role_id', $role->id] ])->first();
                $monthly_purchase_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'monthly-purchase'],
                        ['role_id', $role->id] ])->first();
                $purchase_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'purchase-report'],
                        ['role_id', $role->id] ])->first();
                $sale_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'sale-report'],
                        ['role_id', $role->id] ])->first();
                $payment_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'payment-report'],
                        ['role_id', $role->id] ])->first();
                $product_qty_alert_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'product-qty-alert'],
                        ['role_id', $role->id] ])->first();
                $user_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'user-report'],
                        ['role_id', $role->id] ])->first();

                $customer_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'customer-report'],
                        ['role_id', $role->id] ])->first();
                $supplier_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'supplier-report'],
                        ['role_id', $role->id] ])->first();
                $due_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'due-report'],
                        ['role_id', $role->id] ])->first();
              ?>


            <!-- Reports -->
              @if($profit_loss_active || $best_seller_active || $warehouse_report_active || $warehouse_stock_report_active || $product_report_active || $daily_sale_active || $monthly_sale_active || $daily_purchase_active || $monthly_purchase_active || $purchase_report_active || $sale_report_active || $payment_report_active || $product_qty_alert_active || $user_report_active || $customer_report_active || $supplier_report_active || $due_report_active)

              <li>
                    <a href="#report" aria-expanded="false" data-toggle="collapse">
                        <i class="dripicons-document-remove"></i><span>{{trans('file.Reports')}}</span>
                    </a>
                <ul id="report" class="collapse list-unstyled ">

                <!-- start sale report Sub menu -->
                    <li>
                      <a href="#salereport" aria-expanded="false" data-toggle="collapse">
                        <i class="dripicons-cart"></i><span>{{trans('file.Sale Report')}}</span>
                      </a>
                        <ul id="salereport" class="collapse list-unstyled ">
                          @if($daily_sale_active)
                          <li id="daily-sale-report-menu">
                              <a href="{{url('report/daily_sale/'.date('Y').'/'.date('m'))}}">{{trans('file.Daily Sale')}}</a>
                          </li>
                          @endif
                          @if($monthly_sale_active)
                          <li id="monthly-sale-report-menu">
                              <a href="{{url('report/monthly_sale/'.date('Y'))}}">{{trans('file.Monthly Sale')}}</a>
                          </li>
                          @endif

                          @if($sale_report_active)
                          <li id="sale-report-menu">
                              {!! Form::open(['route' => 'report.sale', 'method' => 'post', 'id' => 'sale-report-form']) !!}
                              <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                              <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                              <input type="hidden" name="warehouse_id" value="0" />
                              <a id="sale-report-link" href="">{{trans('file.Sale Report')}}</a>
                              {!! Form::close() !!}
                          </li>
                          @endif

                          @if($customer_report_active)
                          <li id="customer-report-menu">
                              <a id="customer-report-link" href="">{{trans('file.Customer Report')}}</a>
                          </li>
                          @endif

                          @if($purchase_report_active)
                          <li id=""><a href="{{route('report.allCustomerIndex')}}">{{trans('file.All Customers Due Report')}}</a></li>
                          @endif

                      </ul>
                    </li>

                <!-- end sale report Sub menu -->


                <!-- start purchase report Sub menu -->
                      <li>
                        <a href="#purchasereport" aria-expanded="false" data-toggle="collapse">
                            <i class="dripicons-card"></i><span>{{trans('file.Purchase Report')}}</span>
                        </a>
                            <ul id="purchasereport" class="collapse list-unstyled ">
                                @if($daily_purchase_active)
                                <li id="daily-purchase-report-menu">
                                    <a href="{{url('report/daily_purchase/'.date('Y').'/'.date('m'))}}">{{trans('file.Daily Purchase')}}</a>
                                </li>
                                @endif
                                @if($monthly_purchase_active)
                                <li id="monthly-purchase-report-menu">
                                    <a href="{{url('report/monthly_purchase/'.date('Y'))}}">{{trans('file.Monthly Purchase')}}</a>
                                </li>
                                @endif

                                @if($purchase_report_active)
                                <li id="purchase-report-menu">
                                    {!! Form::open(['route' => 'report.purchase', 'method' => 'post', 'id' => 'purchase-report-form']) !!}
                                    <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                                    <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                                    <input type="hidden" name="warehouse_id" value="0" />
                                    <a id="purchase-report-link" href="">{{trans('file.Purchase Report')}}</a>
                                    {!! Form::close() !!}
                                </li>
                                @endif

                                @if($supplier_report_active)
                                <li id="supplier-report-menu">
                                    <a id="supplier-report-link" href="">{{trans('file.Supplier Report')}}</a>
                                </li>
                                @endif
                                @if($purchase_report_active)
                                <li id="purchase-report-menu">
                                    <a  href="{{route('report.allSupplierIndex')}}">{{trans('file.All Suppliers Due Report')}}</a>
                                </li>
                                @endif

                                @if($purchase_report_active)
                                <li id="stock-ability-report-menu">
                                    {!! Form::open(['route' => 'report.productCostReport', 'method' => 'post', 'id' => 'product_cost_report']) !!}
                                    <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                                    <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                                    <input type="hidden" name="warehouse_id" value="0" />
                                    <a id="product_cost_report" href="">{{trans('file.Product Cost Report')}}</a>
                                    {!! Form::close() !!}
                                </li>
                                @endif

                            </ul>
                      </li>

                <!-- end purchase report Sub menu -->

                <!-- start payment Sub menu -->
                  <li>
                      <a href="#paymentreport" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-money"></i><span>{{trans('file.Payment Report')}}</span>
                      </a>
                      <ul id="paymentreport" class="collapse list-unstyled ">
                          @if($payment_report_active)
                          <li id="payment-report-menu">
                              {!! Form::open(['route' => 'report.paymentByDate', 'method' => 'post', 'id' => 'payment-report-form']) !!}
                              <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                              <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                              <a id="payment-report-link" href="">{{trans('file.Payment Report')}}</a>
                              {!! Form::close() !!}
                          </li>
                          @endif


                          @if($due_report_active)
                          <li id="due-report-menu">
                              {!! Form::open(['route' => 'report.dueByDate', 'method' => 'post', 'id' => 'due-report-form']) !!}
                              <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                              <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                              <a id="due-report-link" href="">{{trans('file.Due Report')}}</a>
                              {!! Form::close() !!}
                          </li>
                          @endif



                      </ul>
                  </li>
                <!-- end payment  Sub menu -->

                <!-- start location report Sub menu -->
                  <li>
                      <a href="#locationreport" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-map-marker"></i><span>{{trans('file.Warehouse Report')}}</span>
                      </a>
                      <ul id="locationreport" class="collapse list-unstyled ">
                          <li id="profit-loss-report-menu">
                              {!! Form::open(['route' => 'report.profitLossLocation', 'method' => 'post', 'id' => 'profitLossLocation-report-form']) !!}
                              <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                              <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                              <a id="profitLossLocation-link" href="">{{trans('file.Location Summary Report')}}</a>
                              {!! Form::close() !!}
                          </li>
                          @if($warehouse_report_active)
                          <li id="warehouse-report-menu">
                            <a id="warehouse-report-link" href="">{{trans('file.Warehouse Detail Report')}}</a>
                          </li>
                          @endif

                      </ul>
                  </li>
                <!-- end location report Sub menu -->

                <!-- start product report Sub menu -->
                    <li>
                        <a href="#productreport" aria-expanded="false" data-toggle="collapse">
                            <i class="dripicons-list"></i><span>{{trans('file.Product Report')}}</span>
                        </a>
                        <ul id="productreport" class="collapse list-unstyled ">
                            @if($product_report_active)
                            <li id="product-report-menu">
                                {!! Form::open(['route' => 'report.product', 'method' => 'post', 'id' => 'product-report-form']) !!}
                                <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                                <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                                <input type="hidden" name="warehouse_id" value="0" />
                                <a id="report-link" href="">{{trans('file.Product Report')}}</a>
                                {!! Form::close() !!}
                            </li>
                            @endif

                            @if($product_qty_alert_active)
                            <li id="qtyAlert-report-menu">
                                <a href="{{route('report.qtyAlert')}}">{{trans('file.Product Quantity Alert')}}</a>
                            </li>
                            @endif

                            @if($purchase_report_active)
                                <li>
                                    <a href="{{route('report.stock_availability')}}" > {{trans('file.Stock Availability Report')}}</a>
                                </li>
                                @endif
                        </ul>
                    </li>
                <!-- end product report Sub menu -->

                <!-- start user report Sub menu -->
                  <li>
                      <a href="#userreport" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-user"></i><span>{{trans('file.User Report')}}</span>
                      </a>
                      <ul id="userreport" class="collapse list-unstyled ">
                          @if($user_report_active)
                          <li id="user-report-menu">
                            <a id="user-report-link" href="">{{trans('file.User Report')}}</a>
                          </li>
                          @endif
                      </ul>
                  </li>

                <!-- end user report Sub menu -->

                </ul>
            </li>
              @endif


            <!-- Settings Permissions -->
              <li><a href="#setting" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-gear"></i><span>{{trans('file.settings')}}</span></a>
                <ul id="setting" class="collapse list-unstyled ">
                  <?php
                      $send_notification_permission = DB::table('permissions')->where('name', 'send_notification')->first();
                      $send_notification_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $send_notification_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $warehouse_permission = DB::table('permissions')->where('name', 'warehouse')->first();
                      $warehouse_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $warehouse_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $customer_group_permission = DB::table('permissions')->where('name', 'customer_group')->first();
                      $customer_group_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $customer_group_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $brand_permission = DB::table('permissions')->where('name', 'brand')->first();
                      $brand_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $brand_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $unit_permission = DB::table('permissions')->where('name', 'unit')->first();
                      $unit_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $unit_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $currency_permission = DB::table('permissions')->where('name', 'currency')->first();
                      $currency_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $currency_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $tax_permission = DB::table('permissions')->where('name', 'tax')->first();
                      $tax_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $tax_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $general_setting_permission = DB::table('permissions')->where('name', 'general_setting')->first();
                      $general_setting_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $general_setting_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $backup_database_permission = DB::table('permissions')->where('name', 'backup_database')->first();
                      $backup_database_permission_active = DB::table('role_has_permissions')->where([
                                  ['permission_id', $backup_database_permission->id],
                                  ['role_id', $role->id]
                              ])->first();

                      $mail_setting_permission = DB::table('permissions')->where('name', 'mail_setting')->first();
                      $mail_setting_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $mail_setting_permission->id],
                          ['role_id', $role->id]
                      ])->first();

                      $sms_setting_permission = DB::table('permissions')->where('name', 'sms_setting')->first();
                      $sms_setting_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $sms_setting_permission->id],
                          ['role_id', $role->id]
                      ])->first();

                      $create_sms_permission = DB::table('permissions')->where('name', 'create_sms')->first();
                      $create_sms_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $create_sms_permission->id],
                          ['role_id', $role->id]
                      ])->first();

                      $pos_setting_permission = DB::table('permissions')->where('name', 'pos_setting')->first();
                      $pos_setting_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $pos_setting_permission->id],
                          ['role_id', $role->id]
                      ])->first();

                      $hrm_setting_permission = DB::table('permissions')->where('name', 'hrm_setting')->first();
                      $hrm_setting_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $hrm_setting_permission->id],
                          ['role_id', $role->id]
                      ])->first();

                      $reward_point_setting_permission = DB::table('permissions')->where('name', 'reward_point_setting')->first();
                      $reward_point_setting_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $reward_point_setting_permission->id],
                          ['role_id', $role->id]
                      ])->first();
                  ?>

                <!-- Settings -->
                  <li>
                    <a href="#companymenu" aria-expanded="false" data-toggle="collapse">
                      <i class="fa fa-building" aria-hidden="true"></i><span>{{trans('file.Company')}}</span>
                    </a>
                      <ul id="companymenu" class="collapse list-unstyled ">

                        @if($general_setting_permission_active)
                        <li id="general-setting-menu"><a href="{{route('setting.general')}}">{{trans('file.General Setting')}}</a></li>
                        @endif
                        <li id="general-setting-menu"><a href="{{route('company.index')}}">{{trans('file.Company')}}</a></li>
                        @if($warehouse_permission_active)
                        <li id="warehouse-menu"><a href="{{route('warehouse.index')}}">{{trans('file.Warehouse')}}</a></li>
                        @endif
                        @if($tax_permission_active)
                        <li id="tax-menu"><a href="{{route('tax.index')}}">{{trans('file.Tax')}}</a></li>
                        @if($currency_permission_active)
                        <li id="currency-menu"><a href="{{route('currency.index')}}">{{trans('file.Currency')}}</a></li>
                        @endif
                        <li id="currency-menu"><a href="{{route('systemcolor.index')}}">{{trans('file.System Color')}}</a></li>
                        @endif

                    </ul>
                  </li>

                 <!-- holdings -->
                  <li>
                    <a href="#holdingmenu" aria-expanded="false" data-toggle="collapse">
                      <i class="fa fa-building" aria-hidden="true"></i><span>{{trans('file.Holding')}}</span>
                    </a>
                      <ul id="holdingmenu" class="collapse list-unstyled ">
                        <li id="general-setting-menu"><a href="{{route('holding.index')}}">{{trans('file.Holding')}}</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="#usermenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-user" aria-hidden="true"></i><span>{{trans('file.User')}}</span>
                    </a>
                      <ul id="usermenu" class="collapse list-unstyled ">

                        @if($role->id <= 2)
                        <li id="role-menu"><a href="{{route('role.index')}}">{{trans('file.Role Permission')}}</a></li>
                        @endif
                        <li id="user-menu"><a href="{{route('user.profile', ['id' => Auth::id()])}}">{{trans('file.User Profile')}}</a></li>
                        <li id="user-list-menu"><a href="{{route('user.index')}}">{{trans('file.User List')}}</a></li>

                    </ul>
                  </li>

                  <li>
                    <a href="#notificationmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-envelope" aria-hidden="true"></i><span>{{trans('file.Notification')}}</span>
                    </a>
                      <ul id="notificationmenu" class="collapse list-unstyled ">
                        @if($create_sms_permission_active)
                        <li id="create-sms-menu"><a href="{{route('setting.createSms')}}">{{trans('file.Create SMS')}}</a></li>
                        @endif
                        @if($mail_setting_permission_active)
                        <li id="mail-setting-menu"><a href="{{route('setting.mail')}}">{{trans('file.Mail Setting')}}</a></li>
                        @endif
                        @if($send_notification_permission_active)
                        <li id="notification-menu">
                          <a href="" id="send-notification">{{trans('file.Send Notification')}}</a>
                        </li>
                        @endif

                        @if($sms_setting_permission_active)
                        <li id="sms-setting-menu"><a href="{{route('setting.sms')}}">{{trans('file.SMS Setting')}}</a></li>
                        @endif

                    </ul>
                  </li>

                  <li>
                    <a href="#databasemenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-database" aria-hidden="true"></i><span>{{trans('file.Database')}}</span>
                    </a>
                      <ul id="databasemenu" class="collapse list-unstyled ">
                        @if($backup_database_permission_active)
                        <li><a href="{{route('setting.backup')}}">{{trans('file.Backup Database')}}</a></li>
                        @endif

                    </ul>
                  </li>

                  <li>
                    <a href="#workflowmenu" aria-expanded="false" data-toggle="collapse">
                        <i class="fa fa-random" aria-hidden="true"></i><span>{{trans('file.Workflow')}}</span>
                    </a>
                      <ul id="workflowmenu" class="collapse list-unstyled ">
                        @if($backup_database_permission_active)
                        <li><a href="{{route('workflow.index')}}">{{trans('file.Workflow Setup')}}</a></li>
                        @endif

                    </ul>
                  </li>

                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- navbar-->
      <header class="header">
        <nav class="navbar" id="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <div class="">
                    <a id="toggle-btn" href="#" class="menu-btn">
                        <i class="fa fa-bars"> </i>
                    </a>
                    <a href="{{url('/')}}">
                        <img class="clogo" src="{{asset('/images/LogoHeader.png') }}" />
                    </a>
                </div>

                <span class="brand-big">
                    @if($userGeneralSetting->company->company_logo??false)
                        <img src="{{ url('/companies/images', $userGeneralSetting->company->company_logo) }}" class="home-company-logo">&nbsp;&nbsp;
                    @elseif ($general_setting->site_logo)
                        <img src="{{url('/companies/images', $general_setting->site_logo)}}" class="home-company-logo">&nbsp;&nbsp;
                    @endif
                </span>

                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <?php
                        $add_permission = DB::table('permissions')->where('name', 'sales-add')->first();
                        $add_permission_active = DB::table('role_has_permissions')->where([
                            ['permission_id', $add_permission->id],
                            ['role_id', $role->id]
                        ])->first();

                        $empty_database_permission = DB::table('permissions')->where('name', 'empty_database')->first();
                        $empty_database_permission_active = DB::table('role_has_permissions')->where([
                            ['permission_id', $empty_database_permission->id],
                            ['role_id', $role->id]
                        ])->first();
                    ?>

                    <!-- Navbar icons -->

                    <!-- Shortcuts -->
                    <li class="nav-item" title="{{trans('file.Shortcuts')}}">
                        <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item dropdown-item2"><i class="fa fa-star"></i> <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li><a id="btnFullscreen" title="{{trans('file.Full Screen')}}"><i class="dripicons-expand"></i>{{trans('Full Screen')}}</a></li>
                            @if($general_setting_permission_active)
                            <li>
                                <a href="{{route('sale.pos')}}" title="{{trans('file.POS')}}"><i class="dripicons-shopping-bag"></i> {{trans('POS')}}</a>
                            </li>
                            <li>
                                <a href="{{route('report.stock_availability')}}" ><i class="fa fa-cubes"></i> {{trans('file.Stock Availability Report')}}</a>
                            </li>
                            <li>
                                <a href="{{url('purchases')}}" title="{{trans('file.Purchases')}}"><i class="fa fa-credit-card"></i> {{trans('file.Purchases')}}</a>
                            </li>
                            <li>
                                <a href="{{url('sales')}}" title="{{trans('file.Sales')}}"><i class="fa fa-shopping-cart"></i> {{trans('file.Sales')}}</a>
                            </li>
                            <li>
                                <a href="{{url('item_requirement')}}" title="{{trans('file.Item Requirement')}}"><i class="dripicons-document"></i> {{trans('file.Item Requirement')}}</a>
                            </li>
                            @endif
                            @if(\Auth::user()->role_id <= 2)
                            <li>
                                <a href="{{route('cashRegister.index')}}" title="{{trans('file.Cash Register List')}}"><i class="dripicons-archive"></i>{{trans('file.Cash Register List')}}</a>
                            </li>
                            @endif
                        </ul>
                    </li>

                    <!-- Full Screen -->
                    <li class="nav-item btnFullscreen d-none"><a id="btnFullscreen" title="{{trans('file.Full Screen')}}"><i class="dripicons-expand"></i></a></li>

                    <!-- Notification -->
                    @if($product_qty_alert_active)
                    @if(($alert_product + count(\Auth::user()->unreadNotifications)) > 0)
                    <li class="nav-item" id="notification-icon" title="{{trans('file.Notification')}}">
                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="dripicons-bell"></i><span class="badge badge-danger notification-number">{{$alert_product + count(\Auth::user()->unreadNotifications)}}</span>
                            </a>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default notifications" user="menu">
                                <li class="notifications">
                                <a href="{{route('report.qtyAlert')}}" class="btn btn-link"> {{$alert_product}} product exceeds alert quantity</a>
                                </li>
                                @foreach(\Auth::user()->unreadNotifications as $key => $notification)
                                    <li class="notifications">
                                        <a href="#" class="btn btn-link">{{ $notification->data['message'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                    </li>
                    @elseif(count(\Auth::user()->unreadNotifications) > 0)
                    <li class="nav-item" id="notification-icon" title="{{trans('file.Notification')}}">
                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="dripicons-bell"></i><span class="badge badge-danger notification-number">{{count(\Auth::user()->unreadNotifications)}}</span>
                            </a>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default notifications" user="menu">
                                @foreach(\Auth::user()->unreadNotifications as $key => $notification)
                                    <li class="notifications">
                                        <a href="#" class="btn btn-link">{{ $notification->data['message'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                    </li>

                    @endif
                    @endif

                    <!-- User -->
                    <li class="nav-item" title="{{trans('file.User')}}">
                    <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item dropdown-item2"><i class="dripicons-user"></i> <span>{{ucfirst(Auth::user()->name)}}</span> <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                        <li>
                            <a href="{{route('user.profile', ['id' => Auth::id()])}}"><i class="dripicons-user"></i> {{trans('file.profile')}}</a>
                        </li>
                        <li>
                            <a href="{{url('my-transactions/'.date('Y').'/'.date('m'))}}"><i class="dripicons-swap"></i> {{trans('file.My Transaction')}}</a>
                        </li>
                        @if(Auth::user()->role_id != 5)
                        <li>
                            <a href="{{url('holidays/my-holiday/'.date('Y').'/'.date('m'))}}"><i class="dripicons-vibrate"></i> {{trans('file.My Holiday')}}</a>
                        </li>
                        @endif
                        @if($empty_database_permission_active)
                        <li class="d-none">
                            <a onclick="return confirm('Are you sure want to delete? If you do this all of your data will be lost.')" href="{{route('setting.emptyDatabase')}}"><i class="dripicons-stack"></i> {{trans('file.Empty Database')}}</a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"><i class="dripicons-power"></i>
                                {{trans('file.logout')}}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    </li>
                </ul>
            </div>
          </div>
        </nav>
      </header>
    <div class="page">
      <!-- notification modal -->
      <div id="notification-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Send Notification')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    {!! Form::open(['route' => 'notifications.store', 'method' => 'post']) !!}
                      <div class="row">
                          <?php
                              $lims_user_list = DB::table('users')->where([
                                ['is_active', true],
                                ['id', '!=', \Auth::user()->id]
                              ])->get();
                          ?>
                          <div class="col-md-6 form-group">
                              <label>{{trans('file.User')}}</label><i class="fa fa-asterisk"></i>
                              <select name="user_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select user...">
                                  @foreach($lims_user_list as $user)
                                  <option value="{{$user->id}}">{{$user->name . ' (' . $user->email. ')'}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-md-12 form-group">
                              <label>{{trans('file.Message')}}</label><i class="fa fa-asterisk"></i>
                              <textarea rows="5" name="message" class="form-control" required></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- end notification modal -->

      <!-- expense modal -->
      <div id="expense-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Expense')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    {!! Form::open(['route' => 'expenses.store', 'method' => 'post']) !!}
                    <?php
                      $lims_expense_category_list = DB::table('expense_categories')->where('is_active', true)->get();
                      if(Auth::user()->role_id > 2)
                        $lims_warehouse_list = DB::table('warehouses')->where([
                          ['is_active', true],
                          ['id', Auth::user()->warehouse_id]
                        ])->get();
                      else
                        $lims_warehouse_list = DB::table('warehouses')->where('is_active', true)->get();
                      $lims_account_list = \App\Account::where('is_active', true)->get();

                    ?>
                      <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Expense Category')}}</label><i class="fa fa-asterisk"></i>
                            <select name="expense_category_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select Expense Category...">
                                @foreach($lims_expense_category_list as $expense_category)
                                <option value="{{$expense_category->id}}">{{$expense_category->name . ' (' . $expense_category->code. ')'}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Warehouse')}}</label><i class="fa fa-asterisk"></i>
                            <select name="warehouse_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select Warehouse...">
                                @foreach($lims_warehouse_list as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Amount')}}</label><i class="fa fa-asterisk"></i>
                            <input type="number" name="amount" step="any" required class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label> {{trans('file.Account')}}</label>
                            <select class="form-control selectpicker" name="account_id">
                            @foreach($lims_account_list as $account)
                                @if($account->is_default)
                                <option selected value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                                @else
                                <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                          <label>{{trans('file.Note')}}</label>
                          <textarea name="note" rows="3" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- end expense modal -->

      <!-- account statement modal -->
      <div id="account-statement-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Account Statement')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    {!! Form::open(['route' => 'accounts.statement', 'method' => 'post']) !!}
                      <div class="row">
                        <div class="col-md-6 form-group">
                            <label> {{trans('file.Account')}}</label>
                            <select class="form-control selectpicker" name="account_id">
                            @foreach($lims_account_list as $account)
                                <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label> {{trans('file.Type')}}</label>
                            <select class="form-control selectpicker" name="type">
                                <option value="0">{{trans('file.All')}}</option>
                                <option value="1">{{trans('file.Debit')}}</option>
                                <option value="2">{{trans('file.Credit')}}</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>{{trans('file.Choose Your Date')}}</label>
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control" required />
                                <input type="hidden" name="start_date" />
                                <input type="hidden" name="end_date" />
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- end account statement modal -->

      <!-- warehouse modal -->
      <div id="warehouse-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Warehouse Report')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    {!! Form::open(['route' => 'report.warehouse', 'method' => 'post']) !!}
                    <?php
                      $lims_warehouse_list = DB::table('warehouses')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label>{{trans('file.Warehouse')}}</label><i class="fa fa-asterisk"></i>
                          <select name="warehouse_id" class="selectpicker form-control" required data-live-search="true" id="warehouse-id" data-live-search-style="begins" title="Select warehouse...">
                              @foreach($lims_warehouse_list as $warehouse)
                              <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                              @endforeach
                          </select>
                      </div>

                      <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                      <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- end warehouse modal -->

      <!-- user modal -->
      <div id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.User Report')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    {!! Form::open(['route' => 'report.user', 'method' => 'post']) !!}
                    <?php
                      $lims_user_list = DB::table('users')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label>{{trans('file.User')}}</label><i class="fa fa-asterisk"></i>
                          <select name="user_id" class="selectpicker form-control" required data-live-search="true" id="user-id" data-live-search-style="begins" title="Select user...">
                              @foreach($lims_user_list as $user)
                              <option value="{{$user->id}}">{{$user->name . ' (' . $user->phone. ')'}}</option>
                              @endforeach
                          </select>
                      </div>

                      <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                      <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- end user modal -->

      <!-- customer modal -->
      <div id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Customer Report')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    {!! Form::open(['route' => 'report.customer', 'method' => 'post']) !!}
                    <?php
                      $lims_customer_list = DB::table('customers')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label>{{trans('file.customer')}}</label><i class="fa fa-asterisk"></i>
                          <select name="customer_id" class="selectpicker form-control" required data-live-search="true" id="customer-id" data-live-search-style="begins" title="Select customer...">
                              @foreach($lims_customer_list as $customer)
                              <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone_number. ')'}}</option>
                              @endforeach
                          </select>
                      </div>

                      <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                      <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- end customer modal -->

      <!-- supplier modal -->
      <div id="supplier-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Supplier Report')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    {!! Form::open(['route' => 'report.supplier', 'method' => 'post']) !!}
                    <?php
                      $lims_supplier_list = DB::table('suppliers')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label>{{trans('file.Supplier')}}</label><i class="fa fa-asterisk"></i>
                          <select name="supplier_id" class="selectpicker form-control" required data-live-search="true" id="supplier-id" data-live-search-style="begins" title="Select Supplier...">
                              @foreach($lims_supplier_list as $supplier)
                              <option value="{{$supplier->id}}">{{$supplier->name . ' (' . $supplier->phone_number. ')'}}</option>
                              @endforeach
                          </select>
                      </div>

                      <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                      <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- end supplier modal -->


      <div style="display:none" id="content" class="animate-bottom">
          @yield('content')
      </div>

      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="col-md-8 float-left">
                    <a href="/" target="_blank">
                        <p>
                            <img class="mr-2" style="width: 10%" src="{{asset('/images/LogoFooter.png') }}">
                            {{trans('file.Developed')}} {{trans('file.By')}} <span class="ml-0">Infinity IT Services</span> <span class="ml-4"> Powered by Saffutions  <img class="ml-2" style="width: 10%" src="{{asset('/images/LogoFooter2.png') }}"></span>
                        </p>
                    </a>
                </div>
                <div class="col-md-4 float-left">
                    <ul class="nav-menu list-unstyled align-items-md-center mt-2">
                        <!-- Default Settings -->
                        <li class="nav-item" title="{{trans('file.Default Settings')}}">
                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item dropdown-item2"><i class="dripicons-gear"></i> <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">

                                <!-- Temp Language -->
                                <li class="nav-subitem" title="{{trans('file.language')}}">
                                    <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item dropdown-item2">
                                        <i class="dripicons-web"></i> {{trans('file.language')}}
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <ul class="dropdown-menu edit-options dropdown-menu-left dropdown-default" user="menu">
                                        <li>
                                            <a href="{{ url('language_switch/en') }}" class="btn btn-link"> English</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('language_switch/ar') }}" class="btn btn-link"> عربى</a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Location -->
                                <li class="nav-subitem"><a id="btnLocation" title="{{trans('file.Warehouse')}}"><i class="fa fa-map-marker"></i>{{trans('file.Warehouse')}}</a></li>

                                <!-- Role -->
                                <li class="nav-subitem"><a id="btnRole" title="{{trans('file.Role')}}"><i class="fa fa-users"></i>{{trans('file.Role')}}</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link"><i class="fa fa-building"></i>
                                <span class="company-notify">{{ $userGeneralSetting->company->name ?? 'Company' }}</span> <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @foreach ($lims_company_list as $company)
                                    @if ($company->id ?? false)
                                        <li>
                                            <a href="{{ route('user.default-company.change', ['id' => $company->id]) }}" class="btn btn-link"> {{ $company->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>

                        <!-- Language -->
                        <li class="nav-item" title="{{trans('file.language')}}">
                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item dropdown-item2"><i class="dripicons-web"></i> <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <a href="{{ url('language_switch/en') }}" class="btn btn-link"> English</a>
                                </li>
                                <li>
                                    <a href="{{ url('language_switch/ar') }}" class="btn btn-link"> عربى</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
    @yield('scripts')
    <style>
      .sticky {
        position: fixed!important;
        top: 0!important;
        width: 100%!important;
        z-index: 9999;
        // margin-bottom: 60px!important;
      }

      .content{
        margin-top: 60px!important;
        // top: 30px;
      }

    </style>
    <script>
      window.onscroll = function() {myScrollFunction()};

      var navbar = document.getElementById("navbar");
      var content = document.getElementById("content");
      var sticky = navbar.offsetTop;

      function myScrollFunction() {
        if (window.pageYOffset >= sticky) {
          navbar.classList.add("sticky")
          content.classList.add("content")
        } else {
          navbar.classList.remove("sticky");
          content.classList.remove("content");
        }
      };
    </script>

    <script type="text/javascript">

      var alert_product = <?php echo json_encode($alert_product) ?>;

      if ($(window).outerWidth() > 1199) {
          $('nav.side-navbar').addClass('shrink');
          $('.page').toggleClass('active');
      }
      else {
            $('nav.side-navbar').addClass('shrink');
            $('.page').toggleClass('active-sm');
      }
      function myFunction() {
          setTimeout(showPage, 150);
      }

      function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("content").style.display = "block";
      }

      $("div.alert").delay(3000).slideUp(750);

      function confirmDelete() {
          if (confirm("Are you sure want to delete?")) {
              return true;
          }
          return false;
      }

      $("li#notification-icon").on("click", function (argument) {
          $.get('notifications/mark-as-read', function(data) {
              $("span.notification-number").text(alert_product);
          });
      });

      $("a#add-expense").click(function(e){
        e.preventDefault();
        $('#expense-modal').modal();
      });

      $("a#send-notification").click(function(e){
        e.preventDefault();
        $('#notification-modal').modal();
      });

      $("a#add-account").click(function(e){
        e.preventDefault();
        $('#account-modal').modal();
      });

      $("a#account-statement").click(function(e){
        e.preventDefault();
        $('#account-statement-modal').modal();
      });

      $("a#profitLoss-link").click(function(e){
        e.preventDefault();
        $("#profitLoss-report-form").submit();
      });

      $("a#profitLossLocation-link").click(function(e){
        e.preventDefault();
        $("#profitLossLocation-report-form").submit();
      });

      $("a#report-link").click(function(e){
        e.preventDefault();
        $("#product-report-form").submit();
      });

      $("a#purchase-report-link").click(function(e){
        e.preventDefault();
        $("#purchase-report-form").submit();
      });

      $("a#all_customer_due").click(function(e){
        e.preventDefault();
        $("#all_customer_due").submit();
      });

      $("a#product_cost_report").click(function(e){
        e.preventDefault();
        $("#product_cost_report").submit();
      });

      $("a#all_stock_ability_due").click(function(e){
        e.preventDefault();
        $("#all_stock_ability_due").submit();
      });

      $("a#sale-report-link").click(function(e){
        e.preventDefault();
        $("#sale-report-form").submit();
      });

      $("a#payment-report-link").click(function(e){
        e.preventDefault();
        $("#payment-report-form").submit();
      });

      $("a#warehouse-report-link").click(function(e){
        e.preventDefault();
        $('#warehouse-modal').modal();
      });

      $("a#user-report-link").click(function(e){
        e.preventDefault();
        $('#user-modal').modal();
      });

      $("a#customer-report-link").click(function(e){
        e.preventDefault();
        $('#customer-modal').modal();
      });

      $("a#supplier-report-link").click(function(e){
        e.preventDefault();
        $('#supplier-modal').modal();
      });

      $("a#due-report-link").click(function(e){
        e.preventDefault();
        $("#due-report-form").submit();
      });

      $(".daterangepicker-field").daterangepicker({
          callback: function(startDate, endDate, period){
            var start_date = startDate.format('YYYY-MM-DD');
            var end_date = endDate.format('YYYY-MM-DD');
            var title = start_date + ' To ' + end_date;
            $(this).val(title);
            $('#account-statement-modal input[name="start_date"]').val(start_date);
            $('#account-statement-modal input[name="end_date"]').val(end_date);
          }
      });

      $('.selectpicker').selectpicker({
          style: 'btn-link',
      });
    </script>
  </body>
</html>
