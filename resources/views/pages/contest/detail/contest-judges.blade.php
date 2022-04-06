@extends('layouts.main')
@section('title', 'Chi tiết cuộc thi')
@section('page-title', 'Chi tiết cuộc thi')
@section('content')

    <h1 class="text-center pt-3">Danh sách ban giám khảo</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped gy-7 gs-7">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th>Tên</th>
                            <th>Ảnh</th>
                            <th>Thành viên</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
