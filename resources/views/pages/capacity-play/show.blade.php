@extends('layouts.main')
@section('title', 'Quản lý trò chơi trực tiếp')
@section('page-title', 'Quản lý trò chơi trực tiếp')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.capacit.play.index') }}" class="pe-3">
                        Danh sách trò chơi trực tiếp
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Chi tiết </li>
            </ol>
            <input type="hidden" value="{{ session()->get('token') }}" class="show-token">
            <input type="hidden" value="{{ auth()->id() }}" class="id-me">
        </div>
    </div>
    <div style="    background-image: url('assets/media/images/quiz-background.webp');
    background-size: cover;
}"
        class="card card-flush p-4">
        @if ($exam->status == 2)
            <div class="alert alert-primary text-center">
                <h2 class="text-primary"> Trò chơi đã kết thúc </h2>
            </div>
        @else
            <div class="alert alert-primary mb-1  text-center">
                @if ($exam->type == 1)
                    <a href="{{ route('admin.capacit.play.view.run', ['id' => $exam->room_code]) }}"
                        class="btn btn-primary">
                        Bắt đầu
                    </a>
                @else
                    <a href="{{ route('admin.capacit.play.run', ['id' => $exam->room_code]) }}" class="btn btn-primary">
                        Bắt đầu
                    </a>
                @endif


                <h2>Danh sách tài khoản trực tuyến </h2>
                <div id="show-user-online" class="flex flex-md-column-fluid">
                    Máy chủ đang khởi động
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-lg-4 col-12 mb-1">
                <div class="alert alert-primary p-3 rounded  ">
                    <div class="card card-flush p-2">
                        <h2>Trò chơi : {{ $exam->name }} </h2>
                        <h2>Mã trò chơi : <button data-bs-toggle="tooltip" title="Copy" type="button"
                                class="copy_to btn btn-primary btn-sm">{{ $exam->room_code }}</button> </h2>
                        <h2>Điểm thưởng : <strong>{{ $exam->max_ponit }}</strong>
                        </h2>
                        <h2>Hình thức trực tuyến : <strong>{{ $exam->status == 0 ? 'Tự động' : 'Điều khiển ' }}</strong>
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


        @if (count($ranks) > 0)
            <div class="col-lg-12 col-12 mt-1">
                <div class="alert alert-primary p-3 rounded   text-center">
                    <h2 class="mb-2">Danh sách tài khoản </h2>
                    <div class="row">
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
                        {{-- @else
                        <div class="   col-12 mb-1">
                            <div class="card   p-3 card-flush">
                                <h3>Chưa có danh sách !</h3>
                            </div>
                        </div>
                    @endif --}}

                    </div>
                </div>
            </div>
        @endif
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
    <script src="{{ asset('assets/js/system/capacity-play/capacity-play.js') }}"></script>
    @if ($exam->status !== 2)
        <script src="{{ request()->getScheme() }}://{{ request()->getHost() }}:6001/socket.io/socket.io.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            const code = "{{ $exam->room_code }}";
            var users = [];

            function renderUser() {
                var html = users.map(function(data) {
                    return `
                    <span class="bg-primary p-2 text-light rounded mb-1">${data.id == $('.id-me').val() ? '(Bạn)' : ''} ${data.name}</span>
                `;
                }).join(" ");
                $('#show-user-online').html(html);
            }
            window.Echo.join('room.' + code)
                .here((users) => {
                    this.users = users;
                    renderUser();
                })
                .joining((user) => {
                    this.users.push(user);
                    renderUser();
                })
                .leaving((user) => {
                    var us = this.users.filter(function(data) {
                        return data.id !== user.id;
                    });
                    this.users = us;
                    renderUser();
                });
        </script>
    @endif
@endsection
