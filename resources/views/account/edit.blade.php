@extends('layout.main')
@section('content')
<section class="forms">

    <!--- header section  --->

    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Update Account')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <a href="{{route('accounts.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            <button type="button" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
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
                        {!! Form::open(['route' => ['accounts.update', $lims_account_all->id ], 'method' => 'put']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.name')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" name="name" required class="form-control" value="{{ $lims_account_all->name }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Account No')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" name="account_no" required class="form-control" value="{{ $lims_account_all->account_no }}" />
                                            <input type="hidden" name="account_id" value="{{ $lims_account_all->id }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Account Category')}} *</label>
                                            <input type="hidden" name="account_category_id_hidden" value="{{$lims_account_all->account_category_id}}" />
                                            <select required name="account_category_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Account Category...">
                                                @foreach($lims_account_category_all as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Entry Type')}} *</label>
                                            <input type="hidden" name="default_entry_type_hidden" value="{{$lims_account_all->default_entry_type}}" />
                                            <select required name="default_entry_type" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select default entry type...">
                                                <option value="0">Dr</option>
                                                <option value="1">Cr</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Initial Balance')}}</label>
                                            <input type="number" name="initial_balance" step="any" class="form-control" value="{{ $lims_account_all->initial_balance }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Company')}} *</label>
                                            <input type="hidden" name="company_id_hidden" value="{{$lims_account_all->company_id}}" />
                                            <select required name="company_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Company...">
                                                @foreach($lims_company_all as $company)
                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label>{{trans('file.Currency')}} *</label>
                                            <input type="hidden" name="currency_id_hidden" value="{{$lims_account_all->currency_id}}" />
                                            <select required name="currency_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Currency...">
                                                @foreach($lims_currency_all as $currency)
                                                <option value="{{$currency->id}}">{{$currency->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Note')}}</label>
                                            <textarea name="note" rows="1" class="form-control">{{ $lims_account_all->note }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Description')}}</label><i class="fa fa-asterisk"></i>
                                            <textarea rows="5" class="form-control" name="description">{{ $lims_account_all->description }}</textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
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

    $('select[name="default_entry_type"]').val($('input[name="default_entry_type_hidden"]').val());
    $('select[name="account_category_id"]').val($('input[name="account_category_id_hidden"]').val());
    $('select[name="currency_id"]').val($('input[name="currency_id_hidden"]').val());
    $('select[name="company_id"]').val($('input[name="company_id_hidden"]').val());

	$('.selectpicker').selectpicker({
	    style: 'btn-link',
	});


</script>
@endsection
