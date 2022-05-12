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
                            <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}"
                                class="pe-3">
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
                                                action="{{ route('admin.round.detail.team.takeExam.update', ['id' => $round->id,'teamId' => $team->id,'takeExamId' => $judgesResult->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="ponit"
                                                    value=" {{ $judgesResult->exam->ponit }}">
                                                <div class="mb-3">
                                                    <label for="" class="form-label"> Điểm trung bình:</label>
                                                    <input type="number" step="0.1" size="5"
                                                        value="{{ $judgesResult->final_point ?? $tong / count($judgesResult->evaluation) }}"
                                                        class="form-control" name="final_point" id="" placeholder="">
                                                </div>
                                                <div id="mark_comment" class="mb-3">
                                                    <input style="display:none" size="5" value="" type="text"
                                                        class="form-control" name="mark_comment" id=""
                                                        aria-describedby="helpId"
                                                        placeholder="Lý do thay đổi điểm ( không bắt buộc)">
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
                                                                @if ($round->id != $value->id && \Carbon\Carbon::parse($value->start_time)->toDateTimeString() > \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString())
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
                                                        <button onclick="return alert('Điểm thi đã được xác nhận .')"
                                                            type="button" name="" id=""
                                                            class="btn btn-success btn-lg btn-block">Đã xác nhận
                                                        </button>
                                                    @else
                                                        <button
                                                            onclick="waitingNotice({{ count($judgesResult->evaluation) }}, {{ count($round->judges) }})"
                                                            type="button" name="" id="submitResult"
                                                            class="btn btn-success btn-lg btn-block">Xác nhận điểm
                                                        </button>
                                                    @endif

                                                </div>
                                            </form>
                                        </td>
                                        <td> <label for="" class="form-label"> Trạng thái:
                                                @if ($judgesResult->status == config('util.TAKE_EXAM_STATUS_COMPLETE') && $judgesResult->final_point >= $judgesResult->exam->ponit)
                                                    <span class="badge bg-success  p-3"> Passed </span>
                                                @elseif($judgesResult->status == config('util.TAKE_EXAM_STATUS_COMPLETE') && $judgesResult->final_point < $judgesResult->exam->ponit && $judgesResult->final_point != null)
                                                    <span class="badge bg-danger  p-3"> Failed</span>
                                                @else
                                                    <span class="badge bg-primary p-3"> Chờ xác nhận</span>
                                                @endif
                                            </label></td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <h3>Đội thi chưa có điểm thi !!!</h3>
                        @endif
                    @else
                        <h3>Đội thi chưa có điểm thi !!!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')

    <script>
        $(document).ready(function() {
            // alert($("input[name=ponit]").val())
            $("input[name=final_point]").keyup(function() {
                $("input[name=final_point]").mouseleave(function() {

                    $("input[name=mark_comment]").show(100);
                    if (parseFloat($("input[name=final_point]").val()) >= parseFloat($(
                            "input[name=ponit]").val())) {
                        $('#select-round').show(100);
                    } else {
                        $('#select-round').hide(100);
                    }
                })

            });
            // $('#select-round').hide();
            if (parseFloat($("input[name=final_point]").val()) >= parseFloat($("input[name=ponit]").val())) {
                $('#select-round').show(100);
            } else {
                $('#select-round').hide(100);
            }


        });

        function waitingNotice(a, b) {
            if (a < b) {
                alert('Vẫn còn ban giám khảo đang chấm , vui lòng đợi điểm .');
                return false;
            }
            return $('form').submit()

        }
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
    <script src="{{ asset('assets/js/system/round/round-team.js') }}"></script>
@endsection
