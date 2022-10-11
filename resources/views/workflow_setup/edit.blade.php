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
                        <h3>{{trans('file.Update Workflow')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <a href="{{route('workflow.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
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
                        {!! Form::open(['route' => ['workflow.update', $lims_workflow_data->id], 'method' => 'put', 'files' => true]) !!}
                        @php $formname = \App\FormName::find($lims_workflow_data->form_id); @endphp

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Form Name')}}</label>
                                    <p><strong>{{ $formname->name }}</strong></p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Is Active')}}</label>
                                    <select name="is_active" class="selectpicker form-control" id="formNameIsActive">
                                        <option value="1" @if($lims_workflow_data->is_active == '1') selected @endif>{{trans('file.Yes')}}</option>
                                        <option value="0" @if($lims_workflow_data->is_active == '0') selected @endif>{{trans('file.No')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <p class="italic"><small>{{trans('file.Select below to add stages')}}.</small></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Designation')}}</label>
                                    <select name="formNameDesignation" class="selectpicker form-control" title="Select Designation..." id="formNameDesignation">
                                        @foreach($lims_designation_list as $designation)
                                            <option value="{{$designation->id}}">{{$designation->designation_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.User')}}</label>
                                    <select name="formNameUser" class="selectpicker form-control" title="Select User..." id="formNameUser">
                                        <option value="0" Selected>None</option>
                                        @foreach($lims_user_list as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                                <div class="row">

                                    <div>
                                        <div class="form-group">
                                            <button type="button" class="btn buttons-print" id="addStage" onclick="formNameAddToTable();"><i class="dripicons-plus"></i> {{trans('file.Add Stage')}}</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">

                                    <h5>{{trans('file.Stages')}} *</h5>
                                    <div class="table-responsive mt-3">
                                        <table id="myTable" class="table table-hover order-list">
                                            <thead>
                                                <tr>
                                                    <th class="not-exported"></th>
                                                    <th>{{trans('file.Stage')}}</th>
                                                    <th>{{trans('file.Designation')}}</th>
                                                    <th>{{trans('file.User')}}</th>
                                                    <th><i class="dripicons-trash"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <script>
                                var i = 1;
                                function removeMyTableItem(designation) {
                                    var td = event.target.parentNode;
                                    var tr = td.parentNode;
                                    tr.parentNode.removeChild(tr);
                                    let k = 1;
                                    let f = true;
                                    let lastDesignation;
                                    $('#myTable tr').each(function(index) {
                                        if(!f) {
                                            var temp = $(this).children()[1];
                                            temp.innerText = k++;

                                            lastDesignation = $(this).children()[4];
                                        } else {
                                            f = false;
                                        }
                                    });
                                    i = k;
                                    let l;
                                    var op = document.getElementById("formNameDesignation").getElementsByTagName("option");
                                    for (l = 0; l < op.length; l++) {
                                        op[l].disabled = false;
                                        if (op[l].value == lastDesignation.value) {
                                            op[l].disabled = true;
                                        }
                                    }
                                    $('.selectpicker').selectpicker('refresh');
                                }
                                function formNameAddToTable() {
                                    if($('select[name="formNameDesignation"]').val() != null && $('select[name="formNameDesignation"]').val() != '') {
                                        // get values from select field
                                        // var workflowFormNameSelect = document.getElementById('formName');
                                        var workflowUserSelect = document.getElementById('formNameUser');
                                        var workflowDesignationSelect = document.getElementById('formNameDesignation');

                                        // First check if a <tbody> tag exists, add one if not
                                        if ($("#myTable tbody").length == 0) {
                                            $("#myTable").append("<tbody></tbody>");
                                        }

                                        // Append product to the table
                                        $("#myTable tbody").append("<tr>" +
                                            "<td>" + "</td>" +
                                            "<td class='stage'>" + i + "</td>" + '<input type="hidden" name="stage[]" value="' + i + '" />' +
                                            "<td class='designation'>" + workflowDesignationSelect.options[workflowDesignationSelect.selectedIndex].text + "</td>" +  '<input type="hidden" name="designation[]" value="' + workflowDesignationSelect.value + '" />' +
                                            "<td class='user_id'>" + workflowUserSelect.options[workflowUserSelect.selectedIndex].text + "</td>" + '<input type="hidden" name="user_id[]" value="' + workflowUserSelect.value + '" />' +
                                            "<td>" + '<i class="dripicons-trash workflow_data" onclick="removeMyTableItem(\'' + workflowDesignationSelect.value + '\')"></i>' + "</td>" +
                                            "</tr>");

                                        i++;

                                        // disable designation item if have
                                        var op = document.getElementById("formNameDesignation").getElementsByTagName("option");
                                        for (var l = 0; l < op.length; l++) {
                                            op[l].disabled = false;
                                        }
                                        workflowDesignationSelect.options[workflowDesignationSelect.selectedIndex].disabled = true
                                        $('#formNameDesignation').selectpicker('val', '');
                                        $('.selectpicker').selectpicker('refresh');
                                    }
                                }
                            </script>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{trans('file.Note')}}</label>
                                        <textarea rows="5" class="form-control" name="note">{{ $lims_workflow_data->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn buttons-print" id="submit-button">
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
   $.ajax({
        type: 'GET',
        url: '/s2/workflow/stage-data/'+ window.location.pathname.split('/')[3],
        success: function(data) {
            tableBody = $("#myTable tbody");
            tableBody.empty();
            let l;
            for(l = 0; l < data.length; l++) {
                var col = '';
                col += "<tr>";
                col += "<td></td>";
                col += "<td class='stage'>" + data[l].stage + "</td>";
                col += '<input type="hidden" name="stage[]" value="' + data[l].stage + '" />';
                col += "<td class='designation'>" + data[l].designation_name + "</td>";
                col += '<input type="hidden" name="designation[]" value="' + data[l].designation_id + '" />';
                col += "<td class='user_id'>" + data[l].name + "</td>";
                col += '<input type="hidden" name="user_id[]" value="' + data[l].user_id + '" />';
                col += "<td>" + '<i class="dripicons-trash workflow_data" onclick="removeMyTableItem(\'' + data[l].designation_id + '\')"></i>' + "</td>";
                col += "</tr>";
                tableBody.append(col);
            }
            i = l + 1;
            // disable designation item if have
            var op = document.getElementById("formNameDesignation").getElementsByTagName("option");
            for (var j = 0; j < op.length; j++) {
                if (op[j].value == data[l-1].designation_id) {
                    op[j].disabled = true;
                }
            }
            $('.selectpicker').selectpicker('refresh');
        }
    });


    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $('#biller-id').hide();
    $('#warehouseId').hide();



    $('select[name=role_id]').val($("input[name='role_id_hidden']").val());
    if($('select[name=role_id]').val() > 2){
        $('#warehouseId').show();
        $('select[name=warehouse_id]').val($("input[name='warehouse_id_hidden']").val());
        $('#biller-id').show();
        $('select[name=biller_id]').val($("input[name='biller_id_hidden']").val());
    }
    $('.selectpicker').selectpicker('refresh');

    $('select[name="role_id"]').on('change', function() {
        if($(this).val() > 2){
            $('select[name="warehouse_id"]').prop('required',true);
            $('select[name="biller_id"]').prop('required',true);
            $('#biller-id').show();
            $('#warehouseId').show();
        }
        else{
            $('select[name="warehouse_id"]').prop('required',false);
            $('select[name="biller_id"]').prop('required',false);
            $('#biller-id').hide();
            $('#warehouseId').hide();
        }
    });

    $('#genbutton').on("click", function(){
      $.get('../genpass', function(data){
        $("input[name='password']").val(data);
      });
    });

</script>
@endsection
