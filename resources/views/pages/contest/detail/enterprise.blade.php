@extends('layouts.main')
@section('title', 'Quản lý cuộc thi')
@section('page-title', 'Quản lý cuộc thi')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.contest.list') }}" class="pe-3">
                        Danh sách cuộc thi
                    </a>
                </li>
                <li class="breadcrumb-item px-3 ">
                    <a href="{{ route('admin.contest.show', ['id' => $contest->id]) }}" class="pe-3">
                        {{ $contest->name }}
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">
                    Danh sách doanh nghiệp tài trợ
                </li>
            </ol>
        </div>
    </div>
    <div class=" card card-flush p-5">
        <form id="formTeam" action="{{ route('admin.contest.detail.enterprise.attach', ['id' => $contest->id]) }}"
            method="POST">
            <div class="row">
                <div class="col-11">
                    @csrf
                    <label for="" class="form-label">Doanh nghiệp</label>
                    <select multiple class="form-select select2-hidden-accessible" data-control="select2"
                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="enterprise_id[]"
                        value="{{ old('enterprise_id') }}">
                        @php
                            $index = -1;
                        @endphp
                        @foreach ($enterprise as $key => $itemEnterprise)
                            @foreach ($contest->enterprise as $item)
                                @if ($itemEnterprise->id == $item->id)
                                    @php
                                        $index = $item->id;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($itemEnterprise->id != $index)
                                <option value="{{ $itemEnterprise->id }}"> {{ $itemEnterprise->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-1 mt-auto">
                    <button type="submit" class="btn btn-primary"> Thêm </button>
                </div>
            </div>
        </form>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th>#</th>
                                <th>Ảnh</th>
                                <th>Doanh nghiệp</th>
                                <th>Giới thiệu</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($contestEnterprise as $key => $item)
                                <tr>
                                    <td> {{ (request()->has('page') && request('page') !== 1 ? $contestEnterprise->perPage() * (request('page') - 1) : 0) + $key + 1 }}
                                    </td>
                                    <td>
                                        {{-- <img class='w-100px'
                                            src="{{ Storage::disk('s3')->has($item->logo) ? Storage::disk('s3')->temporaryUrl($item->logo, now()->addMinutes(5)) : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                            alt=""> --}}
                                        <img class='w-100px' src="{{ $item->logo }}" alt="">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>

                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#introduce_{{ $item->id }}">
                                            Xem
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="introduce_{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Giới Thiệu Về
                                                            Doanh
                                                            Nghiệp
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
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
                                        <a href="{{ route('admin.contest.detail.enterprise.detach', ['id' => $contest->id, 'enterprise_id' => $item->id]) }}"
                                            class="btn btn-danger deleteTeams"><i class="fas fa-trash-alt"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $contestEnterprise->appends(request()->all())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')

    <script src="assets/js/system/validate/validate.js"></script>
@endsection
