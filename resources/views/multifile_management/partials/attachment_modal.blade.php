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
                            <button type="button" class="btn btn-save" title="{{ trans('file.Use ctrl+s to save') }}" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">
                                <i class="fa fa-floppy-o mr-1" aria-hidden="true"></i> {{ trans('file.Save') }}
                            </button>
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

                            <input type="file" id="file_documents" class="invisible" name="documents[]" multiple>
                            @if ($edit ?? false)
                                <input type="hidden" id="old_attachments" name="old_attachments" value="{{ $documents->documents ?? '' }}">
                                <input type="hidden" id="old_remove_attachments" name="old_remove_attachments" value="">
                                <?php
                                if ($documents != null) {
                                    $docs = explode(',', $documents->documents);
                                }
                                ?>

                                @if ($docs ?? false)
                                    @foreach ($docs as $doc)
                                        @php
                                            $tempDoc = explode('/', $doc);
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-2 float-left">
                                                <img src="/{{ $doc }}" alt="Attachment" height="80" width="80" class="product_image" >
                                            </div>
                                            <div class="col-md-8 float-left m-auto">
                                                <a href="/{{ $doc }}" target="_blank" title="{{ $doc }}" class="document-text prev__doc-item">{{ end($tempDoc) }}</a>
                                            </div>
                                            <input type="hidden" class="edit_attachment" name="edit_attachment[]" value="{{ $doc }}">
                                            <div class="col-md-2 float-left m-auto">
                                                <i class="dripicons-trash" onclick="removeExistingFileName(this)"></i>
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
                `<div class="col-md-2 float-left">
                    <img src="${getFileLink(this, i)}" alt="Attachment" height="80" width="80" class="product_image" >
                </div>
                <div class="col-md-8 float-left">
                    <a class="document-text" onclick="viewfile(this, ${i});">
                        ${fileList[i].name}
                    </a>
                </div>
                <div class="col-md-2 float-left">
                    <i class="dripicons-trash" onclick="removeMyTableFile(${i})"></i>
                <div">`
            )
        }
        notificationCount();
        handleFiles();
    }

    function getFileLink(item, i) {
        return URL.createObjectURL(fileList[i]);
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
        win.document.write(
            '<iframe src="' + base64URL +
            '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>'
        );
    }

    function selectMultipleFile(file) {
        selectedFileNode.innerHTML = '';
        let files = $(file)[0].files;
        fileList = [
            ...fileList,
            ...files,
        ];
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
            const existFileListDom = existfileList.parentElement.parentElement;
            const removeFileStr = existFileListDom.getElementsByClassName('document-text')[0].title + ',';
            existFileListDom.remove();
            notificationCount();
            let oldAttachmentsStr = document.getElementById('old_attachments');
            if(oldAttachmentsStr.value.slice(-1) != ',') {
                oldAttachmentsStr.value += ',';
            }

            oldAttachmentsStr.value = oldAttachmentsStr.value.replace(removeFileStr, '');

            if(oldAttachmentsStr.value.slice(-1) == ',') {
                oldAttachmentsStr.value = oldAttachmentsStr.value.slice(0, -1);
            }

            let oldRemoveAttachmentsStr = document.getElementById('old_remove_attachments');
            oldRemoveAttachmentsStr.value += removeFileStr;
        }
    }

    function handleFiles() {
        let dataTransferList = new DataTransfer();
        for (let i = 0; i < fileList.length; i++) {
            dataTransferList.items.add(fileList[i]);
        }
        const docFiles = document.getElementById('file_documents');

        docFiles.files = dataTransferList.files;
    }

</script>
