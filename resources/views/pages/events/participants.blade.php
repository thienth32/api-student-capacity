@extends('layouts.main')
@section('title', 'Quản lý người tham gia sự kiện')
@section('page-title', 'Quản lý người tham gia sự kiện')
@section('content')
    <div>
        <div class="card card-flush p-4 mt-4">
            <div class="row">
                <div class=" col-lg-6">
                    <h1>Danh sách tham gia sự kiện {{$event->name}}</h1>
                </div>
                <div class=" col-lg-6">
                    @if ($type == 1) 
                    <div class=" d-flex flex-row-reverse bd-highlight">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_mentor_{{ $event->id }}">
                            Thêm mentor
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="add_mentor_{{ $event->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Thêm mentors
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.event.addMentor', [$event->id]) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Chọn mentor</label>
                                                <select 
                                                    id="selectUser" 
                                                    class="form-select mb-2 select2-hidden-accessible"
                                                    data-control="select2"
                                                    data-hide-search="false" 
                                                    tabindex="-1" 
                                                    aria-hidden="true" 
                                                    name="user_ids[]"
                                                    multiple="multiple"
                                                >
                                                    @foreach ($users as $u)
                                                        <option
                                                             value="{{ $u->id }}">
                                                            {{ $u->name }} ({{$u->email}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    Thêm mentors
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Tabs --}}
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $type == 1 ? 'active' : '' }}"
                    href="{{ route('admin.event.participants', [$event->id, 'type' => 1]) }}">
                        Mentor chính thức ({{$event->participants()->mentor()->count()}})
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $type == 2 ? 'active' : '' }}"
                    href="{{ route('admin.event.participants', [$event->id, 'type' => 2]) }}">
                        User thường ({{$event->participants()->normalUser()->count()}})
                    </a>
                </li>
            </ul>

            {{-- Content --}}
            <div id="participant-content" class="mt-4 position-relative">
                @if (count($participants) > 0)
                <table class="table table-row-bordered table-row-gray-300 gy-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Tên người tham gia</th>
                            <th scope="col">Email người tham gia</th>
                            <th scope="col">Ảnh đại diện</th>
                            <th scope="col">Thời điểm tham gia</th>
                            <th class="text-center">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($participants as $item)
                            <tr>
                                <td>
                                    <span>{{ $item->user->name }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->user->email }}</span>
                                </td>
                                <td>
                                    <img style="max-height: 150px;" alt="avatar"
                                        src="{{ $item->user->avatar ?? 'assets/media/avatars/blank.png' }}" />
                                </td>
                                <td>
                                    <span>{{ $item->created_at }}</span>
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
                                                <form action="{{ route('admin.event.removeParticipant', [$event->id, $item->id]) }}"
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
                {{ $participants->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Không có dữ liệu !!!</h2>
            @endif
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script>
    $(document).ready(function() {
        $('#selectUser').select2({
            dropdownParent: $('#add_mentor_{{ $event->id }}'),
            placeholder: "Chọn user",
            width: '100%',
            closeOnSelect: false
        });
    });
    </script>
@endsection
