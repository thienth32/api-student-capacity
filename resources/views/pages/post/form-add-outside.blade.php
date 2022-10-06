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
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Thuộc các thành phần</label>
                        <div class="row col-12 m-auto">

                            <button id="clickContset" type="button"
                                class="mygroup btn  {{ old('contest_id') ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 col-xl-3 btn-light click-contest">
                                Cuộc thi</button>
                            <button type="button"
                                class="click-capacity  btn {{ old('capacity_id') ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 col-xl-3 btn-light">
                                Bài Test</button>
                            <button type="button"
                                class="mygroup btn  {{ old('round_id') ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 col-xl-3 btn-light click-round">
                                Vòng thi</button>
                            <button type="button"
                                class="click-recruitment  btn {{ old('recruitment_id') ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 col-xl-3 btn-light">
                                Tuyển dụng</button>


                        </div>
                        <br>
                        <div class="col-12 pb-2">
                            <div style="{{ old('contest_id') ? '' : 'display:none' }}" id="contest">
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Cuộc thi</label>
                                    <select name="contest_id" class="form-select form-major" data-control="select2"
                                        data-placeholder="Chọn cuộc thi ">
                                        <option value="0">Chọn cuộc thi</option>
                                        @foreach ($contest as $item)
                                            <option @selected(old('contest_id') == $item->id) value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div style="{{ old('capacity_id') ? '' : 'display:none' }}" id="capacity">
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Bài test</label>
                                    <select name="capacity_id" class="form-select form-major" data-control="select2"
                                        data-placeholder="Chọn  bài test ">
                                        <option value="0">Chọn bài test</option>
                                        @foreach ($capacity as $item)
                                            <option @selected(old('capacity_id') == $item->id) value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div style="{{ old('round_id') ? '' : 'display:none' }}" id="round">
                                <label class="form-label">Cuộc thi </label>
                                <select id="select-contest-p" name="contestRound" class="form-select form-contest "
                                    data-control="select2" data-placeholder="Chọn cuộc thi ">
                                    <option value="">Chọn cuộc thi</option>
                                    @foreach ($contest as $item)
                                        <option @selected(old('contestRound') == $item->id) value="{{ $item->id }}">
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
                            <div style="{{ old('recruitment_id') ? '' : 'display:none' }}" id="recruitment">
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Tuyển dụng</label>
                                    <select name="recruitment_id" class="form-select form-major" data-control="select2"
                                        data-placeholder="Chọn cuộc thi ">
                                        <option value="0">Chọn tuyển dụng</option>
                                        @foreach ($recruitments as $item)
                                            <option @selected(old('recruitment_id') == $item->id) value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mã tuyển dụng</label>
                                <input type="text" name="code_recruitment" value="{{ old('code_recruitment') }}"
                                    class="form-control" placeholder="">
                                @error('code_recruitment')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Tác giả bài viết</label>
                                <select placeholder="Chọn" class="form-select mb-2 select2-hidden-accessible"
                                    data-control="select2" data-hide-search="false" tabindex="-1" aria-hidden="true"
                                    name="user_id" value="{{ old('user_id') }}">
                                    <option value="0">Chọn tác giả</option>
                                    @foreach ($users as $user)
                                        <option {{ old('user_id') == $user->id ? 'selected' : '' }}
                                            value="{{ $user->id }}">
                                            {{ $user->name }}&nbsp;
                                            <small class="badge bg-success">( {{ $user->email }} )</small>
                                        </option>
                                    @endforeach
                                </select>



                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Thời gian xuất bản</label>
                                <input id="begin" max="" type="datetime-local"
                                    value="{{ old('published_at') }}" name="published_at" class="form-control "
                                    placeholder="">
                                @error('published_at')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>

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
        const oldRound = @json(old('round_id'));
        const oldRecruitment = @json(old('recruitment_id'));
        const oldCapacity = @json(old('capacity_id'));
        $(document).ready(function() {
            if (oldRound == null || oldRecruitment == null || oldCapacity == null) {
                $(".click-contest").click();
            }
            if (oldRound != null) {
                $("#select-contest-p").change();
            }

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
