@extends('layouts.main')
@section('title', 'Chi tiết vòng thi')
@section('page-title', 'Danh sách giám khảo ')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc thi </a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}" class="pe-3">
                            {{ $round->contest->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.round.list') }}" class="pe-3">Vòng thi </a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}" class="pe-3">
                            {{ $round->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">Quản lý ban giám khảo {{ $round->name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <h3></h3>

            <label for="" class="form-label">Danh giám khảo thuộc cuộc thi {{ $round->contest->name }}</label>
            <select class="form-select form-select-judges mb-2 select2-hidden-accessible" data-control="select2"
                data-hide-search="false" tabindex="-1" aria-hidden="true" name="contest_id"
                value="{{ old('contest_id') }}">
                <option value="0">--Ban giám khảo--</option>
                @foreach ($round->contest->judges as $user)
                    <option value="{{ $user }}">
                        {{ $user->name }} -
                        {{ $user->email }}</option>
                @endforeach
            </select>

            <ul class="list-group show-us">

            </ul>

            <br>
        </div>
        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th>#</th>
                                <th>Email</th>
                                <th>Họ tên</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($round->judges as $judge)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $judge->user->email }}</td>
                                    <td>{{ $judge->user->name }}</td>
                                    <td>
                                        <button data-key="{{ $judge->id }}" data-id_user="{{ $judge->user->id }}"
                                            class="deleteJudges btn btn-danger">Gỡ</button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('page-script')
    <script>
        const URL_ATTACH = "{{ route('admin.judges.attach.round', ['round_id' => $round->id]) }}";
        const URL_DETACH = "{{ route('admin.judges.detach.round', ['round_id' => $round->id]) }}";
        const _token = "{{ csrf_token() }}"
        const listUserIsset = @json($round->judges);
    </script>

    <script src="{{ asset('assets/js/system/team/team.js') }}"></script>
    <script src="{{ asset('assets/js/system/judges/judges-round.js') }}"></script>
@endsection
