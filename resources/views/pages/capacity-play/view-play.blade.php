@extends('layouts.main')
@section('title', 'Trực tiếp trò chơi ')
@section('page-title', 'Trực tiếp trò chơi ')
@section('content')
    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h2> <i class="bi bi-hourglass-split"></i> Trực tiếp trò chơi {{ $exam->name }}
                    </h2>
                </div>
                <input type="hidden" value="" class="ranks">
                <input type="hidden" value="{{ session()->get('token') }}" class="show-token">
                <input type="hidden" value="{{ count($exam->questions) }}" class="count_question">
            </div>
        </div>



        <div class=" d-flex flex-row-reverse bd-highlight">
            <a href="{{ route('admin.capacit.play.end', ['id' => $exam->room_code]) }}" class=" btn btn-primary">Kết thúc
            </a>
        </div>

        <div class="text-center show-rank">

        </div>

    </div>

@endsection
@section('page-script')
    <script src="{{ request()->getScheme() }}://{{ request()->getHost() }}:6001/socket.io/socket.io.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var ranks = @json($ranks);
        const code = "{{ $exam->room_code }}"
        const count_question = $('.count_question').val();

        function renderRanks() {
            console.log(ranks);

            var html = ranks.map(function(data, key) {
                return `
                   <div class="border p-2  mt-1">
                        <h2> ${data.user.name} <i class="bi bi-award-fill"></i> : ${key + 1}</h2>
                        <div style="height: 20px" class="progress">
                            <div class="progress-bar" role="progressbar" style="width: ${(data.true_answer / count_question)*100}%" aria-valuenow="50" aria-valuemin="0"
                                aria-valuemax="100"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: ${(data.false_answer / count_question)*100}%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                `;
            }).join(" ");
            if (ranks.length == 0) {
                html = `

                <div class="border p-2  mt-1">
                    <h2> Chưa có tiến trình làm bài <i class="bi bi-award-fill"></i> : 1</h2>
                    <div style="height: 20px" class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                `;
            }
            $('.show-rank').html(html);
        }
        renderRanks();
        window.Echo.join('room.' + code)
            .here((users) => {})
            .joining((user) => {})
            .leaving((user) => {}).listen('UpdateGameEvent', function(data) {
                this.ranks = data.ranks;
                renderRanks();
            })
    </script>
@endsection
