@extends('layout.main')
@section('content')
@if (session()->has('not_permitted'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
            data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

    <section class="forms">
        <form action="{{ route('product.shelf_location.update', ['id' => $shelfLocation->id]) }}" method="post">
            @csrf
            <div class="">
                <div class="row item-sticky">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-body item-page">
                                <div class="float-left brand-text mt-2 pl-4">
                                    <h3>{{ trans('file.Update Shelf Location') }}</h3>
                                </div>
                                <div class="float-right mr-2">
                                    <a href="{{ route('item_requirement.index') }}">
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close" data-toggle="tooltip" title="{{ trans('file.Use ctrl+q to quit') }}"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                                    </a>

                                </div>
                                <div class="float-right mr-2">
                                    <div class="form-group">
                                        <a href="{{route('product.shelf_location')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn" data-toggle="tooltip" title="{{ trans('file.Use ctrl+s to update') }}"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>{{ trans('file.update') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table id="shelfLocationTable" class="table table-hover order-list">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.id') }}</th>
                                        <th>{{ trans('file.Image') }}</th>
                                        <th>{{ trans('file.name') }}</th>
                                        <th>{{ trans('file.Code') }}</th>
                                        <th>{{ trans('file.Unit') }}</th>
                                        <th>{{ trans('file.Variant') }}</th>
                                        <th>{{ trans('file.Warehouse') }}</th>
                                        <th>{{ trans('file.Shelf A') }}</th>
                                        <th>{{ trans('file.Shelf B') }}</th>
                                        <th>{{ trans('file.Shelf C') }}</th>
                                        <th>{{ trans('file.Shelf D') }}</th>
                                        <th>{{ trans('file.Note') }}</th>
                                        <th>{{ trans('file.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div class="form">
                                        <tr>
                                            <td>{{ $shelfLocation->id }}</td>
                                            <td>
                                                <img src="{{ asset('/images/product/' . $shelfLocation->product->image) }}"
                                                    alt="product image" class="product_image" width="80" height="80" />
                                            </td>
                                            <td>{{ $shelfLocation->product->name }}</td>
                                            <td>{{ $shelfLocation->product->code }}</td>
                                            <td>{{ $shelfLocation->product->unit->unit_name }}</td>

                                            @if($shelfLocation->variant_id)
                                            <td>{{ $shelfLocation->variant->name }}</td>
                                            @else
                                            <td>N/A</td>
                                            @endif

                                            <td>
                                                <select name="warehouse_id" class="form-control" required>';
                                                    <option disabled selected>Select</option>';
                                                    @foreach ($shelfLocation->warehouses as $li)
                                                        <option value="{{ $li->id }}"
                                                            @if ($li->id == $shelfLocation->warehouse_id) selected @endif>
                                                            {{ $li->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $shelfLocation->position_A }}" name="shelfA">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $shelfLocation->position_B }}" name="shelfB">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $shelfLocation->position_C }}" name="shelfC">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $shelfLocation->position_D }}" name="shelfD">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $shelfLocation->note }}" name="pnote">
                                            </td>
                                            <td>
                                                <a href="{{ route('product.shelf_location.destroy', ['id' => $shelfLocation->id]) }}"
                                                    onclick="return confirm('are you sure? you want to delete this!')"><button
                                                        type="button" class="ibtnDel btn btn-md btn-danger"><i
                                                            class="dripicons-trash"></i></button></a>
                                            </td>
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </section>
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #shelflocation-create-menu").addClass("active");

        $(window).keydown(function(e) {
            if (e.which == 13) {
                var $targ = $(e.target);
                if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                    var focusNext = false;
                    $(this).find(":input:visible:not([disabled],[readonly]), a").each(function() {
                        if (this === e.target) {
                            focusNext = true;
                        } else if (focusNext) {
                            $(this).focus();
                            return false;
                        }
                    });
                    return false;
                }
            }
        });
    </script>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@endsection
