@extends('layout.main') @section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">

    <!--- header section  --->
    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Update User')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <a href="{{route('user.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            <button type="button" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => ['user.update', $lims_user_data->id], 'method' => 'put', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{trans('file.UserName')}}</strong></label><i class="fa fa-asterisk"></i>
                                        <input type="text" name="name" required class="form-control" value="{{$lims_user_data->name}}">
                                        @if($errors->has('name'))
                                       <span>
                                           <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Change Password')}}</strong> </label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control">
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-default">{{trans('file.Generate')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label><strong>{{trans('file.Email')}}</strong></label><i class="fa fa-asterisk"></i>
                                        <input type="email" name="email" placeholder="example@example.com" required class="form-control" value="{{$lims_user_data->email}}">
                                        @if($errors->has('email'))
                                       <span>
                                           <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group mt-3">
                                        <label><strong>{{trans('file.Phone Number')}}</strong></label><i class="fa fa-asterisk"></i>
                                        <input type="text" name="phone" required class="form-control" value="{{$lims_user_data->phone}}">
                                    </div>
                                    <div class="form-group">
                                        @if($lims_user_data->is_active)
                                        <input class="mt-2" type="checkbox" name="is_active" value="1" checked>
                                        @else
                                        <input class="mt-2" type="checkbox" name="is_active" value="1">
                                        @endif
                                        <label class="mt-2"><strong>{{trans('file.Active')}}</strong></label>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Company Name') }}</strong></label>
                                        <input type="hidden" name="company_id_hidden"
                                            value="{{ $lims_user_data->company_id }}">
                                        <select name="company_id[]" required class="selectpicker form-control" id="company"
                                            data-live-search="true" data-live-search-style="begins"
                                            title="Select Companies..." multiple>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="default_company">
                                        <label><strong>{{ trans('file.Default Company') }}</strong></label>
                                        <input type="hidden" name="default_company_id_hidden"
                                            value="{{ $lims_user_data->default_company_id }}">
                                        <select name="default_company_id" class="form-control" id="default_company_id"
                                            title="Select Default Company...">
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}" style="display: none">
                                                    {{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="warehouseId">
                                        <label><strong>{{ trans('file.Warehouse') }}</strong></label>
                                        <input type="hidden" name="warehouse_id_hidden"
                                            value="{{ $lims_user_data->warehouse_id }}">
                                        <select name="warehouse_id[]" class="selectpicker form-control" id="warehouse"
                                            data-live-search="true" data-live-search-style="begins"
                                            title="Select Warehouse..." multiple>
                                            @foreach ($lims_warehouse_list as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    name="{{ $warehouse->company_id }}" style="display: none">
                                                    {{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="default_warehouse">
                                        <label><strong>{{ trans('file.Default Warehouse') }}</strong></label>
                                        <input type="hidden" name="default_warehouse_id_hidden"
                                            value="{{ $lims_user_data->default_warehouse_id }}">
                                        <select name="default_warehouse_id" class="selectpicker form-control"
                                            id="default_warehouse_id" title="Select Default Warehouse...">
                                            @foreach ($lims_warehouse_list as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    name="{{ $warehouse->company_id }}" style="display: none">
                                                    {{ $warehouse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Role') }} *</strong></label>
                                        <input type="hidden" name="role_id_hidden"
                                            value="{{ $lims_user_data->role_id }}">
                                        <select name="role_id" required class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="begins" title="Select Role...">
                                            @foreach ($lims_role_list as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="biller-id">
                                        <label><strong>{{ trans('file.Biller') }} *</strong></label>
                                        <input type="hidden" name="biller_id_hidden"
                                            value="{{ $lims_user_data->biller_id }}">
                                        <select name="biller_id" class="selectpicker form-control" data-live-search="true"
                                            data-live-search-style="begins" title="Select Biller...">
                                            @foreach ($lims_biller_list as $biller)
                                                <option value="{{ $biller->id }}">{{ $biller->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#people").siblings('a').attr('aria-expanded', 'true');
    $("ul#people").addClass("show");
    $('#biller-id').hide();

    // $('#default_company').hide();
    // $('#default_warehouse').hide();



    $('select[name=role_id]').val($("input[name='role_id_hidden']").val());
    if ($('select[name=role_id]').val() > 2) {
        $('#warehouseId').show();
        $('select[name=warehouse_id]').val($("input[name='warehouse_id_hidden']").val());
        $('#biller-id').show();
        $('select[name=biller_id]').val($("input[name='biller_id_hidden']").val());
    }

    let selectedDefaultCompanyId = $("input[name='default_company_id_hidden']").val()
    let companies = JSON.parse($("input[name='company_id_hidden']").val());
    $('select[name="company_id[]"]').val(companies);
    let companyOptions = $(`#default_company_id option`);
    for (let i = 0; i < companyOptions.length; i++) {
        companyOptions[i].style.display = "none";
    }
    if (companies.length == 1) {
        $("#default_company_id").val(companies[0]).change();
    } else if (companies.length >= 2) {
        companies.forEach(e => {
            $(`#default_company_id option[value="${e}"]`)[0].style.display = "block";
            if (selectedDefaultCompanyId == e) {
                $(`#default_company_id option[value="${e}"]`).attr("selected", "selected");
            }
        })
    }
    companies.forEach(e => {
        let warehouseOption = $(`#warehouse option[name="${e}"]`);
        for (let i = 0; i < warehouseOption.length; i++) {
            warehouseOption[i].style.display = "block"
        }
    })

    let selectedDefaultWarehouseId = $("input[name='default_warehouse_id_hidden']").val()
    let warehouses = JSON.parse($("input[name='warehouse_id_hidden']").val());
    $('select[name="warehouse_id[]"]').val(warehouses);
    let warehouseOptions = $(`#default_warehouse_id option`);
    for (let i = 0; i < warehouseOptions.length; i++) {
        warehouseOptions[i].style.display = "none";
    }
    if (warehouses.length == 1) {
        $("#default_warehouse_id").val(warehouses[0]).change();
    } else if (warehouses.length >= 2) {
        warehouses.forEach(e => {
            $(`#default_warehouse_id option[value="${e}"]`)[0].style.display = "block";
            if (selectedDefaultWarehouseId == e) {
                $(`#default_warehouse_id option[value="${e}"]`).attr("selected", "selected");
            }
        })
    }

    $('.selectpicker').selectpicker('refresh');

    $('select[name="role_id"]').on('change', function() {
        if ($(this).val() > 2) {
            $('select[name="warehouse_id"]').prop('required', true);
            $('select[name="biller_id"]').prop('required', true);
            $('#biller-id').show();
            $('#warehouseId').show();
        } else {
            $('select[name="warehouse_id"]').prop('required', false);
            $('select[name="biller_id"]').prop('required', false);
            $('#biller-id').hide();
            $('#warehouseId').hide();
        }
    });

    $('#genbutton').on("click", function() {
        $.get('../genpass', function(data) {
            $("input[name='password']").val(data);
        });
    });

    $('select[name="company_id[]"]').on('change', function() {
        let companies = $(this).val();
        let companyOptions = $(`#default_company_id option`);
        for (let i = 0; i < companyOptions.length; i++) {
            companyOptions[i].style.display = "none";
        }
        if (companies.length == 1) {
            $("#default_company_id").val(companies[0]).change();
        } else if (companies.length >= 2) {
            companies.forEach(e => {
                $(`#default_company_id option[value="${e}"]`)[0].style.display = "block";
            })
            $('#default_company').show(300);
        }
        let warehouseOptionIds = $(`#warehouse option`);
        for (let i = 0; i < warehouseOptionIds.length; i++) {
            warehouseOptionIds[i].style.display = "none";
        }
        companies.forEach(e => {
            let warehouseOption = $(`#warehouse option[name="${e}"]`);
            console.log(warehouseOption);
            for (let i = 0; i < warehouseOption.length; i++) {
                warehouseOption[i].style.display = "block"
            }
        })
        $(`#warehouse`).val('').change();
        $(`#default_warehouse_id`).val('').change();

        $('#default_company_id').selectpicker('refresh');
        $('#warehouse').selectpicker('refresh');
    });

    $('select[name="warehouse_id[]"]').on('change', function() {
        let warehouse = $(this).val();
        let warehouseOptions = $(`#default_warehouse_id option`);
        for (let i = 0; i < warehouseOptions.length; i++) {
            warehouseOptions[i].style.display = "none";
        }
        if (warehouse.length == 1) {
            $("#default_warehouse_id").val(warehouse[0]).change();
        } else if (warehouse.length >= 2) {
            $('#default_warehouse').show(300);
            warehouse.forEach(e => {
                $(`#default_warehouse_id option[value="${e}"]`)[0].style.display = "block";
            })
        }
        $('#default_warehouse_id').selectpicker('refresh');
    });
</script>
@endsection
