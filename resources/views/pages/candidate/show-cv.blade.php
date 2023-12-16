@extends('layouts.main')
@section('title', 'Xem CV ứng viên')
@section('page-title', 'Xem CV ứng viên')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.candidate.list') }}" class="pe-3">Thông tin ứng tuyển</a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.post.detail', ['slug' => $data->post->slug]) }}" class="pe-3">Mã tuyển
                            dụng
                            : {{ $data->post->code_recruitment }}</a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">SV:{{ $data->name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 mb-5 mb-xl-10">
            <div class="card sticky-top p-2">
                <!--begin::Heading-->
                <div
                    class=" rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
                    style="height: 250px">
                    <!--begin::Title-->
                    <div class="p-5 h-100">
                        <form class="card p-2 h-100" action="{{ route('admin.candidate.createNote', ['candidate_id' => $data->id]) }}" method="post">
                            @csrf
                            <div class="card-header p-2 align-items-center">
                                <h5 class="card-title">
                                    Tạo mới ghi chú
                                </h5>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                    Lưu và gửi email
                                </button>
                            </div>
                            <div class="card-body form-group p-2">
                                <textarea class="form-control h-100" name="content" required id="" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card p-2">
                    <div class="card-header p-2">
                        <h3 class="card-title fs-3">Danh sách ghi chú ({{ $data->candidateNotes->count() }})</h3>
                    </div>
                    <div class="card-body p-2" style="height: 150px; overflow-y: auto">
                        @foreach($data->candidateNotes as $idx => $note)
                            <ul style="list-style: none;">
                                <li>
                                    <b>{{$idx + 1}}
                                        . {{ date('d-m-Y H:i', strtotime($note->created_at)) }}
                                        - {{$note->user->email}}</b>
                                    <p>{{$note->content}}</p>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-8 mb-5 mb-xl-10">

            <div class="container-fluid  card card-flush">
                <div class="row">
                    <div class="col-lg-12">

                        <div style="width:100%; height: 700px" class=" fs-3">
                            <iframe
                                src="{{ Storage::disk('s3')->temporaryUrl($data->file_link, now()->addMinutes(5)) }}"
                                frameborder="0" width="100%" height="100%"></iframe>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
@endsection
