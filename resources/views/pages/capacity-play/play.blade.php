@extends('layouts.main')
@section('title', 'Trực tiếp trò chơi ')
@section('page-title', 'Trực tiếp trò chơi ')
@section('content')

    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h2> <i class="bi bi-hourglass-split"></i> Trực tiếp trò chơi {{ $exam->name }}
                        <small class="text-primary">{{ $exam->questions_count }} /
                            {{ count(json_decode($exam->room_progress) ?? []) == 0 ? 1 : count(json_decode($exam->room_progress) ?? []) }}
                        </small>
                        </h1>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2>{!! $question->content !!}</h2>
            @foreach ($question->answers as $answer)
                <li>{!! $answer->content !!}</li>
            @endforeach
        </div>

        <div class=" d-flex flex-row-reverse bd-highlight">
            @if ($exam->questions_count == count(json_decode($exam->room_progress) ?? []))
                <a href="{{ route('admin.capacit.play.end', ['id' => $exam->room_code]) }}" class=" btn btn-primary">Kết thúc
                </a>
            @else
                @php
                    $countProgress = count(json_decode($exam->room_progress) ?? []);
                    $key = 1;
                    foreach ($exam->questions as $key => $question) {
                        if (!in_array($question->id, json_decode($exam->room_progress) ?? [])) {
                            $key = $key;
                            break;
                        }
                    }
                    $next = $exam->questions[$key]->id;
                    // $next = $exam->questions[$countProgress == 0 ? 1 : $countProgress ?? []]->id;
                @endphp
                <a href="{{ route('admin.capacit.play.run', ['id' => $exam->room_code, 'next' => $next]) }}"
                    class=" btn btn-primary">Câu tiếp theo
                </a>
            @endif
        </div>

    </div>

    <div class="card card-flush mt-2 p-2">
        <div class="card-body pt-2">
            @foreach ($ranks as $key => $rank)
                <div class="d-flex align-items-center mb-7">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <img src="https://icons.iconarchive.com/icons/custom-icon-design/pretty-office-11/512/number-{{ $key + 1 }}-icon.png"
                            class="" alt="">
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Text-->
                    <div class="flex-grow-1">
                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ $rank['user']['name'] }}
                        </a>
                        <span class="text-muted d-block fw-bold">Trả lời đúng {{ $rank['true_answer'] }}</span>
                        <span class="text-muted d-block fw-bold">Trả lời sai {{ $rank['false_answer'] }}</span>
                        <span class="text-muted d-block fw-bold">Không trả lời {{ $rank['donot_answer'] }}</span>
                    </div>
                    <!--end::Text-->
                </div>
            @endforeach
        </div>
    </div>


@endsection
@section('page-script')
@endsection
