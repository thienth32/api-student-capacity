@extends('layouts.main')
@section('title', 'Cập nhập bài viết')
@section('page-title', 'Cập nhập bài viết')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formPost" action="{{ route('admin.post.update', ['id' => $post->id]) }}" method="post"
                      enctype="multipart/form-data">
                    @csrf

                    @method('PUT')
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tiêu đề bài viết</label>
                        <input type="text" name="title" value="{{ $post->title }}" class="name-sl form-control"
                               placeholder="">
                        @error('title')
                        <p id="checkname" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Slug bài viết</label>
                        <input type="text" name="slug" value="{{ $post->slug }}" class="slug-sl form-control"
                               placeholder="">
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label" for="">Thuộc các thành phần</label>
                        <div class="row col-12 m-auto">
                            <button type="button"
                                    class="click-recruitment btn {{ ($post->postable !== null && get_class($post->postable) == \App\Models\Recruitment::class) || $post->postable_type == \App\Models\Recruitment::class ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 btn-light col-xl-3 ">
                                Tuyển dụng
                            </button>
                            <button id="clickContset" type="button"
                                    class="mygroup btn  {{ $post->postable !== null && get_class($post->postable) == \App\Models\Contest::class && $post->status_capacity == 0 ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 col-xl-3 btn-light  click-contest">
                                Cuộc thi
                            </button>
                            <button id="clickCapacity" type="button"
                                    class="mygroup btn {{ $post->postable !== null && get_class($post->postable) == \App\Models\Contest::class && $post->status_capacity == 1 ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 col-xl-3 btn-light click-capacity">
                                Bài test
                            </button>
                            <button type="button"
                                    class="mygroup btn {{ $post->postable !== null && get_class($post->postable) == \App\Models\Round::class ? 'btn-primary' : '' }} col-12 col-lg-3 col-sx-12 col-md-12 col-sm-12 col-xxl-3 col-xl-3 btn-light click-round">
                                Vòng thi
                            </button>

                        </div>
                        <br>
                        <div class="col-12 pb-2">
                            <div
                                style=" {{ $post->postable !== null && get_class($post->postable) == \App\Models\Contest::class && $post->status_capacity == 0 ? '' : 'display:none' }}"
                                id="contest">
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Cuộc thi</label>
                                    <select name="contest_id" class="form-select form-major" data-control="select2"
                                            data-placeholder="Chọn cuộc thi ">
                                        <option value="0">Chọn cuộc thi</option>
                                        @foreach ($contest as $item)
                                            <option
                                                @selected(($post->postable != null ? $post->postable->id : 0) === $item->id && get_class($post->postable) == \App\Models\Contest::class && $post->status_capacity == 0) value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div
                                style=" {{ $post->postable !== null && get_class($post->postable) == \App\Models\Contest::class && $post->status_capacity == 1 ? '' : 'display:none' }}"
                                id="capacity">
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Bài test</label>
                                    <select name="capacity_id" class="form-select form-major" data-control="select2"
                                            data-placeholder="Chọn bài test ">
                                        <option value="0">Chọn bài test</option>
                                        @foreach ($capacity as $item)
                                            <option
                                                @selected(($post->postable != null ? $post->postable->id : 0) === $item->id && get_class($post->postable) == \App\Models\Contest::class && $post->status_capacity == 1) value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div
                                style=" {{ $post->postable !== null && get_class($post->postable) == \App\Models\Round::class ? '' : 'display:none' }}"
                                id="round">
                                <label class="form-label">Cuộc thi </label>
                                <select id="select-contest-p" class="form-select form-contest " data-control="select2"
                                        data-placeholder="Chọn cuộc thi ">
                                    <option value="0">Chọn cuộc thi</option>
                                    @foreach ($contest as $item)
                                        <option
                                            @selected(($round ? $round->contest->id : 0) == $item->id && get_class($post->postable) == \App\Models\Round::class) value="{{ $item->id }}">
                                            {{ $item->name }} - {{ count($item->rounds) }} vòng thi
                                        </option>
                                    @endforeach
                                </select>
                                <div>
                                    <label class="form-label">Vòng thi </label>
                                    <select id="select-round" name="round_id" class="form-select form-round "
                                            data-control="select2" data-placeholder="Chọn vòng thi ">
                                        <option value="0">Chọn vòng thi</option>
                                        @if ($post->postable !== null && get_class($post->postable) == \App\Models\Round::class)

                                            @foreach ($rounds as $r)
                                                @if ($round && ($round->contest ? $round->contest->id : 0) == $r->contest_id)
                                                    <option
                                                        @selected($post->postable->id == $r->id) value="{{ $r->id }}">
                                                        {{ $r->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option disabled value="0">Không có vòng thi nào ! Hãy chọn cuộc
                                                thi
                                            </option>
                                        @endif
                                    </select>
                                </div>

                            </div>
                            <!-- <div style="{{ $post->postable !== null && get_class($post->postable) == \App\Models\Recruitment::class ? '' : 'display:none' }}"
                                id="recruitment">
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Tuyển dụng</label>
                                    <select name="recruitment_id" class="form-select form-major" data-control="select2"
                                        data-placeholder="Chọn cuộc thi ">
                                        <option value="0">Chọn tuyển dụng</option>
                                        @foreach ($recruitments as $item)
                                <option @selected(($post->postable != null ? $post->postable->id : 0) === $item->id && get_class($post->postable) == \App\Models\Recruitment::class) value="{{ $item->id }}">
                                                {{ $item->name }}
                                </option>

                            @endforeach
                            </select>

                        </div>

                    </div> -->
                            <div
                                style="{{ ($post->postable !== null && get_class($post->postable) == \App\Models\Recruitment::class) || $post->postable_type == \App\Models\Recruitment::class ? '' : 'display:none' }}"
                                id="recruitment" class="row">
                                {{--                                <div class="form-group mb-10 col-xl-6 col-12">--}}
                                {{--                                    <label for="" class="form-label">Thuộc đợt tuyển dụng</label>--}}
                                {{--                                    <select name="recruitment_id" class="form-select form-major" data-control="select2"--}}
                                {{--                                        data-placeholder="Chọn đợt tuyển dụng ">--}}
                                {{--                                        <option value="0">Không thuộc đợt tuyển dụng nào</option>--}}
                                {{--                                        @foreach ($recruitments as $item)--}}
                                {{--                                            <option @selected(($post->postable != null ? $post->postable->id : 0) === $item->id && get_class($post->postable) == \App\Models\Recruitment::class)  value="{{ $item->id }}">--}}
                                {{--                                                {{ $item->name }}--}}
                                {{--                                            </option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <div class="form-group mb-10 col-xl-12 col-12">
                                    <label for="" class="form-label">Doanh nghiệp</label>
                                    <select name="enterprise_id" class="form-select form-major" data-control="select2"
                                            data-placeholder="Chọn doanh nghiệp">
                                        <option value="0">Chọn doanh nghiệp</option>
                                        @foreach ($enterprises as $enterprise)
                                            <option
                                                @selected(old('enterprise_id') ? old('enterprise_id') == $enterprise->id : $post->enterprise_id == $enterprise->id) value="{{ $enterprise->id }}">
                                                {{ $enterprise->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-12">
                                    <label for="" class="form-label">Chuyên ngành</label>
                                    <select name="major_id" class="form-select form-major" data-control="select2"
                                            data-placeholder="Chọn chuyên ngành">
                                        <option value="0">Chọn chuyên ngành</option>
                                        @foreach ($majors as $major)
                                            <option
                                                @selected(old('major') ? old('major') == $major->id : $post->major_id == $major->id) value="{{ $major->id }}">
                                                {{ $major->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-12">
                                    <label for="" class="form-label">Vị trí</label>
                                    <input type="text" class="form-control" name="position"
                                           value="{{ old('position') ?? $post->position }}">
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-12">
                                    <label for="" class="form-label">Số lượng</label>
                                    <input type="text" class="form-control" name="total"
                                           value="{{ old('total') ?? $post->total }}">
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-12">
                                    <label for="" class="form-label">Yêu cầu kinh nghiệm</label>
                                    <input type="text" class="form-control" name="career_require"
                                           value="{{ old('career_require') ?? $post->career_require }}">
                                </div>
                                <input type="hidden" name="post_type" id="post_type" value="{{ $post_type }}">
                                <div class="form-group mb-10 col-xl-3 col-6">
                                    <label for="" class="form-label">Mã số thuế</label>
                                    <select name="tax_number" id="tax_number" class="form-select form-major"
                                            data-control="select2"
                                            data-placeholder="Mã số thuế">
                                        <option value="0">Mã số thuế</option>
                                        @foreach ($tax_numbers as $tax_number)
                                            <option
                                                @selected(old('tax_number') ? old('tax_number') == $tax_number->tax_number : $post->tax_number == $tax_number->tax_number) value="{{ $tax_number->tax_number }}">
                                                {{ $tax_number->tax_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-6">
                                    <label for="" class="form-label">Người liên hệ</label>
                                    <input type="text" class="form-control" name="contact_name"
                                           value="{{ old('contact_name') ?? $post->contact_name }}">
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-6">
                                    <label for="" class="form-label">SĐT liên hệ</label>
                                    <input type="text" class="form-control" name="contact_phone"
                                           value="{{ old('contact_phone') ?? $post->contact_phone }}">
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-6">
                                    <label for="" class="form-label">Email liên hệ</label>
                                    <input type="text" class="form-control" name="contact_email"
                                           value="{{ old('contact_email') ?? $post->contact_email }}">
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-6">
                                    <label for="" class="form-label">Bài đăng thuộc cơ sở</label>
                                    <select name="branch_id" class="form-select form-major" data-control="select2"
                                            data-placeholder="Chọn cơ sở đăng bài">
                                        <option value="0">Không thuộc cơ sở nào</option>
                                        @foreach ($branches as $branch)
                                            <option
                                                @selected($post->branch_id == $branch->id) value="{{ $branch->id }}">
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-12">
                                    <label for="" class="form-label">Hình thức</label>
                                    <select name="career_type" id="" class="form-select form-major"
                                            data-control="select2">
                                        <option value="">Chọn hình thức</option>
                                        @foreach (config('util.CAREER_TYPES') as $key => $value)
                                            <option
                                                @selected(old('career_type') == $key || $post->career_type == $key) value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                        {{--                                        <option value="0" @selected(old('career_type') == 0 || $post->career_type == 0)>Part-time</option>--}}
                                        {{--                                        <option value="1" @selected(old('career_type') == 1 || $post->career_type == 1)>Full-time</option>--}}
                                    </select>
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-12">
                                    <label for="" class="form-label">Thời hạn tuyển dụng</label>
                                    <input type="datetime-local" class="form-control" name="deadline"
                                           value="{{ old('deadline') ?? $post->deadline }}">
                                </div>
                                <div class="form-group mb-10 col-xl-3 col-12">
                                    <label for="" class="form-label">Nguồn</label>
                                    <input type="text" class="form-control" name="career_source"
                                           value="{{ old('career_source') ?? $post->career_source }}">
                                </div>
                                <div class="form-group mb-10 col-xl-12 col-12">
                                    <label for="" class="form-label">Ghi chú</label>
                                    <textarea name="note" class="form-control" id="" cols="30"
                                              rows="3">{{ old('note') ?? $post->note }}</textarea>
                                </div>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mã tuyển dụng ( Áp dụng với bài viết tuyển
                                    dụng)</label>
                                <input type="text" name="code_recruitment"
                                       value="{{ old('code_recruitment') ?? $post->code_recruitment }}"
                                       class="form-control"
                                       placeholder="">
                                @error('code_recruitment')
                                <p id="checkname" class="text-danger">{{ $message }}</p>
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
                                        <option {{ $post->user_id == $user->id ? 'selected' : '' }}
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
                                       value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($post['published_at'])) }}"
                                       name="published_at" class="form-control " placeholder="">
                                @error('published_at')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>

                            <div class="form-group mb-10">
                                <label class="form-label" for="">Mô tả ngắn bài viết</label>
                                <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic"
                                          rows="3">{{ $post->description }}</textarea>
                                @error('description')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="" class="form-label">Ảnh đại diện bài viết</label>
                                <input name="thumbnail_url" type='file' id="file-input" accept=".png, .jpg, .jpeg"
                                       class="form-control"/>
                                <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                     src="{{ $post->thumbnail_url ? $post->thumbnail_url : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}"/>

                            </div>
                            @error('thumbnail_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @if ($post->link_to != null)
                        <div class="form-group mb-10">
                            <label class="form-label" for="">link bài viết bên ngoài trang</label>
                            <input type="text" name="link_to" value="{{ $post->link_to }}" class="form-control"
                                   placeholder="">
                            @error('link_to')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div class="form-group mb-10">
                            <label class="form-label" for="">Nội dung bài viết</label>
                            <textarea class="form-control" name="content" id="kt_docs_ckeditor_classic2"
                                      rows="3">{{ $post->content }}</textarea>
                            @error('content')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
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
    <script type="text/javascript" src="assets/js/custom/documentation/general/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/post/form.js"></script>
    <script src="assets/js/system/post/post.js"></script>
    <script src="assets/js/system/post/date-after.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
        dateAfter('input[type=datetime-local]#begin', 'input[type=datetime-local]#end')
        const oldRound = @json(old('round_id'));
        const rounds = @json($rounds);
        const recruitments = @json($recruitments);
        let enterprises = @json($enterprises);
        let tax_numbers = @json($tax_numbers);

        $(document).ready(function () {
            const recruitmentSelect = $('select[name="recruitment_id"]');
            const enterpriseSelect = $('select[name="enterprise_id"]');
            let recruitment_id = recruitmentSelect.val();
            const taxNumberSelect = $('select[name="tax_number"]');
            let contactName = $('input[name="contact_name"]');
            let contactPhone = $('input[name="contact_phone"]');
            let contactEmail = $('input[name="contact_email"]');
            let majorSelect = $('select[name="major_id"]');

            enterpriseSelect.select2({
                placeholder: "Chọn doanh nghiệp",
                allowClear: true,
                tags: true,
            });
            majorSelect.select2({
                placeholder: "Chọn chuyên ngành",
                allowClear: true,
                tags: true,
            });

            taxNumberSelect.select2({
                placeholder: "Chọn mã số thuế",
                allowClear: true,
                tags: true,
            });

            taxNumberSelect.on('change', function () {
                let taxNumber = $(this).val();
                let info = tax_numbers.find(enterprise => enterprise.tax_number == taxNumber);
                if (info) {
                    contactName.val(info.contact_name);
                    contactPhone.val(info.contact_phone);
                    contactEmail.val(info.contact_email);
                }
            });
        });
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
