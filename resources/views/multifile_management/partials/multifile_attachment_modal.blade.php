<div id="attachmentPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header item-page mb-4">
                <div class="col-md-12">
                    <div class="float-left brand-text mt-2">
                        <h3>{{ trans('file.Attachments') }}</h3>
                    </div>
                    <div class="float-right">
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="float-right">
                        <div class="form-group">
                            <button type="button" class="btn btn-save" title="{{ trans('file.Use ctrl+s to save') }}" onclick="@if ($edit ?? false) updateAttachmentsOnServer() @else saveAttachmentsOnServer() @endif"><i class="fa fa-floppy-o mr-1" aria-hidden="true"></i> {{ trans('file.Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('file.Attach Document') }}</label> <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                            <input type="file" multiple name="document[]" class="form-control mb-4"
                                onchange="selectMultipleFile(this);">
                            @if ($errors->has('extension'))
                                <span>
                                    <strong>{{ $errors->first('extension') }}</strong>
                                </span>
                            @endif

                            <label>{{ trans('file.Documents Attached') }}</label>

                            @if ($edit ?? false)
                                <?php
                                if ($documents != null) {
                                    $docs = explode(',', $documents->documents);
                                }
                                ?>

                                @if ($docs ?? false)
                                    @foreach ($docs as $doc)
                                        <div class="row">
                                            <div class="col-md-10 float-left">
                                                <a href="/{{ $doc }}" target="_blank" class="document-text prev__doc-item">{{ $doc }}</a>
                                            </div>
                                            <input type="hidden" class="edit_attachment" name="edit_attachment[]" value="{{ $doc }}">
                                            <div class="col-md-2 float-left"><i class="dripicons-trash" onclick="removeExistingFileName(this)"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                    <span>
                                        <strong>New Attachment:</strong>
                                    </span>
                                @endif
                            @endif
                            <div id="selectedFile" class="row mb-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedFileNode = document.getElementById("selectedFile");
    let fileList = [];

    let doccount = document.getElementsByClassName('prev__doc-item').length ?? 0;

    (() => document.getElementById("notification").innerHTML = doccount ?? 0)();

    function notificationCount() {
        doccount = document.getElementsByClassName('prev__doc-item').length ?? 0;
        document.getElementById("notification").innerHTML = fileList.length + doccount;
    }

    function showFileName() {
        for (let i = 0; i < fileList.length; i++) {
            $('#selectedFile').append(
                '<div class="col-md-10 float-left"><a class="document-text" onclick="viewfile(this, ' + i + ');">' +
                fileList[i].name +
                '</a></div> <div class="col-md-2 float-left"><i class="dripicons-trash" onclick="removeMyTableFile(' +
                i + ')"></i><div">'
            )
        }
        notificationCount();
    }


    function viewfile(item, i) {
        const reader = new FileReader();
        reader.addEventListener('load', function() {
            item.setAttribute('href', this.result)
            debugBase64(this.result)
        })

        reader.readAsDataURL(fileList[i]);
    }

    function debugBase64(base64URL) {
        let win = window.open();
        win.document.write('<iframe src="' + base64URL +
            '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>'
        );
    }

    function selectMultipleFile(file) {
        selectedFileNode.innerHTML = '';
        let files = $(file)[0].files;
        for (let i = 0; i < files.length; i++) {
            fileList.push(files[i]);
        }
        showFileName();
    }

    function removeMyTableFile(i) {
        let parent = document.getElementById('selectedFile');
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
        fileList.splice(i, 1);
        showFileName();
    }

    function removeExistingFileName(existfileList) {
        if (confirm("{{ trans('file.Are you sure to delete the attachment?') }}")) {
            existfileList.parentElement.parentElement.remove();
            notificationCount();
        }
    }

    function saveAttachmentsOnServer() {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let formData = new FormData();
        formData.append('_token', CSRF_TOKEN);
        for (let i = 0; i < fileList.length; i++) {
            formData.append('documents[]', fileList[i]);
        }
        $.ajax({
            url: `{{ $route }}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: (data) => {
                document.getElementById('documentId').value = data.id;
                $('#attachmentPopUp').modal('hide');
                // const html = `<div class="alert alert-success alert-dismissible text-center">
                //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //         <span aria-hidden="true">&times;</span>
                //     </button> Successfully documents Added
                // </div>`;
                document.getElementById('alert').innerHTML = html;
            },
            error: (e) => {
                console.log(e);
                $('#attachmentPopUp').modal('hide');
                const html = `<div class="alert alert-danger alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> Failed To documents Added, Try Again!
                </div>`;
                document.getElementById('alert').innerHTML = html;
            }
        });
    }

    function updateAttachmentsOnServer() {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let formData = new FormData();
        formData.append('_token', CSRF_TOKEN);
        formData.append('id', `{{ $documents->id ?? '' }}`);
        let editAttachmentCollection = document.getElementsByClassName('edit_attachment');
        let docs = '';
        for (let i = 0; i < editAttachmentCollection.length; i++) {
            docs += editAttachmentCollection[i].value + ',';
        }
        formData.append('docs', docs);
        for (let i = 0; i < fileList.length; i++) {
            formData.append('documents[]', fileList[i]);
        }
        $.ajax({
            url: `{{ $route }}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: (data) => {
                console.log(data);
                document.getElementById('documentId').value = data.id;
                $('#attachmentPopUp').modal('hide');
                // const html = `<div class="alert alert-success alert-dismissible text-center">
                //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //         <span aria-hidden="true">&times;</span>
                //     </button> Successfully documents Updated
                // </div>`;
                
                document.getElementById('alert').innerHTML = html;
            },
            error: (e) => {
                console.log(e);
                $('#attachmentPopUp').modal('hide');
                const html = `<div class="alert alert-danger alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> Failed To documents Added, Try Again!
                </div>`;
                document.getElementById('alert').innerHTML = html;
            }
        });
    }
</script>
