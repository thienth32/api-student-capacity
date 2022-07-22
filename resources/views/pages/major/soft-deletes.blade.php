@extends('layouts.main')
@section('title', 'Danh sách chuyên ngành ')
@section('page-title', 'Thùng rác ')
@section('content')

    <div class="card card-flush p-4">
        <div class=" d-flex justify-content-between align-items-center">
            <div>
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb text-muted fs-6 fw-bold">
                            <li class="breadcrumb-item pe-3">
                                <a href="{{ route('admin.major.list') }}" class="pe-3">Quản lý chuyên ngành
                                </a>
                            </li>
                            <li class="breadcrumb-item px-3 text-muted">Thùng rác</li>
                        </ol>
                    </div>
                </div>
            </div>


        </div>
        <div class=" card-format row">
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class=" form-group p-2">
                    <label>Tìm kiếm </label>
                    <input type="text" value="{{ request('q') ?? '' }}" placeholder="'*Enter' tìm kiếm ..."
                        class=" ip-search form-control">
                </div>
            </div>
        </div>

        <div class="back">

            <span class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                    viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
            </span>

            <span class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                    viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>

        </div>
        {{--  --}}

        <div class="table-responsive  ">
            <table class="table table-rounded table-striped border gy-7 gs-7">
                <thead>
                    <tr>
                        <th scope="col" width="2%"> #</th>
                        <th scope="col"> Chuyên ngành
                        </th>
                        <th scope="col"> Slug chuyên ngành
                        </th>
                        <th scope="col">Thời gian xóa
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = $majors->total();
                    @endphp
                    @forelse ($majors as $key => $major)
                        <tr>
                            @if (request()->has('sort'))
                                <th scope="row">
                                    @if (request('sort') == 'desc')
                                        {{ (request()->has('page') && request('page') !== 1 ? $majors->perPage() * (request('page') - 1) : 0) +$key +1 }}
                                    @else
                                        {{ request()->has('page') && request('page') !== 1? $total - $majors->perPage() * (request('page') - 1) - $key: ($total -= 1) }}
                                    @endif
                                </th>
                            @else
                                <th scope="row">
                                    {{ (request()->has('page') && request('page') !== 1 ? $majors->perPage() * (request('page') - 1) : 0) +$key +1 }}
                                </th>
                            @endif
                            <td>{{ $major->name }}</td>
                            <td>{{ $major->slug }}</td>
                            <td>
                                {{ date('d-m-Y H:i', strtotime($major->deleted_at)) }}
                                <br>
                                {{ \Carbon\Carbon::parse($major->deleted_at)->diffforHumans() }}
                            </td>

                            <td>
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn   btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="svg-icon svg-icon-success svg-icon-2x">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                        fill="#000000" />
                                                </g>
                                            </svg>

                                        </span>
                                    </button>
                                    <ul class="dropdown-menu px-4">
                                        <li class="my-3">
                                            <a href="{{ route('admin.major.soft.restore', ['slug' => $major->slug]) }}">
                                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path
                                                                d="M12,8 L8,8 C5.790861,8 4,9.790861 4,12 L4,13 C4,14.6568542 5.34314575,16 7,16 L7,18 C4.23857625,18 2,15.7614237 2,13 L2,12 C2,8.6862915 4.6862915,6 8,6 L12,6 L12,4.72799742 C12,4.62015048 12.0348702,4.51519416 12.0994077,4.42878885 C12.264656,4.2075478 12.5779675,4.16215674 12.7992086,4.32740507 L15.656242,6.46136716 C15.6951359,6.49041758 15.7295917,6.52497737 15.7585249,6.56395854 C15.9231063,6.78569617 15.876772,7.09886961 15.6550344,7.263451 L12.798001,9.3840407 C12.7118152,9.44801079 12.607332,9.48254921 12.5,9.48254921 C12.2238576,9.48254921 12,9.25869158 12,8.98254921 L12,8 Z"
                                                                fill="#000000" />
                                                            <path
                                                                d="M12.0583175,16 L16,16 C18.209139,16 20,14.209139 20,12 L20,11 C20,9.34314575 18.6568542,8 17,8 L17,6 C19.7614237,6 22,8.23857625 22,11 L22,12 C22,15.3137085 19.3137085,18 16,18 L12.0583175,18 L12.0583175,18.9825492 C12.0583175,19.2586916 11.8344599,19.4825492 11.5583175,19.4825492 C11.4509855,19.4825492 11.3465023,19.4480108 11.2603165,19.3840407 L8.40328311,17.263451 C8.18154548,17.0988696 8.13521119,16.7856962 8.29979258,16.5639585 C8.32872576,16.5249774 8.36318164,16.4904176 8.40207551,16.4613672 L11.2591089,14.3274051 C11.48035,14.1621567 11.7936615,14.2075478 11.9589099,14.4287888 C12.0234473,14.5151942 12.0583175,14.6201505 12.0583175,14.7279974 L12.0583175,16 Z"
                                                                fill="#000000" opacity="0.3" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                Khôi phục
                                                </span>
                                            </a>
                                        </li>
{{--                                        <li class="my-3">--}}

{{--                                            @hasrole(config('util.ROLE_DELETE'))--}}
{{--                                                <a onclick="return confirm('Bạn có chắc muốn xóa không !')"--}}
{{--                                                    href="{{ route('admin.major.soft.deletes', ['slug' => $major->slug]) }}">--}}
{{--                                                    <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">--}}
{{--                                                        <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"--}}
{{--                                                            height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                                                <rect x="0" y="0" width="24" height="24" />--}}
{{--                                                                <path--}}
{{--                                                                    d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"--}}
{{--                                                                    fill="#000000" fill-rule="nonzero" />--}}
{{--                                                                <path--}}
{{--                                                                    d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"--}}
{{--                                                                    fill="#000000" opacity="0.3" />--}}
{{--                                                            </g>--}}
{{--                                                        </svg>--}}
{{--                                                        Xóa vĩnh viễn--}}
{{--                                                    </span>--}}
{{--                                                </a>--}}
{{--                                            @else--}}
{{--                                                <span style="cursor: not-allowed; user-select: none"--}}
{{--                                                    class="svg-icon svg-icon-danger svg-icon-2x">--}}
{{--                                                    <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"--}}
{{--                                                        viewBox="0 0 24 24" version="1.1">--}}
{{--                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                                            <rect x="0" y="0" width="24" height="24" />--}}
{{--                                                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />--}}
{{--                                                            <path--}}
{{--                                                                d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z"--}}
{{--                                                                fill="#000000" />--}}
{{--                                                        </g>--}}
{{--                                                    </svg>--}}
{{--                                                    Xóa bỏ--}}
{{--                                                </span>--}}
{{--                                            @endhasrole--}}


{{--                                        </li>--}}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{ $majors->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>
    </div>



@endsection
@section('page-script')
    <script>
        let url = "/admin/majors/list-soft-deletes?";
        // let url = window.location.href;
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>

@endsection
