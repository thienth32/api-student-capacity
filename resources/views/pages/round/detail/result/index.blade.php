@extends('layouts.main')
@section('title', 'Kết quả vòng thi')
@section('page-title', 'Kết quả vòng thi')
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
                        <a href="{{ route('admin.contest.detail.round', ['id' => $round->contest_id]) }}"
                            class="pe-3">Vòng thi </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">
                        <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}">
                            {{ $round->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">
                        Danh sách kết quả
                    </li>
                </ol>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class=" card card-flush ">

                <div class="row p-5 d-flex justify-content-center align-items-center ">
                    <div class="row">
                        <button data-id="{{ $round->id }}" class="col-2 print-excel btn btn-warning">Xuất
                            EXCEL
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">

                                    <th>Tên đội thi</th>
                                    <th>Thời gian chốt điểm </th>
                                    <th>Điểm </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teams as $key => $team)
                                    <tr>
                                        <td>
                                            {{ $team->name }}
                                        </td>
                                        @if ($team->result)
                                            <td>
                                                {{ date('d-m-Y H:i:s', strtotime($team->result->created_at)) }}
                                                <br>
                                                {{ \Carbon\Carbon::parse($team->result->created_at)->diffforHumans() }}

                                            </td>
                                            <td>
                                                {{ $team->result->point }}
                                            </td>
                                        @else
                                            <td>Chưa có điểm thi</td>
                                            <td>Chưa có điểm thi</td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $teams->appends(request()->all())->links('pagination::bootstrap-4') }}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        var url = '{{ url()->current() }}' + '?';
        // var url = window.location.href + '?';
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
    </script>
    <script>
        $('.print-excel').on('click', function() {
            window.location = "/admin/prinft-excel?type=historyTeamsResultContest&round_id=" + $(this).data('id');
            return false;
        })
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>

@endsection
