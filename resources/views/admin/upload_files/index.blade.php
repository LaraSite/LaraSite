@extends('admin.layout.admin')

@section('bodyId', 'adminUploadFilesIndex')

@section('content')
<h1 class="title">{{ trans('models.upload_file') }}</h1>

{!! BootForm::open()
    ->action(route('admin.upload_files.store'))
    ->id('myDropzone')
    ->addClass('dropzone') !!}
{!! BootForm::close() !!}

{{--{!! BootForm::open()->multipart()->action(route('admin.upload_files.store')) !!}--}}
    {{--{!! BootForm::file('Upload File', 'submitted_file') !!}--}}
    {{--{!! BootForm::submit('Submit', 'btn-primary') !!}--}}
{{--{!! BootForm::close() !!}--}}

{!! BootForm::open()
    ->delete()
    ->id('deleteForm') !!}
{!! BootForm::close() !!}

<div class="row spacer30">
    <?php $cnt = 1 ?>
    @foreach($files as $file)
        <div class="col-xs-6 col-sm-4 col-md-3">
            <a href="{{ $file->url }}" class="thumbnail">
                @if($file->extentnion === "pdf")
                    <img src="/img/pdf.png" alt="{{ $file->name }}"/>
                @else
                    <img src="{{ $file->url }}" alt="{{ $file->name }}"/>
                @endif
            </a>
            <div class="caption text-center">
                <label>
                    <input type="checkbox" form="deleteForm" name="delete_items[]" value="{{ $file->id }}" class="checkDelete" />
                    <span class="fileName">{{ $file->name }}</span><br/>
                    <div class="fileMeta">
                        {{ number_format($file->size / 1000, 2) }} KB
                    </div>
                </label>
                <br/>
            </div>
        </div>
        @if(($cnt % 2) === 0)
            <div class="clearfix visible-xs-block"></div>
        @endif
        @if(($cnt % 3) === 0)
            <div class="clearfix visible-sm-block"></div>
        @endif
        @if(($cnt % 4) === 0)
            <div class="clearfix visible-md-block visible-lg-block"></div>
        @endif
        <?php $cnt++ ?>
    @endforeach
</div>

@if($files->count() > 0)
    @include('admin.shared._index_nav', [
        'pagination' => $files,
        'delete_form_id' => 'deleteForm',
    ])
@endif

@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $(function(){
            Dropzone.options.myDropzone = {
                paramName: "submitted_file",
                maxFilesize: 0.5,
                acceptedFiles: "image/jpeg,image/png,image/gif,application/pdf",
                dictDefaultMessage: "{!! trans('message.drop_file_here') !!}"
            };
        });
    </script>
@endsection
