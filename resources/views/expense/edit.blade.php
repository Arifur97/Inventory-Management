@extends('layout.main')
@section('content')
<section class="forms">
    <!--- header section  --->
    {!! Form::open(['route' => ['expenses.update', $lims_expense_all->id ], 'method' => 'put', 'files' => true]) !!}
    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Update Expense')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary text-center" data-toggle="modal" data-target="#attachmentPopUp"><i class="fa fa-paperclip mr-2" aria-hidden="true"></i> {{ trans('file.Attachments') }} <span class="badge badge-danger notification-number" id="notification"></span></button>
                            <a href="{{route('expenses.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            <button type="submit" id="save-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Expense Category')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="hidden" name="expense_category_id_hidden" value="{{$lims_expense_all->expense_category_id}}" />
                                            <select name="expense_category_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Expense Category..." onchange="changeExpenseCategory(this)">
                                                @foreach($lims_expense_category_list as $expense_category)
                                                    <option name="{{$expense_category->account_id}}" value="{{$expense_category->id}}">{{$expense_category->name . ' (' . $expense_category->code. ')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Warehouse')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="hidden" name="warehouse_id_hidden" value="{{$lims_expense_all->warehouse_id}}" />
                                            <select required name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                                @foreach($lims_warehouse_list as $warehouse)
                                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Amount')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="number" name="amount" step="any" required class="form-control" value="{{$lims_expense_all->amount}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> {{trans('file.Account')}}</label>
                                            <input type="hidden" name="account_id_hidden" value="{{$lims_expense_all->account_id}}" />
                                            <select name="accounts_id" id="account_list" class="selectpicker form-control" title="Select Account..." disabled >
                                                @foreach($lims_account_list as $account)
                                                    <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="account_id" id="account_list_input" readonly value="{{$lims_expense_all->account_id}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.User id')}}</label>
                                            <input type="text" value="{{ucfirst(Auth::user()->name)}}" class="form-control" readonly/>
                                            <input type="hidden" value="{{ucfirst(Auth::user()->id)}}" name="user_id" class="form-control" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('file.Company') }}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" class="form-control" value="{{ $lims_expense_all->company->name ?? '' }}" readonly />
                                            <input type="hidden" class="form-control" name="company_id" value="{{ $lims_expense_all->company->id ?? '' }}" readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-4 d-none">
                                        <div class="form-group">
                                            <label>{{ trans('file.Attach Document') }}</label>
                                            <i class="dripicons-question" data-toggle="tooltip"
                                                title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                            <input type="file" name="document" class="form-control" />
                                            <input type="hidden" name="document_id" id="documentId" class="form-control my-2" value="{{$lims_expense_all->document_id}}" />

                                            @if ($errors->has('extension'))
                                                <span>
                                                    <strong>{{ $errors->first('extension') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Description')}}</label>
                                            <textarea rows="5" class="form-control" name="description">{{$lims_expense_all->description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <!--- update Attachments --->
    @include(
        'multifile_management.partials.multifile_attachment_modal',
        [
            'route' => route('expenses.multifile.update'),
            'edit' => true,
            'documents' => $lims_expense_all->documents,
        ]
    )
</section>
<script type="text/javascript">

    $('select[name="accounts_id"]').val($('input[name="account_id_hidden"]').val());
    $('select[name="company_id"]').val($('input[name="company_id_hidden"]').val());
    $('select[name="expense_category_id"]').val($('input[name="expense_category_id_hidden"]').val());
    $('select[name="warehouse_id"]').val($('input[name="warehouse_id_hidden"]').val());

    // Ctrl+S and Cmd+S trigger Save button click
    $(document).keydown(function(e) {
        if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
        {
            e.preventDefault();
            // alert("Ctrl-s pressed");
            $("#save-btn").trigger('click');
            return false;
        }
        return true;
    });

	$('.selectpicker').selectpicker({
	    style: 'btn-link',
	});

    function changeExpenseCategory(item) {
        let selectedOption  = item.options[item.selectedIndex];
        let accountId = selectedOption.getAttribute('name');

        $('#account_list').val(accountId);
        $('#account_list').change();

        $('#account_list_input').val(accountId);
        $('#account_list_input').change();
    }


    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

</script>
@endsection
