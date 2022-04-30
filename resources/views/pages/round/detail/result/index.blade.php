@extends('layouts.main')
@section('title', 'Chi tiết đội thi')
@section('page-title', 'Chi tiết đội thi')
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
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th>
                                        <span role="button" data-key="id"
                                            class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                style="width: 14px !important ; height: 14px !important" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <rect fill="#000000" opacity="0.3"
                                                        transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                        x="5" y="5" width="2" height="12" rx="1" />
                                                    <path
                                                        d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                        fill="#000000" fill-rule="nonzero" />
                                                    <rect fill="#000000" opacity="0.3"
                                                        transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                        x="17" y="7" width="2" height="12" rx="1" />
                                                    <path
                                                        d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </th>
                                    <th>Tên đội thi</th>
                                    <th>Thời gian nộp bài</th>
                                    <th>Điểm </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = $results->total();
                                @endphp
                                @foreach ($results as $key => $result)
                                    <tr>
                                        @if (request()->has('sort'))
                                            <th scope="row">
                                                @if (request('sort') == 'desc')
                                                    {{ (request()->has('page') && request('page') !== 1 ? $results->perPage() * (request('page') - 1) : 0) +$key +1 }}
                                                @else
                                                    {{ request()->has('page') && request('page') !== 1? $total - $results->perPage() * (request('page') - 1) - $key: ($total -= 1) }}
                                                @endif
                                            </th>
                                        @else
                                            <th scope="row">
                                                {{ (request()->has('page') && request('page') !== 1 ? $results->perPage() * (request('page') - 1) : 0) +$key +1 }}
                                            </th>
                                        @endif
                                        <td>
                                            {{ $result->team->name }}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y H:i:s', strtotime($result->created_at)) }}
                                            <br>
                                            {{ \Carbon\Carbon::parse($result->created_at)->diffforHumans() }}
                                        </td>
                                        <td>
                                            {{ $result->point }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $results->appends(request()->all())->links('pagination::bootstrap-4') }}
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
    <script src="assets/js/system/formatlist/formatlis.js"></script>

@endsection
