@extends('layouts.main')
@section('title', 'Chi tiết trò chơi ')
@section('page-title', 'Chi tiết trò chơi ')
@section('content')

    <div class="card card-flush p-4">
        @if ($exam->status == 2)
            <div class="alert alert-primary text-center">
                <h2 class="text-primary"> Trò chơi đã kết thúc </h2>
            </div>
        @else
            <div class="alert alert-primary text-center">

                <a href="{{ route('admin.capacit.play.run', ['id' => $exam->room_code]) }}" class="btn btn-primary">
                    Bắt đầu
                </a>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-lg-4 col-12 mb-1">
                <div class="alert alert-primary p-3 rounded  ">
                    <div class="card card-flush p-2">
                        <h2>Trò chơi : {{ $exam->name }} </h2>
                        <h2>Mã trò chơi : <i>{{ $exam->room_code }}</i> </h2>
                        <h2>Điểm thưởng : <strong>{{ $exam->max_ponit }}</strong>
                        </h2>
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                            data-bs-target="#modalId">
                            Bộ câu hỏi
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-12 mb-1">
                <div class="alert alert-primary p-3 rounded   text-center">
                    <h2 class="mb-2">Mô tả</h2>
                    <div class="card p-3 card-flush">
                        {!! $exam->description !!}
                    </div>

                </div>
            </div>

        </div>


        <div class="col-lg-12 col-12 mt-1">
            <div class="alert alert-primary p-3 rounded   text-center">
                <h2 class="mb-2">Danh sách tài khoản </h2>
                <div class="row">
                    @if (count($ranks) > 0)
                        @foreach ($ranks as $key => $rank)
                            <div class="col-lg-3 col-12 mb-1">
                                <div class="card   p-3 card-flush">
                                    <h3>{{ $rank->user->name }} - <i class="bi bi-award-fill"></i> Top {{ $key + 1 }}
                                    </h3>
                                    <span>Điểm : {{ $rank->scores }}</span>
                                    <span>Trả lời đúng : {{ $rank->true_answer }}</span>
                                    <span>Trả lời sai : {{ $rank->false_answer }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="   col-12 mb-1">
                            <div class="card   p-3 card-flush">
                                <h3>Chưa có danh sách !</h3>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Danh sách câu hỏi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="list-group">
                                @foreach ($exam->questions as $key => $question)
                                    <div class="list-group-item list-group-item-action">
                                        <div
                                            class="d-flex w-100 justify-content-between align-content-center align-items-center mb-4">
                                            <h5 class="mb-1 d-flex">{{ $key + 1 }} : {!! $question->content !!}</h5>
                                            {{-- <small class="text-muted">3 days ago</small> --}}
                                            <div>
                                                <span>Mức độ câu hỏi</span>
                                                @if ($question->rank == config('util.RANK_QUESTION_EASY'))
                                                    <small class="btn badge bg-success">DỄ</small>
                                                @elseif($question->rank == config('util.RANK_QUESTION_MEDIUM'))
                                                    <small class="btn badge bg-success">VỪA PHẢI</small>
                                                @elseif($question->rank == config('util.RANK_QUESTION_DIFFICULT'))
                                                    <small class="btn badge bg-success">KHÓ</small>
                                                @endif
                                            </div>
                                        </div>
                                        <ul class=" list-group-flush">
                                            @foreach ($question->answers as $answer)
                                                <li
                                                    class="list-group-item {{ $answer->is_correct == config('util.ANSWER_TRUE') ? 'active' : '' }}">
                                                    {{ $answer->content }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection
@section('page-script')
    <script>
        const code = "{{ $exam->room_code }}";
        const token = "{{ auth()->user()->createToken('token_admin')->plainTextToken }}";
    </script>
    <script src="http://localhost:6002/socket.io/socket.io.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        window.Echo.channel("public.channel").listen("PublicChannel", function(data) {
            console.log(data);
        });

        window.Echo.join('room.' + code)
            .here((users) => {
                console.log('User online ', users); //
            })
            .joining((user) => {
                console.log('User joining', user); //
            })
            .leaving((user) => {
                this.users = us;
            })
    </script>
@endsection
