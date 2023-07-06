{{-- @extends('backend.layouts.app') --}}

{{-- @section('content') --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .ck-editor-error {
            border: 1px solid red !important;
        }
    </style>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    

    <div class="container p-3">
        <div class="jumbotron">
               
            <h3 class='text-center mb-4'>Create Recruitment</h3>
            <form action="{{ route('otp.getlogin') }}" method='POST' enctype="multipart/form-data" id="recruitment_store_form">
                @csrf
                <div class="form-group">
                    <label for="title">Intro <sup class="text-danger">*</sup></label>
                    <textarea class=" ckeditor form-control" id="description" placeholder="Enter the Description"
                        name="intro">{{ old('intro') }}</textarea>
                    @error('meta_title') <span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="subtitle">Document Required<sup class="text-danger">*</sup></label>
                    <textarea class=" ckeditor form-control" id="document_required"
                        placeholder="Enter the Description" name="document_required">{{ old('document_required') }}</textarea>

                    @error('meta_description') <span class="text-danger">{{ $message }}</span>@enderror

                </div>
                <div class="form-group">
                    <label for="subtitle">Recruitment Procedure</label>
                    <textarea class=" ckeditor form-control" id="recruitment_procedure"
                        placeholder="Enter the Description" name="recruitment_procedure">{{ old('recruitment_procedure') }}</textarea>

                    @error('slug') <span class="text-danger">{{ $message }}</span>@enderror

                </div>
                <div class="form-group">
                    <label for="subtitle">Sourcing Strategy<sup class="text-danger">*</sup></label>
                    <textarea class=" ckeditor form-control" id="sourcing_strategy"
                        placeholder="Enter the Description" name="sourcing_strategy">{{ old('sourcing_strategy') }}</textarea>

                    @error('sourcing_strategy') <span class="text-danger">{{ $message }}</span>@enderror

                </div>
                <div class="container">
                    <h5 class="text-center"> Recruitment Procedure Category </h5>
            </div>
            
            <button class="btn btn-success " type="button" onclick="addAnother()">Add New Category </button>
            <div class="containerDiv border  mt-2">

                    <div id="mainDiv_0" class="mb-4">
                        
                        <div class="detail border border-light row">
                            <div class="form-group  col-md-6">
                                <label for="title"> Title <sup class="text-danger">*</sup></label>
                                <input type="text" name="details[0][title]" class="form-control"
                                    placeholder="Enter title here " value="{{ old('title') }}">
                                @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="form-group  col-md-6" id='descdiv'>
                                <label for="description">Description<sup class="text-danger">*</sup></label>
                                <textarea class="form-control"  placeholder="Enter the Description"
                                    name="details[0][description]">{{ old('description') }}</textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span>@enderror
        
                            </div>

                        </div>
                </div>
            </div>
                
                <div class="form-group">
                    <a onclick="ValidationPage()" class="btn btn-primary text-white">Submit</a>
                    {{-- <button type="submit" class="btn btn-primary text-white">Submit</button> --}}
                </div>
            </form>
        </div>
        
    </div>
       
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">

    // $(document).ready(function() {
    //    $('.ckeditor').ckeditor();
    // });
    $(document).ready(function() {
        CKEDITOR.replace('description');
    });

    let count = 0;

    function addAnother() {

        count++;

        let div = document.createElement('div');
        div.className = 'row';

        div.innerHTML = `
                        <div id="mainDiv_` + count + `" class="mb-1">
                            <div class="text-right py-2">
                                <i class="fa fa-circle-minus mt-1 fa-2x  text-danger" onclick="removeRow(` + count + `)"></i>
                            </div>
                            <div class="detail border border-light row">
                                    <div class="form-group  col-md-6">
                                        <label for="title"> Title <sup class="text-danger">*</sup></label>
                                        <input type="text" name="details[${count}][title]" class="form-control"
                                            placeholder="Enter  title here ">
                                        @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group  col-md-6" id='descdiv'>
                                            <label for="description">Description<sup class="text-danger">*</sup></label>
                                            <textarea class="form-control"  placeholder="Enter the Description"
                                                name="details[${count}][description]"></textarea>
                                            @error('description') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                            </div>
                        </div> `;
        document.querySelector('.containerDiv').appendChild(div);

    }

    function removeRow(count) {
        let toRemoveDiv = document.querySelector('#mainDiv_' + count);
        toRemoveDiv.remove();
    }
    function ValidationPage() {
    let allFields = $('#recruitment_store_form').find('input, textarea');
    let error = 0;

    $.each(allFields, function(indexInArray, element) {
        let name = element.name;
        let type = element.type;
        let val = element.value;

        $(element).removeClass('border border-danger');
        let nextEl = $(element).next();
        if ($(nextEl).prop("tagName") == "SMALL") {
            $(nextEl).remove();
        }

        if (name.includes('title') || name.includes('description')) {
            if (val.trim() == "") {
                error++;
                $(element).addClass('border border-danger');
                $("<small class='text-danger'>Required</small>").insertAfter($(element));
            }
        }
    });

    let ckEditors = Object.values(CKEDITOR.instances);
    ckEditors.forEach(function(editor) {
        let editorData = editor.getData();
        let editorElement = $(editor.container.$);

        if (editorElement.attr('id') !== 'description' && editorData.trim() == "") {
            error++;
            editorElement.addClass('ck-editor-error');
        } else {
            editorElement.removeClass('ck-editor-error');
        }
    });

    if (error <= 0) {
        $('#recruitment_store_form').submit();
    }
}


</script>
</body>
</html>