@extends('layouts.main')
@section('title', 'Thêm bài viết bên ngoài trang')
@section('page-title', 'Thêm bài viết bên ngoài trang')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formPost" action="{{ route('admin.post.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tiêu đề bài viết</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="name-sl form-control"
                            placeholder="">
                        @error('title')
                            <p id="checkname" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Slug bài viết</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="slug-sl form-control"
                            placeholder="">
                        @error('slug')
                            <p id="checkslug" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">




                        <div class="col-8">

                            <div class="form-group mb-10">
                                <label class="form-label" for="">Thời gian xuất bản</label>
                                <input id="begin" max="" type="datetime-local"
                                    value="{{ old('published_at') }}" name="published_at" class="form-control "
                                    placeholder="">
                                @error('published_at')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="col-12 row">
                                <label class="form-label" for="">Thuộc các thành phần</label>
                                <div class="row col-12 m-auto">

                                    <button id="clickContset" type="button"
                                        class="mygroup btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light click-contest">
                                        Cuộc thi</button>
                                    <button type="button"
                                        class="mygroup btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light click-round">
                                        Vòng thi</button>
                                    <button type="button"
                                        class="click-recruitment  btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">
                                        Tuyển dụng</button>
                                </div>
                                <br>
                                <div class="col-12 pb-2">
                                    <div style="display:none" id="contest">
                                        <div class="form-group mb-10">
                                            <label for="" class="form-label">Cuộc thi</label>
                                            <select name="contest_id" class="form-select form-major" data-control="select2"
                                                data-placeholder="Chọn cuộc thi ">
                                                <option value="0">Chọn cuộc thi</option>
                                                @foreach ($contest as $item)
                                                    <option @selected(request('contest_id') == $item->id) value="{{ $item->id }}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                    </div>
                                    <div style="display:none" id="round">
                                        <label class="form-label">Cuộc thi </label>
                                        <select id="select-contest-p" class="form-select form-contest "
                                            data-control="select2" data-placeholder="Chọn cuộc thi ">
                                            <option value="">Chọn cuộc thi</option>
                                            @foreach ($contest as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }} - {{ count($item->rounds) }} vòng thi
                                                </option>
                                            @endforeach
                                        </select>
                                        <div>
                                            <label class="form-label">Vòng thi </label>
                                            <select id="select-round" name="round_id" class="form-select form-round "
                                                data-control="select2" data-placeholder="Chọn vòng thi ">
                                                <option value="0" disable>Không có vòng thi nào ! Hãy chọn cuộc thi
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div style="display:none" id="recruitment">
                                        <div class="form-group mb-10">
                                            <label for="" class="form-label">Tuyển dụng</label>
                                            <select name="recruitment_id" class="form-select form-major"
                                                data-control="select2" data-placeholder="Chọn cuộc thi ">
                                                <option value="0">Chọn tuyển dụng</option>
                                                @foreach ($recruitments as $item)
                                                    <option @selected(request('recruitment_id') == $item->id) value="{{ $item->id }}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mô tả ngắn bài viết</label>
                                <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="" class="form-label">Ảnh đại diện bài viết</label>
                                <input name="thumbnail_url" type='file' id="file-input" accept=".png, .jpg, .jpeg"
                                    class="form-control" />
                                <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                    src="https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg" />

                            </div>
                            @error('thumbnail_url')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">link bài viết bên ngoài trang</label>
                        <input type="text" name="link_to" value="{{ old('link_to') }}" class="form-control"
                            placeholder="">
                        @error('link_to')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id=""
                            class="btn btn-success btn-lg btn-block">Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/post/form.js"></script>
    <script src="assets/js/system/post/post.js"></script>
    <script src="assets/js/system/post/date-after.js"></script>
    <script>
        $(document).ready(function() {

            $(".click-contest").click();

        });
        rules.thumbnail_url = {
            required: true,
        };
        messages.thumbnail_url = {
            required: 'Chưa nhập trường này !',
        };
        preview.showFile('#file-input', '#image-preview');
        dateAfter('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')

        const rounds = @json($rounds);
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
