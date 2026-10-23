@extends('layouts.main')
@section('title', 'Quản lý đăng ký dịch vụ')
@section('page-title', 'Quản lý đăng ký dịch vụ')
@section('content')
    <div>
        <div class="card card-flush p-4 mt-4">
            <div class="row">
                <div class=" col-lg-6">
                    <h1>Danh sách đăng ký dịch vụ {{$service->name}}</h1>
                </div>
            </div>
            {{-- Tabs --}}
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $status == 0 ? 'active' : '' }}"
                    href="{{ route('admin.service.requests', [$service->id, 'status' => 0]) }}">
                        Đang chờ duyệt ({{$service->requests()->inProgress()->count()}})
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $status == 1 ? 'active' : '' }}"
                    href="{{ route('admin.service.requests', [$service->id, 'status' => 1]) }}">
                        Đã hoàn thành ({{$service->requests()->finish()->count()}})
                    </a>
                </li>
            </ul>

            {{-- Content --}}
            <div id="participant-content" class="mt-4 position-relative">
                @if (count($requests) > 0)
                <table class="table table-row-bordered table-row-gray-300 gy-7 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Tên người đăng ký</th>
                            <th scope="col">Email người đăng ký</th>
                            <th scope="col">Ảnh đại diện</th>
                            <th scope="col">Thời điểm đăng ký</th>
                            <th class="text-center">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $item)
                            <tr>
                                <td>
                                    <span>{{ $item->register->name }}</span>
                                </td>
                                <td>
                                    <span>{{ $item->register->email }}</span>
                                </td>
                                <td>
                                    <img style="max-height: 150px;" alt="avatar"
                                        src="{{ $item->register->avatar ?? 'assets/media/avatars/blank.png' }}" />
                                </td>
                                <td>
                                    <span>{{ $item->created_at }}</span>
                                </td>
                                <td>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                {{ $requests->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Không có dữ liệu !!!</h2>
            @endif
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="assets/js/system/formatlist/formatlis.js"></script>
@endsection
