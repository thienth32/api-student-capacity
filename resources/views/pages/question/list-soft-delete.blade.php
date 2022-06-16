@extends('layouts.main')
@section('title', 'Danh sách câu hỏi bị xóa')
@section('page-title', 'Danh sách câu hỏi bị xóa')
@section('content')



    <div class="card card-flush p-4">
        <div class="row">
            <div class=" col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.question.index') }}">Danh sách câu hỏi</a>
                        </li>
                        <li class="breadcrumb-item disable text-muted px-3">
                            Danh sách câu hỏi bị xóa
                        </li>

                    </ol>
                </nav>
            </div>
            <div class=" col-lg-6">

            </div>
        </div>

        {{-- <div class="row card-format">

            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="  form-group">
                    <label class="form-label">Tìm kiếm </label>
                    <input type="text" value="{{ request('q') ?? '' }}" placeholder="*Enter tìm kiếm ..."
                        class=" ip-search form-control">
                </div>
            </div>

        </div> --}}



        <div class="table-responsive table-responsive-md">
            @if (count($questions) > 0)
                <table class="table table-row-bordered table-row-gray-300 gy-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">
                                <span role="button" data-key="id"
                                    class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        style="width: 14px !important ; height: 14px !important" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
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
                            <th scope="col">Nội dung câu hỏi
                                <a
                                    href="{{ route('admin.teams', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'name',
                                    ]) }}">
                                    <span role="button" data-key="name"
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                                </a>

                            </th>
                            <th scope="col">Level câu hỏi</th>
                            <th scope="col">Loại</th>
                            <th class=" text-center" scope="col">Skill</th>
                            <th scope="col">Ngày tạo


                            </th>
                            <th class="text-center" colspan="2">
                                Thao tác
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = $questions->total();
                        @endphp
                        @forelse ($questions as $key => $question)
                            @php
                                $token = uniqid(15);
                            @endphp
                            <tr>
                                @if (request()->has('sort'))
                                    <th scope="row">
                                        @if (request('sort') == 'desc')
                                            {{ (request()->has('page') && request('page') !== 1 ? $questions->perPage() * (request('page') - 1) : 0) + $key + 1 }}
                                        @else
                                            {{ request()->has('page') && request('page') !== 1 ? $total - $questions->perPage() * (request('page') - 1) - $key : ($total -= 1) }}
                                        @endif
                                    </th>
                                @else
                                    <th scope="row">
                                        {{ (request()->has('page') && request('page') !== 1 ? $questions->perPage() * (request('page') - 1) : 0) + $key + 1 }}
                                    </th>
                                @endif
                                </th>
                                <td style="width:30%">
                                    {!! $question->content !!}
                                    <br>
                                    <div class="collapse w-100" id="collapse{{ $token }}">
                                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $token }}" aria-expanded="false"
                                            aria-controls="collapse{{ $token }}">
                                            Đóng
                                        </button>
                                        <hr>
                                        <ul class="list-group list-group-flush">
                                            @if (count($question->answers) > 0)
                                                @foreach ($question->answers as $answer)
                                                    <li
                                                        class="list-group-item {{ $answer->is_correct == 1 ? 'active' : '' }}">
                                                        {{ $answer->content }}</li>
                                                @endforeach
                                            @endif

                                        </ul>

                                    </div>
                                </td>

                                <td style="width:10%">
                                    <button class="btn btn-info btn-sm">
                                        @if ($question->rank == config('util.RANK_QUESTION_EASY'))
                                            Dễ
                                        @elseif ($question->rank == config('util.RANK_QUESTION_MEDIUM'))
                                            Trung bình
                                        @elseif ($question->rank == config('util.RANK_QUESTION_DIFFICULT'))
                                            Khó
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    @if ($question->type == config('util.INACTIVE_STATUS'))
                                        Một đáp án
                                    @else
                                        Nhiều đáp án
                                    @endif
                                </td>
                                <td style="width:15%">
                                    <div class="d-grid gap-2">
                                        @if ($question->skills)
                                            @foreach ($question->skills as $skill)
                                                <button class=" btn-color-dark btn btn-secondary btn-sm" type="button">
                                                    {{ $skill->name }}
                                                </button>
                                            @endforeach
                                        @endif
                                    </div>

                                </td>

                                <td>{{ $question->created_at }}</td>

                                <td>
                                    @hasanyrole(config('util.ROLE_ADMINS'))

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
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu  px-4 ">

                                                <li class="my-3">
                                                    <a class="" data-bs-toggle="collapse"
                                                        href="#collapse{{ $token }}" role="button" aria-expanded="false"
                                                        aria-controls="collapse{{ $token }}">
                                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Text/Bullet-list.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path
                                                                        d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z"
                                                                        fill="#000000" />
                                                                    <path
                                                                        d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z"
                                                                        fill="#000000" opacity="0.3" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        Xem đáp án
                                                    </a>
                                                </li>
                                                <li class="my-3">
                                                    <a href="{{ route('admin.question.restore', ['id' => $question->id]) }}">
                                                        <span role="button" class=" svg-icon svg-icon-primary svg-icon-2x">
                                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path
                                                                        d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                                                        fill="#000000" fill-rule="nonzero" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        Khôi phục
                                                    </a>
                                                </li>
                                                <li class="my-3">

                                                    <form
                                                        action="{{ route('admin.question.delete', ['id' => $question->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                            style=" background: none ; border: none ; list-style : none"
                                                            type="submit">
                                                            <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">
                                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                        <path
                                                                            d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                                            fill="#000000" fill-rule="nonzero" />
                                                                        <path
                                                                            d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                                            fill="#000000" opacity="0.3" />
                                                                    </g>
                                                                </svg>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            Xóa bỏ
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                    @endhasrole
                                </td>
                                <br>





                            </tr>

                        @empty
                        @endforelse
                    </tbody>
                </table>
                {{ $questions->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Trống !!!</h2>
            @endif
        </div>
    </div>

@endsection

@section('page-script')

    <script>
        let url = "/admin/questions/soft-delete?question_soft_delete=1$=&";
        const _token = "{{ csrf_token() }}";
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>

    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="{{ asset('assets/js/system/question/index.js') }}"></script>
    <script>
        question.selectSkillList('#selectSkill');
        question.selectLevelList('#select-level');
        question.selectTypeList('#select-type');
    </script>


@endsection
