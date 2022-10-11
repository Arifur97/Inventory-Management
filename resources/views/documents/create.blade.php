@extends('layout.main') @section('content')
<section class="forms">
    <!--- header section  --->
    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Add Document')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <a href="{{route('documents.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
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
                <div class="col-md-6 float-left">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <!-- <canvas id="pdfViewer"></canvas> -->
                                        <div class="gallery"></div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 float-left">
                    <div class="card">
                        <div class="card-body">
                            <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                            {!! Form::open(['route' => 'documents.store', 'method' => 'post', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{trans('file.Document Type')}} <i class="fa fa-asterisk"></i></label>
                                                <select required name="document_type_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Document Type...">
                                                    @foreach($lims_document_type_list as $document_type)
                                                    <option value="{{$document_type->id}}">{{$document_type->document_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{trans('file.Employee')}}</label>
                                                <select name="employee_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Employee...">
                                                    @foreach($lims_employee_list as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{trans('file.Document Title')}} <i class="fa fa-asterisk"></i></label>
                                                <input type="text" required name="document_title" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{trans('file.Issue Date')}}</label>
                                                <input type="date" name="issue_date" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{trans('file.Expiry Date')}}</label>
                                                <input type="date" name="expiry_date" class="form-control" />
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{trans('file.Notification')}}</label>
                                                <select required name="is_notify" class="selectpicker form-control">                                                    
                                                    <option value="1">Yes</option>                                                   
                                                    <option value="0">No</option>                                                   
                                                </select>                                               
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{trans('file.Notify Days')}}</label>
                                                <select name="notify_before_days" class="selectpicker form-control" id="dateSelector" title="Select Days...">                                                  
                                                    <option value="15">Before 15 days</option>                                                   
                                                    <option value="30">Before 30 days</option>                                                   
                                                    <option value="60">Before 60 days</option>                                                   
                                                    <option value="custom">Custom Days</option>                                                   
                                                </select>    
                                                <input type="text" class="hide form-control mt-2" placeholder="Custom Days" name="custom" id="customInput">                                    
                                            </div>
                                        </div>                                          
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{trans('file.Document File')}} *</label>
                                                <!-- <input type="file" name="document_file" id="myPdf" multiple class="form-control" /> -->
                                                <input type="file" name="document_file[]" multiple id="myPdf" class="form-control" onchange="selectMultipleFile(this);" />

                                                <label class="mt-3">{{trans('file.Documents Attached')}}</label>

                                                <div id="selectedFile" class="mb-4"></div>

                                                <script>
                                                    var selectedFileNode = document.getElementById("selectedFile");
                                                    let filename = [];
                                                    var data   = new FormData();
                                                    function showFileName() {
                                                        for(var i = 0; i < filename.length; i++) {
                                                            $('#selectedFile').append(
                                                                '<div class="col-md-10 float-left"><a class="document-text" onclick="viewfile(this, ' + i + ');">' + filename[i].name + '</a></div> <div class="col-md-2 float-left"><i class="dripicons-trash" onclick="removeMyTableFile(' + i + ')"></i><div">'
                                                            )
                                                        }
                                                        document.getElementById("notification").innerHTML = filename.length;
                                                    }


                                                    function viewfile(item, i) {
                                                        const reader = new FileReader();
                                                        reader.addEventListener('load', function () {
                                                            item.setAttribute('href', this.result)
                                                            debugBase64(this.result)
                                                        })

                                                        reader.readAsDataURL(filename[i]);
                                                    }

                                                    function debugBase64(base64URL){
                                                        var win = window.open();
                                                        win.document.write('<iframe src="' + base64URL  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
                                                    }

                                                    function selectMultipleFile(file) {
                                                        selectedFileNode.innerHTML = '';
                                                        var files = $(file)[0].files;
                                                        for (var i = 0; i < files.length; i++) {
                                                            filename.push(files[i]);
                                                        }
                                                        showFileName();
                                                    }

                                                    function removeMyTableFile(i) {
                                                        var parent = document.getElementById('selectedFile');
                                                        while (parent.firstChild) {
                                                            parent.removeChild(parent.firstChild);
                                                        }
                                                        filename.splice(i, 1);
                                                        showFileName();
                                                    }

                                                    function removeExistingFileName(existfilename) {
                                                        alert("{{trans('file.Are you sure to delete the attachment?')}}");
                                                        existfilename.parentElement.parentElement.remove()
                                                    }

                                                </script>
                                                
                                            </div>
                                        </div>                                      
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{trans('file.Note')}}</label>
                                                <textarea rows="5" class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="submit-btn">{{trans('file.submit')}}</button>
                                    </div>
                                </div>
                            </div>
                                                
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    
    var dateSelector = document.getElementById('dateSelector');
    var customInput = document.getElementById('customInput');

    dateSelector.addEventListener('change', function(){
        if(this.value == "custom") {
            customInput.classList.remove('hide');
        } else {
            customInput.classList.add('hide');
        }
    })

    $(function() {
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<embed style="height: 280px; width: 280px; float: left; margin: 10px; border-radius: 10px; "></embed>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);                                             
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#myPdf').on('change', function() {
            imagesPreview(this, 'div.gallery');
        });
    });

    // $("#myPdf").on("change", function(e){
    //     var file = e.target.files[0]
    //     if(file.type == "application/pdf"){
    //         var fileReader = new FileReader();  
    //         fileReader.onload = function() {
    //             var pdfData = new Uint8Array(this.result);
    //             // Using DocumentInitParameters object to load binary data.
    //             var loadingTask = pdfjsLib.getDocument({data: pdfData});
    //             loadingTask.promise.then(function(pdf) {
    //             console.log('PDF loaded');
                
    //             // Fetch the first page
    //             var pageNumber = 1;
    //             pdf.getPage(pageNumber).then(function(page) {
    //                 console.log('Page loaded');
                    
    //                 var scale = 1.5;
    //                 var viewport = page.getViewport({scale: scale});

    //                 // Prepare canvas using PDF page dimensions
    //                 var canvas = $("#pdfViewer")[0];
    //                 var context = canvas.getContext('2d');
    //                 canvas.height = viewport.height;
    //                 canvas.width = viewport.width;

    //                 // Render PDF page into canvas context
    //                 var renderContext = {
    //                 canvasContext: context,
    //                 viewport: viewport
    //                 };
    //                 var renderTask = page.render(renderContext);
    //                 renderTask.promise.then(function () {
    //                 console.log('Page rendered');
    //                 });
    //             });
    //             }, function (reason) {
    //             // PDF loading error
    //             console.error(reason);
    //             });
    //         };
    //         fileReader.readAsArrayBuffer(file);
    //     }
    // });

</script>
@endsection
