@extends('layouts.main')
@section('title', 'Chi tiết cuộc thi')
@section('page-title', 'Danh sách đội thi ')
@section('content')
    <div class=" card card-flush p-5">
        <div class=" mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb text-muted fs-6 fw-bold">
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 ">
                            <a href="{{ route('admin.contest.show', ['id' => $roundDeltai->contest->id]) }}" class="pe-3">
                                {{ $roundDeltai->contest->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item pe-3">
                            Vòng thi
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail', ['id' => $roundDeltai->id]) }}">
                                {{ $roundDeltai->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">Doanh nghiệp tài trợ</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="formTeam"
                    action="{{ route('admin.round.detail.enterprise.attach', ['id' => $roundDeltai->id]) }}" method="POST">
                    @csrf
                    <label for="" class="form-label">Doanh nghiệp</label>
                    <select multiple class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="false" tabindex="-1" aria-hidden="true" name="enterprise_id[]"
                        value="{{ old('enterprise_id') }}">

                        @php
                            $index = -1;
                        @endphp
                        @foreach ($enterprise as $key => $itemEnterprise)
                            @foreach ($round as $item)
                                @if ($itemEnterprise->id == $item->Enterprise->id)
                                    @php
                                        $index = $item->Enterprise->id;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($itemEnterprise->id != $index)
                                <option value="{{ $itemEnterprise->id }}"> {{ $itemEnterprise->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary"> Thêm </button>
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
                                <th>Doanh nghiệp</th>
                                <th>Giới thiệu</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($round as $item)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    {{-- <td><img class='w-100px'
                                            src="{{ Storage::disk('s3')->has($item->Enterprise->logo) ? Storage::disk('s3')->temporaryUrl($item->Enterprise->logo, now()->addMinutes(5)) : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                            alt=""></td> --}}
                                    <td><img class='w-100px' src="{{ $item->Enterprise->logo }}" alt=""></td>
                                    <td>{{ $item->Enterprise->name }}</td>
                                    <td>

                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#introduce_{{ $item->Enterprise->id }}">
                                            Xem
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="introduce_{{ $item->Enterprise->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Giới Thiệu Về
                                                            Doanh
                                                            Nghiệp
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body  ">
                                                        {{ $item->Enterprise->description }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Thoát
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.round.detail.enterprise.detach', ['id' => $roundDeltai->id, 'enterprise_id' => $item->id]) }}"
                                            class="btn btn-danger deleteTeams"><i class="fas fa-trash-alt"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $round->appends(request()->all())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        var URL = '{{ url()->current() }}' + '?';
        var userArray = [];
        var _token = "{{ csrf_token() }}"
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
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
