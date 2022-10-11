@extends('layout.main') @section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section class="forms">
        <!--- header section  --->
        <div class="row ">
            <div class="col-md-12 item-sticky">
                <div class="card ">
                    <div class="card-body item-page">
                        <div class="float-left brand-text mt-2 pl-4">
                            <h3>{{ trans('file.Add Shortcuts') }}</h3>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <a href="{{ route('role.index') }}" class="btn buttons-add"><i
                                        class="fa fa-times mr-1"></i>
                                    {{ trans('file.Cancel') }}</a>
                                <button type="button" id="submit-btn" class="btn btn-primary"><i
                                        class="fa fa-check mr-1"></i>{{ trans('file.submit') }}</button>
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
                                <p class="italic">
                                    <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                                </p>
                                {!! Form::open(['route' => ['role.permission.shortcuts.update', $lims_role_data->id], 'method' => 'post', 'files' => true]) !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{ trans('file.Role Name') }} *</strong> </label>
                                            <input type="text" name="role" required class="form-control"
                                                value="{{ $lims_role_data->name }}" readonly>
                                            @if ($errors->has('name'))
                                                <span>
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>{{ trans('file.Form permission') }} *</strong> </label>
                                            <input type="text" name="permission" required class="form-control"
                                                value="{{ $permisisons_str }}" readonly>
                                            @if ($errors->has('name'))
                                                <span>
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>{{ trans('file.Shortcuts') }} *</strong> </label>
                                            <select required name="shortcut[]" class="selectpicker form-control"
                                                data-live-search="true" data-live-search-style="begins"
                                                title="Select Shortcut..." multiple>
                                                @foreach ($lims_shortcut_all as $shortcut)
                                                    <option value="{{ $shortcut->id }}" @if(in_array($shortcut->id, $lims_role_data['shortcut']??[])) selected @endif>{{ $shortcut->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" value="{{ trans('file.submit') }}"
                                                class="btn btn-primary">
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

    <script type="text/javascript"></script>
@endsection
