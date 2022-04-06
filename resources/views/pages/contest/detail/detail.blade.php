@extends('layouts.main')
@section('title', 'Chi tiết cuộc thi')
@section('page-title', 'Chi tiết cuộc thi')
@section('content')
    <div class="row">
        <div class="col-lg-2">
            <div class="card card-flush ">
                <img src="{{ $datas->img == null
                    ? 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg'
                    : $datas->img }}"
                    alt="">

            </div>
            <ul class="nav flex-row flex-md-column nav-custom  border-0 fs-4 fw-bold mb-n2 mt-3">

                <li class="nav-item">
                    <a class="tabbar_detail_contest nav-link text-active-primary" href="javascript:void()">
                        Chi tiết
                    </a>
                </li>

                <li class="nav-item">
                    <a class="tabbar_round_contest nav-link text-active-primary " href="javascript:void()">
                        Vòng thi</a>
                </li>

                <li class="nav-item">
                    <a class="tabbar_teams_contest nav-link text-active-primary " href="javascript:void()">Đội
                        thi</a>
                </li>
                <li class="nav-item">
                    <a class="tabbar_judges_contest nav-link text-active-primary " href="javascript:void()">
                        Ban giám khảo
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-lg-10">
            <div class="container-fluid mt-3 card card-flush">

                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group list-group-flush fs-2 ">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-4">
                                        <h2>Tên cuộc thi</h2>
                                    </div>
                                    <div class="col-8">
                                        {{ $datas->name }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-4">
                                        <h2>Thời gian bắt đầu</h2>

                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($datas->date_start)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($datas->date_start)->diffforHumans() }}
                                    </div>
                                </div>

                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-4">
                                        <h2>Thời gian kết thúc</h2>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($datas->register_deadline)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($datas->register_deadline)->diffforHumans() }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-4">
                                        <h2>Trạng thái</h2>
                                    </div>
                                    <div class="col-8">
                                        @if ($datas->status == 1)
                                            <button type="button" class="btn btn-primary">
                                                Kích hoạt
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger">
                                                Không kích hoạt
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="ps-5">Mô tả cuộc thi</h2>
                        <div class="card-body fs-3">
                            {!! $datas->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        const URL_ROUTE = `{{ route('admin.contest.show', ['id' => $datas->id]) }}`
    </script>
    <script src="assets/js/system/contest/detail-contest.js"></script>
@endsection
