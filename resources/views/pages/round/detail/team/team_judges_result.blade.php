@extends('layouts.main')
@section('title', 'Đề bài của đội thi')
@section('page-title', 'Điểm thi của đội thi')
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
                            <a href="{{ route('admin.round.detail.team', ['id' => $round->id]) }}"> Đội thi</a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a
                                href="{{ route('admin.round.detail.team.detail', ['id' => $round->id, 'teamId' => $team->id]) }}">
                                {{ $team->name }}</a>

                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            Danh sách giám khảo và điểm thi
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">

        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class=" card card-flush  p-5">
                <div class="table-responsive">
                    @if ($judgesResult != null)
                        <button class="btn btn-success btn-lg btn-block" type="button" data-bs-toggle="modal"
                            data-bs-target="#history_Point">
                            Lịch sử điểm
                        </button>

                        <!-- Modal -->
                        <div style="margin:auto;width:100%" class="modal fade " id="history_Point" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Lịch sử thay đổi điểm
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="col-12 row">

                                            <div class="row col-12 m-auto">

                                                <button
                                                    class="click-admin btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">
                                                    Admin</button>
                                                <button
                                                    class="click-judges  btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">
                                                    Ban giám khảo</button>
                                            </div>
                                            <div class="col-12 pb-2">
                                                <div style="display:none" id="admin">
                                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                                        <thead>
                                                            <tr class="fw-bolder fs-6 text-gray-800">
                                                                <th></th>
                                                                <th>Email</th>
                                                                <th>Họ tên</th>
                                                                <th>Điểm thay đổi</th>
                                                                <th>Lý do </th>
                                                                <th>Thời gian</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($historyPoint != null)
                                                                @foreach ($historyPoint as $item)
                                                                    <tr>
                                                                        <td></td>

                                                                        <td>
                                                                            {{ $item->user->email }}
                                                                        </td>
                                                                        <td> {{ $item->user->name }}</td>

                                                                        <td>{{ $item->point }}</td>
                                                                        <td>{{ $item->reason }}</td>
                                                                        <td> {{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}
                                                                            <br>
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->diffforHumans() }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td></td>
                                                                    <td> Chưa có lịch sử thay đổi điểm</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div style="display:none" id="judges">
                                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                                        <thead>
                                                            <tr class="fw-bolder fs-6 text-gray-800">
                                                                <th></th>
                                                                <th>Email</th>
                                                                <th>Họ tên</th>
                                                                <th>Điểm thay đổi</th>
                                                                <th>Lý do </th>
                                                                <th>Thời gian</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($historyPoint2 != null)
                                                                @foreach ($historyPoint2 as $item)
                                                                    <tr>
                                                                        <td></td>

                                                                        <td>
                                                                            {{ $item->user->email }}
                                                                        </td>
                                                                        <td> {{ $item->user->name }}</td>

                                                                        <td>{{ $item->point }}</td>
                                                                        <td>{{ $item->reason }}</td>
                                                                        <td> {{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}
                                                                            <br>
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->diffforHumans() }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td></td>
                                                                    <td> Chưa có lịch sử thay đổi điểm</td>
                                                                </tr>

                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($judgesResult != null)
                        @if (count($judgesResult->evaluation) > 0)
                            <table class="table table-row-dashed table-row-gray-300 gy-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800">
                                        <th></th>
                                        <th>Email</th>
                                        <th>Họ tên</th>
                                        <th>Điểm</th>
                                        <th>Đánh giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tong = 0;
                                    @endphp
                                    @foreach ($judgesResult->evaluation as $item)
                                        <tr>
                                            <td></td>
                                            <td>{{ $item->judge_round->judge->user->email }}</td>
                                            <td>{{ $item->judge_round->judge->user->name }}</td>
                                            <td>
                                                {{ $item->ponit }}
                                            </td>
                                            <td>

                                                {{ $item->comment }}
                                            <td>
                                                @php
                                                    $tong += $item->ponit;
                                                @endphp
                                        </tr>
                                    @endforeach

                                    <tr>

                                        <td></td>
                                        <td>
                                            <label for="" class="form-label"> Điểm qua vòng:
                                                {{ $judgesResult->exam->ponit }}</label>

                                            <form
                                                action="{{ route('admin.round.detail.team.takeExam.update', ['id' => $round->id, 'teamId' => $team->id, 'takeExamId' => $judgesResult->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="ponit"
                                                    value=" {{ $judgesResult->exam->ponit }}">
                                                <div class="mb-3">
                                                    <label for="" class="form-label"> Điểm trung bình:</label>
                                                    <input type="number" min="0" max="10" step="0.1"
                                                        size="5"
                                                        value="{{ $judgesResult->final_point ?? round($tong / count($judgesResult->evaluation), 2) }}"
                                                        class="form-control" name="final_point" id=""
                                                        placeholder="">

                                                </div>
                                                <div id="mark_comment" class="mb-3">
                                                    <textarea style="display:none" size="5" value="" type="text" class="form-control" name="reason"
                                                        id="" aria-describedby="helpId" placeholder="Lý do thay đổi điểm ( không bắt buộc)"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Nhận xét</label>
                                                    <textarea name="mark_comment" class="textarea form-control">{{ $judgesResult->mark_comment ?? '' }}</textarea>

                                                </div>
                                                <div class="mb-3">
                                                    {{-- @if ($tong / count($judgesResult->evaluation) >= $judgesResult->exam->ponit) --}}
                                                    <div id="select-round" style="display:none" class="form-group ">
                                                        <label class="form-label"> ( Đội đã đủ điểm qua vòng ,chọn vòng
                                                            thi sau cho đội thi )</label>
                                                        <select class="form-select mb-2 select2-hidden-accessible"
                                                            data-control="select2" name="roundId"
                                                            value="{{ old('roundId') }}" data-hide-search="true"
                                                            tabindex="-1" aria-hidden="true">

                                                            @foreach ($round->contest->rounds as $value)
                                                                @if ($round->id != $value->id &&
                                                                    \Carbon\Carbon::parse($value->start_time)->toDateTimeString() >
                                                                        \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString())
                                                                    <option value="{{ $value->id }}">
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- @endif --}}

                                                </div>
                                                <div class="form-group mb-10 ">
                                                    @if ($judgesResult->final_point != null)
                                                        <button type="submit"
                                                            onsubmit="return confirm('Điểm đã xác nhận. bạn có muốn thay đổi không!')"
                                                            name="" id=""
                                                            class=" btn btn-success btn-lg btn-block">Cập nhật điểm
                                                        </button>
                                                    @else
                                                        @if (count($judgesResult->evaluation) == count($round->judges))
                                                            <button type="submit" name="" id="submitResult"
                                                                class=" btn btn-success btn-lg btn-block">Xác nhận điểm
                                                            </button>
                                                        @else
                                                            <p type="button" name="" id="submitResult"
                                                                class=" btn btn-success btn-lg btn-block">Ban giám khảo
                                                                chưa hoàn thiện điểm (
                                                                {{ count($judgesResult->evaluation) . ' / ' . count($round->judges) }}
                                                                )
                                                            </p>
                                                        @endif
                                                    @endif

                                                </div>
                                            </form>
                                        </td>
                                        <td> <label for="" class="form-label"> Trạng thái:
                                                @if ($judgesResult->status == config('util.TAKE_EXAM_STATUS_COMPLETE') &&
                                                    $judgesResult->final_point >= $judgesResult->exam->ponit)
                                                    <span class="badge bg-success  p-3"> Passed </span>
                                                @elseif($judgesResult->status == config('util.TAKE_EXAM_STATUS_COMPLETE') &&
                                                    $judgesResult->final_point < $judgesResult->exam->ponit &&
                                                    $judgesResult->final_point != null)
                                                    <span class="badge bg-danger  p-3"> Failed</span>
                                                @else
                                                    <span class="badge bg-primary p-3"> Chờ xác nhận</span>
                                                @endif
                                            </label></td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <h3 style="margin-top:30px">Đội thi chưa có điểm thi !!!</h3>
                        @endif
                    @else
                        <h3 style="margin-top:30px">Đội thi chưa có điểm thi !!!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/js/system/round/round-team-judges-result.js"></script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
