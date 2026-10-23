@extends('layouts.main')
@section('title', 'Quản lý sự kiện')
@section('page-title', 'Quản lý sự kiện')
@section('content')
    <div class="card card-flush p-4">
        <div class="row">
            <div class=" col-lg-6">
                <h1>Doanh nghiệp đồng hành cùng {{ $event->name }}</h1>
            </div>
            <div class=" col-lg-6">
                <div class=" d-flex flex-row-reverse bd-highlight">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_enterprise_{{ $event->id }}">
                        Thêm doanh nghiệp
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="add_enterprise_{{ $event->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Thêm doanh nghiệp
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.event.addSponsors', [$event->id]) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Chọn hạng</label>
                                            <select class="form-select" name="priority">
                                                <option value="0">Ban tổ chức</option>
                                                <option value="4">Tài trợ kim cương</option>
                                                <option value="3">Tài trợ vàng</option>
                                                <option value="2">Tài trợ bạc</option>
                                                <option value="1">Doanh nghiệp đồng hành</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Chọn doanh nghiệp</label>
                                            <select 
                                                id="selectUser" 
                                                class="form-select mb-2 select2-hidden-accessible"
                                                data-control="select2"
                                                data-hide-search="false" 
                                                tabindex="-1" 
                                                aria-hidden="true" 
                                                name="sponsor_ids[]"
                                                multiple="multiple"
                                            >
                                                @foreach ($enterprises as $e)
                                                    <option
                                                        value="{{ $e->id }}">
                                                        {{ $e->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                Thêm doanh nghiệp
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabs --}}
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $priority == 0 ? 'active' : '' }}"
                href="{{ route('admin.event.sponsors', [$event->id, 'priority' => 0]) }}">
                    Ban tổ chức ({{$event->sponsors()->host()->count()}})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $priority == 4 ? 'active' : '' }}"
                href="{{ route('admin.event.sponsors', [$event->id, 'priority' => 4]) }}">
                    Nhà tài trợ kim cương ({{$event->sponsors()->diamond()->count()}})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $priority == 3 ? 'active' : '' }}"
                href="{{ route('admin.event.sponsors', [$event->id, 'priority' => 3]) }}">
                    Nhà tài trợ vàng ({{$event->sponsors()->gold()->count()}})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $priority == 2 ? 'active' : '' }}"
                href="{{ route('admin.event.sponsors', [$event->id, 'priority' => 2]) }}">
                    Nhà tài trợ bạc ({{$event->sponsors()->silver()->count()}})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $priority == 1 ? 'active' : '' }}"
                href="{{ route('admin.event.sponsors', [$event->id, 'priority' => 1]) }}">
                    Doanh nghiệp đồng hành ({{$event->sponsors()->participant()->count()}})
                </a>
            </li>
        </ul>
        <div class="table-responsive">
        @if (count($sponsors) > 0)
                <table class="table table-row-bordered table-row-gray-300 gy-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Tên doanh nghiệp</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Email liên hệ</th>
                            <th scope="col">SĐT liên hệ</th>
                            <th class="text-center">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sponsors as $item)
                            <tr>
                                <td>
                                    <span>{{ $item->company->name }}</span>
                                </td>
                                <td>
                                    <img style="max-height: 150px;" alt="avatar"
                                        src="{{ $item->company->logo ?? 'assets/media/avatars/blank.png' }}" />
                                </td>
                                <td>
                                    <span>{{ $item->company->contact_email }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->company->contact_phone }}</span>
                                </td>
                                <td>
                                    <div data-bs-toggle="tooltip" title="Thao tác" class="btn-group dropstart">
                                        <button type="button" class="btn btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="svg-icon svg-icon-success svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24"
                                                            height="24" />
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
                                                <form action="{{ route('admin.event.removeSponsor', [$event->id, $item->id]) }}"
                                                    id="delete_{{$item->id}}"
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
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
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
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                {{ $sponsors->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Không có dữ liệu !!!</h2>
            @endif
        </div>
    </div>


@endsection

@section('page-script')
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script>
    $(document).ready(function() {
        $('#selectUser').select2({
            dropdownParent: $('#add_enterprise_{{ $event->id }}'),
            placeholder: "Chọn doanh nghiệp",
            width: '100%',
            closeOnSelect: false
        });
    });
    </script>
@endsection
