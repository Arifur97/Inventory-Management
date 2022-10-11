@extends('layout.main') @section('content')
@if (session()->has('not_permitted'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

    <section class="forms">
        {!! Form::open(['route' => 'multifile.store', 'method' => 'post', 'files' => true]) !!}
        <div>
            <div class="row item-sticky">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-body item-page">

                            <div class="float-right mr-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-save" id="submit-btn" data-toggle="tooltip" title="{{ trans('file.Use ctrl+s to save') }}"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i> {{ trans('file.Save') }}</button>
                                </div>
                            </div>
                            <div class="float-right mr-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="submit-btn"><i class="fa fa-check-square-o mr-2" aria-hidden="true"></i> {{ trans('file.Confirm') }}</button>
                                </div>
                            </div>
                            <div class="float-right mr-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary text-center" data-toggle="modal" data-target="#attachmentPopUp"><i class="fa fa-paperclip mr-2" aria-hidden="true"></i> {{ trans('file.Attachments') }} <span class="badge badge-danger notification-number" id="notification"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{ trans('file.Attach Document') }}</label> <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                                    <input type="text" name="documents_id" id="doucmentsId">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{ trans('file.Note') }}</label>
                                                    <textarea rows="5" class="form-control" name="note"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            {{-- Add Attachments --}}
            @include('multifile_management.partials.multifile_attachment_modal')
    </section>
@endsection
