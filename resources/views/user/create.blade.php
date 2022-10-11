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
                        <h3>{{trans('file.Add User')}}</h3>
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
                        {!! Form::open(['route' => 'user.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{ trans('file.UserName') }} *</strong> </label>
                                    <input type="text" name="name" required class="form-control">
                                    @if ($errors->has('name'))
                                        <span>
                                            <strong class="existing-error">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><strong>{{ trans('file.Password') }} *</strong> </label>
                                    <div class="input-group">
                                        <input type="password" name="password" required class="form-control">
                                        <div class="input-group-append">
                                            <button id="genbutton" type="button"
                                                class="btn btn-default">{{ trans('file.Generate') }}</button>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span>
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>{{ trans('file.Email') }} *</strong></label>
                                    <input type="email" name="email" placeholder="example@example.com" required
                                        class="form-control">
                                    @if ($errors->has('email'))
                                        <span>
                                            <strong class="existing-error">{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><strong>{{ trans('file.Phone Number') }} *</strong></label>
                                    <input type="text" name="phone_number" required class="form-control">
                                    @if ($errors->has('phone_number'))
                                        <span>
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="customer-section">
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Address') }} *</strong></label>
                                        <input type="text" name="address" class="form-control customer-input">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.State') }}</strong></label>
                                        <input type="text" name="state" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Country') }}</strong></label>
                                        <input type="text" name="country" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="mt-2" type="checkbox" name="is_active" value="1" checked>
                                    <label class="mt-2"><strong>{{ trans('file.Active') }}</strong></label>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{ trans('file.Company Name') }}</strong></label>
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
                                    <select name="default_warehouse_id" class="selectpicker form-control"
                                        id="default_warehouse_id" title="Select Default Warehouse...">
                                        @foreach ($lims_warehouse_list as $warehouse)
                                            <option value="{{ $warehouse->id }}"
                                                name="{{ $warehouse->company_id }}" style="display: none">
                                                {{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label><strong>{{ trans('file.Role') }} *</strong></label>
                                    <select name="role_id" required class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins" title="Select Role...">
                                        @foreach ($lims_role_list as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="customer-section">
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Customer Group') }} *</strong></label>
                                        <select name="customer_group_id"
                                            class="selectpicker form-control customer-input" data-live-search="true"
                                            data-live-search-style="begins" title="Select customer_group...">
                                            @foreach ($lims_customer_group_list as $customer_group)
                                                <option value="{{ $customer_group->id }}">
                                                    {{ $customer_group->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.name') }} *</strong></label>
                                        <input type="text" name="customer_name" class="form-control customer-input">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Tax Number') }}</strong></label>
                                        <input type="text" name="tax_number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.City') }} *</strong></label>
                                        <input type="text" name="city" class="form-control customer-input">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Postal Code') }}</strong></label>
                                        <input type="text" name="postal_code" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group" id="biller-id">
                                    <label><strong>{{ trans('file.Biller') }} *</strong></label>
                                    <select name="biller_id" required class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins"
                                        title="Select Biller...">
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
    $("ul#people #user-create-menu").addClass("active");

    $('#biller-id').hide();
    $('.customer-section').hide();
    $('#default_company').hide();
    $('#default_warehouse').hide();

    $('.selectpicker').selectpicker({
        style: 'btn-link',
    });

    $('#genbutton').on("click", function() {
        $.get('genpass', function(data) {
            $("input[name='password']").val(data);
        });
    });

    $('select[name="role_id"]').on('change', function() {
        if ($(this).val() == 5) {
            $('#biller-id').hide(300);
            $('.customer-section').show(300);
            $('.customer-input').prop('required', true);
            $('select[name="biller_id"]').prop('required', false);
        } else if ($(this).val() > 2 && $(this).val() != 5) {
            $('select[name="biller_id"]').prop('required', true);
            $('#biller-id').show(300);
            $('.customer-section').hide(300);
            $('.customer-input').prop('required', false);
        } else {
            $('select[name="biller_id"]').prop('required', false);
            $('#biller-id').hide(300);
            $('.customer-section').hide(300);
            $('.customer-input').prop('required', false);
        }
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
        companies.forEach(e => {
            let warehouseOption = $(`#warehouse option[name="${e}"]`);
            for (let i = 0; i < warehouseOption.length; i++) {
                warehouseOption[i].style.display = "block"
            }
        })

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
