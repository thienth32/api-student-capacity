@extends('layouts.main')
@section('title', 'Chi tiết cuộc thi')
@section('page-title', 'Danh sách đội thi ')
@section('content')
    <div class=" card card-flush p-5">
        <div class="row pb-5">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc
                            thi</a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.contest.show', ['id' => $contest->id]) }}" class="pe-3">
                            {{ $contest->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">
                        Danh sách ban giám khảo của {{ $contest->name }}
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="formTeam" action="{{ route('admin.contest.detail.team.add', ['id' => $contest->id]) }}"
                    method="POST">
                    @csrf
                    <label for="" class="form-label">Đội thi</label>
                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="team_id"
                        value="{{ old('team_id') }}">
                        @foreach ($teams as $teamSelect)
                            <option value="{{ $teamSelect->id }}"> {{ $teamSelect->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary"> Thêm </button>
                    {{-- <select class="form-select mb-2 select2-hidden-accessible" name="tax" data-control="select2" data-hide-search="true" data-placeholder="Select an option" data-select2-id="select2-data-16-c56c" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="select2-data-18-3pnx"></option>
                        <option value="0" data-select2-id="select2-data-161-uv2g">Tax Free</option>
                        <option value="1" data-select2-id="select2-data-162-2cmm">Taxable Goods</option>
                        <option value="2" data-select2-id="select2-data-163-66t0">Downloadable Product</option>
                    </select> --}}
                </form>
            </div>
        </div>

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
                                <th>Tên đội</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($contest->teams as $team)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td><img class='w-100px'
                                            src="{{ Storage::disk('google')->has($team->image)? Storage::disk('google')->url($team->image): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                            alt=""></td>
                                    <td>{{ $team->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.delete.teams', $team->id) }}"
                                            class="btn btn-danger deleteTeams"><i class="fas fa-trash-alt"></i></a>
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
        var URL = window.location.href;
        var userArray = [];
        var _token = "{{ csrf_token() }}"
        var urlSearch = "{{ route('admin.user.TeamUserSearch') }}"
        var URL_ATTACH = "{{ route('admin.judges.attach', ['contest_id' => $contest->id]) }}"
        var URL_SYNC = "{{ route('admin.judges.sync', ['contest_id' => $contest->id]) }}"
        var URL_DETACH = "{{ route('admin.judges.detach', ['contest_id' => $contest->id]) }}"
    </script>
    <script>
        const elForm = "#formTeam";
        const onkeyup = true;
        const rules = {
            team_id: {
                required: true,
            }
        };
        const messages = {
            team_id: {
                required: 'Chưa chọn đội !!',
            }
        };
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
