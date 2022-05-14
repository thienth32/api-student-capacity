@extends('layouts.main')
@section('title', 'Danh sách kỹ năng theo chuyên ngành')
@section('page-title', 'Danh sách kỹ năng theo chuyên ngành')
@section('content')
    <div class=" card card-flush p-5">
        <div class="row pb-5">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.major.list') }}" class="pe-3">Chuyên ngành</a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.major.skill', ['slug' => $major->slug]) }}" class="pe-3">
                            {{ $major->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">
                        Danh sách kỹ năng
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="formTeam" action="{{ route('admin.major.skill.attach', ['slug' => $major->slug]) }}"
                    method="POST">
                    @csrf
                    <label for="" class="form-label">Kỹ năng</label>
                    <select multiple class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="skill_id[]"
                        value="{{ old('skill_id') }}">

                        @php
                            $index = -1;
                        @endphp
                        @foreach ($listSkill as $key => $itemSkill)
                            @foreach ($parentSkill as $item)
                                @if ($itemSkill->id == $item->id)
                                    @php
                                        $index = $item->id;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($itemSkill->id != $index)
                                <option value="{{ $itemSkill->id }}">Kỹ năng: {{ $itemSkill->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary"> Thêm </button>
                </form>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    @if (count($skills) > 0)
                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th>#</th>
                                    <th>Mã </th>
                                    <th>Kỹ năng</th>
                                    <th>Ảnh</th>

                                    <th>Giới thiệu</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($skills as $key => $item)
                                    <tr>
                                        <td> {{ (request()->has('page') && request('page') !== 1 ? $skills->perPage() * (request('page') - 1) : 0) + $key + 1 }}
                                        </td>
                                        <td>{{ $item->short_name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td><img class='w-100px'
                                                src="{{ Storage::disk('s3')->has($item->image_url) ? Storage::disk('s3')->temporaryUrl($item->image_url, now()->addMinutes(5)) : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                                alt=""></td>

                                        <td>

                                            <button class="badge bg-primary" type="button" data-bs-toggle="modal"
                                                data-bs-target="#introduce_{{ $item->id }}">
                                                Xem thông tin...
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="introduce_{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> Giới Thiệu Về
                                                                kỹ năng
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body  ">
                                                            {{ $item->description }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Thoát
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.major.skill.detach', ['slug' => $major->slug, 'skill_id' => $item->id]) }}"
                                                class="btn btn-danger deleteTeams"><i class="fas fa-trash-alt"></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $skills->appends(request()->all())->links('pagination::bootstrap-4') }}
                    @else
                        <h3> Chuyên ngành chưa có kỹ năng !!!</h3>
                    @endif
                </div>
            </div>
        </div>


    </div>
@endsection
@section('page-script')

    <script src="assets/js/system/validate/validate.js"></script>
@endsection
