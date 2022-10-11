@extends('layout.main')
@section('content')
<section class="forms">
    <!--- header section  --->
    {!! Form::open(['route' => 'expense_categories.store', 'method' => 'post', 'files' => true]) !!}
    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Add Expense Category')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <a href="{{route('expenses.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            <button type="submit" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{trans('file.Code')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" name="code" placeholder="Type expense category code..." required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{trans('file.name')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" name="name" placeholder="Type expense category name..." required class="form-control">
                                            <input type="hidden" name="is_active" value="1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label> {{trans('file.Account')}}</label>
                                            <select required name="account_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Account...">
                                                @foreach($lims_account_list as $account)
                                                    <option value="{{$account->id}}">{{$account->name}}</option>
                                                @endforeach
                                            </select>
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

</section>
<script type="text/javascript">

	$('.selectpicker').selectpicker({
	    style: 'btn-link',
	});

    // Ctrl+S and Cmd+S trigger Save button click
    $(document).keydown(function(e) {
        if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
        {
            e.preventDefault();
            // alert("Ctrl-s pressed");
            $("button[type=submit]").trigger('click');
            return false;
        }
        return true;
    });

    $('#genbutton').on("click", function(){
      $.get('/expense_categories/gencode', function(data){
        $("input[name='code']").val(data);
      });
    });

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

</script>
@endsection
