@extends('layouts.main')
@section('title', 'Quản lý chuyên ngành')
@section('page-title', 'Quản lý chuyên ngành')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.major.list') }}" class="pe-3">Danh sách chuyên ngành</a>
                </li>
                <li class="breadcrumb-item px-3 ">
                    <a href="{{ route('admin.major.skill', ['slug' => $major->slug]) }}" class="pe-3">
                        Chuyên ngành : {{ $major->name }}
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">
                    Danh sách kỹ năng theo chuyên ngành
                </li>
            </ol>
        </div>
    </div>
    <div class=" card card-flush  p-5">
        <div class="row">
            <div class="col-lg-12">
                <form id="formTeam" action="{{ route('admin.major.skill.attach', ['slug' => $major->slug]) }}"
                    method="POST">
                    @csrf
                    <div class="row">

                        <div class=" col-10 form-group">
                            <label for="" class="form-label">Kỹ năng</label>
                            <select multiple class="form-select select2-hidden-accessible" data-control="select2"
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
                        </div>
                        <div class=" col-2 form-group mt-auto">
                            <button type="submit" class="btn btn-primary"> Thêm </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
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
                                        <td>{{ $item['short_name'] }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td><img class='w-100px' src="{{ $item['image_url'] }}" alt=""></td>

                                        <td>

                                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                                data-bs-target="#introduce_{{ $item['id'] }}">
                                                Xem
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="introduce_{{ $item['id'] }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> Giới Thiệu Về
                                                                kỹ năng
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body  ">
                                                            {{ $item['description'] }}
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
                                            <a href="{{ route('admin.major.skill.detach', ['slug' => $major->slug, 'skill_id' => $item['id']]) }}"
                                                class="btn btn-danger btn-sm deleteTeams"><i
                                                    class="fas fa-trash-alt"></i></a>
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
