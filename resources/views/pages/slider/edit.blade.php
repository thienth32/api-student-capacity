@extends('layouts.main')
@section('title', 'Quản lý slider')
@section('page-title', 'Quản lý slider')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.sliders.list') }}" class="pe-3">
                        Danh sách slider
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Cập nhập slider </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">

                <form id="formAddSlider" action="{{ route('admin.sliders.update', ['id' => $slider->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div style="width: 80%" class="text-center m-auto">
                        <img class="pb-4"
                            src="{{ $slider->image_url ?? 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                            style=" width: 100%" id="previewImg">

                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Ảnh</label>
                        <input name="image_url" type="file" class="file-change form-control">
                        @error('image_url')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Hình thức lọc ảnh </label>
                        <select class="form-select" data-control="select2" data-placeholder="Select an option">
                            <option value="1">Dạng cột </option>
                            <option value="2">Dạng ngang </option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group mb-10">
                                <label class="form-label">Thời gian bắt đầu</label>
                                <input id="begin"
                                    value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($slider->start_time)) }}"
                                    max="" type="datetime-local" value="{{ old('start_time') }}" name="start_time"
                                    class="form-control " placeholder="">
                                @error('start_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">

                                <label class="form-label">Thời gian kết thúc</label>
                                <input id="end"
                                    value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($slider->end_time)) }}" min=""
                                    type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                                    class="form-control  " placeholder="Pick date rage" />
                                @error('end_time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 row ">
                            <div class="col-12">
                                <label class="form-label">URL chuyển hướng </label>
                                <input type="text" value="{{ $slider->link_to }}" name="link_to"
                                    value="{{ old('link_to') }}" class=" form-control" placeholder="">
                                @error('link_to')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12">

                            </div>

                        </div>
                    </div>
                    <div class="col-12  form-group mb-10">
                        <label for="" class="form-label">Thuộc thành phần </label>
                        <div class="row mb-10">
                            <div class="col-4">
                                <button type="button"
                                    class="btn btn-light {{ $slider->sliderable !== null && get_class($slider->sliderable) == \App\Models\Major::class ? 'btn-primary' : 'btn-light' }} btn-major">Chuyên
                                    ngành </button>
                            </div>
                            <div class="col-4">
                                <button type="button"
                                    class="btn {{ $slider->sliderable !== null && get_class($slider->sliderable) == \App\Models\Round::class ? 'btn-primary' : 'btn-light' }} btn-round">Vòng
                                    thi </button>
                            </div>
                            <div class="col-4">
                                <button type="button"
                                    class="btn {{ $slider->sliderable == null ? 'btn-primary' : 'btn-light' }} btn-home">Trang
                                    chủ </button>
                            </div>
                        </div>
                        <div class="form-group mb-10"
                            style="{{ $slider->sliderable !== null && get_class($slider->sliderable) == \App\Models\Major::class ? '' : 'display: none' }}"
                            id="major">
                            <label class="form-label">Chuyên ngành</label>
                            <select name="major_id" class="form-select form-major" data-control="select2"
                                data-placeholder="Chọn chuyên ngành ">
                                <option value="0">Chọn chuyên ngành</option>
                                @foreach ($majors as $major)
                                    <option @selected(($slider->sliderable != null ? $slider->sliderable->id : 0) === $major->id) value="{{ $major->id }}">{{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div style="{{ $slider->sliderable !== null && get_class($slider->sliderable) == \App\Models\Round::class ? '' : 'display: none' }}"
                            id="round">
                            <div class="form-group mb-10">

                                {{--  --}}
                                <label class="form-label">Cuộc thi </label>
                                <select id="select-contest-p" class="form-select form-contest " data-control="select2"
                                    data-placeholder="Chọn vòng thi ">
                                    <option value="0">Chọn cuộc thi</option>
                                    @foreach ($contests as $contest)
                                        <option @selected(($round ? $round->contest->id : 0) == $contest->id) value="{{ $contest->id }}">
                                            {{ $contest->name }} -
                                            {{ $contest->rounds_count . ' vòng thi ' }}
                                        </option>
                                    @endforeach
                                </select>
                                {{--  --}}
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label">Vòng thi </label>
                                <select id="select-round" name="round_id" class="form-select form-round "
                                    data-control="select2" data-placeholder="Chọn vòng thi ">
                                    @if ($slider->sliderable !== null && get_class($slider->sliderable) == \App\Models\Round::class)
                                        <option value="0">Chọn vòng thi</option>
                                        @foreach ($rounds as $r)
                                            @if ($round && ($round->contest ? $round->contest->id : 0) == $r->contest_id)
                                                <option @selected($slider->sliderable->id == $r->id) value="{{ $r->id }}">
                                                    {{ $r->name }}
                                                    -
                                                    {{ $r->sliders_count . ' banner ' }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option disabled value="0">Không có vòng thi nào ! Hãy chọn cuộc thi
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id=""
                            class="btn btn-success btn-lg btn-block">Cập nhật </button>
                    </div>

                </form>
            </div>

        </div>
    </div>


@endsection

@section('page-script')

    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/date-after/date-after.js"></script>
    <script src="assets/js/system/slider/form.js"></script>
    <script>
        dateAfterEdit('input[type=datetime-local]#begin', 'input[type=datetime-local]#end');
        preview.showFile('.file-change', '#previewImg');
        const rounds = @json($rounds);
        // $('.btn-home').click();
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
