@extends('layouts.main')
@section('title', 'Danh sách đội thi')
@section('content')
    <div class="content">
        <h2 style="font-size: 30px;margin-bottom:70px" class="text-center "> Danh sách Đội thi</h2>
        <div class="row">
            <div class="col-md-4">
                <div style="width:300px" class="form-group mb-5">
                    <label for="">
                        <h3>Danh Sách cuộc thi</h3>
                    </label>

                    <select class="form-control" name="" id="selectContest">
                        <option>___CHỌN CUỘC THI___</option>
                        @foreach ($Contest as $itemContest)
                            <option value="{{ $itemContest->id }}"> Cuộc Thi :{{ $itemContest->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div style="width:300px" class="form-group mb-5">
                    <label for="">
                        <h3>Sắp xếp Đội Thi</h3>
                    </label>

                    <select class="form-control" name="" id="selectOderByTeam">
                        <option>___CHỌN___</option>
                        <option value="name">Sắp xếp theo tên</option>
                        <option value="created_at">Sắp xếp theo Thời gian</option>
                        <option value="id">Các đội mới lập</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div style="width:300px" class="form-group mb-5">
                    <label for="">
                        <h3>Tìm Kiếm Đội Thi</h3>
                    </label>


                    <div class="form-group">
                        <input id="searchTeam" placeholder="Nhập Tên nhóm...." type="text" class="form-control" name=""
                            aria-describedby="helpId" placeholder="">

                    </div>


                </div>
            </div>
        </div>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên Nhóm</th>
                    <th scope="col">Ảnh nhóm </th>
                    <th scope="col"> Tham gia Cuộc Thi </th>
                    <th scope="col"> Ngày Tạo </th>
                    <th scope="col"> Thành Viên </th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="dataTeams">
                <?php $index = 0; ?>
                @foreach ($dataTeam as $valueTeam)
                    <tr>
                        <th scope="row">{{ $index += 1 }}</th>
                        <td>{{ $valueTeam->name }}</td>
                        <td><img style="width:200px;height:200px"
                                src="{{ Storage::disk('google')->has($valueTeam->image)? Storage::disk('google')->url($valueTeam->image): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                alt=""></td>
                        <td>{{ $valueTeam->contest->name }}</td>
                        <td>{{ date('d-m-Y', strtotime($valueTeam->created_at)) }}</td>
                        <td>
                            <div class="btn-group dropup">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Xem Thêm...
                                </button>
                                <ul class="dropdown-menu">

                                    @foreach ($valueTeam->members as $member)
                                        <li><a class="dropdown-item" href="javascript:void()"> Thành Viên
                                                : {{ $member->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                        >
                        <td> <a data-url="{{ route('admin.delete.teams', $valueTeam->id) }}" id="{{ $valueTeam->id }}"
                                class="btn btn-danger deleteTeams"><i class="fas fa-trash-alt"></i></a>

                            <a href="{{ route('admin.teams.edit', $valueTeam->id) }}" class="btn  btn-success "><i
                                    class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>
        <hr>
        <div>
            {{ $dataTeam->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>
    </div>




@endsection

@section('js_admin')
    <script>
        $(document).ready(function() {

            $(document).on('change', '#selectContest', function(e) {
                e.preventDefault();
                let idContest = $(this).val();

                $.ajax({
                    url: "{{ route('admin.contest.team') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        contest: idContest,
                    },
                    success: function(response) {

                        if (response == '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'SOS',
                                text: 'Không Có đội thi nào',
                                footer: '<a href="">Why do I have this issue?</a>'
                            })

                        } else {
                            $('#dataTeams').empty();
                            $('#dataTeams').html(response)
                        }
                    }
                });
            });
            $('#selectOderByTeam').change(function(e) {
                e.preventDefault();
                let orderBy = $(this).val();
                // alert(orderBy)
                $.ajax({
                    url: "{{ route('admin.contest.team') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        orderBy: orderBy,
                        sortBy: 'desc'
                    },
                    success: function(response) {
                        if (response == null) {
                            Swal.fire({
                                icon: 'error',
                                title: 'SOS',
                                text: 'Không Có đội thi nào',
                                footer: '<a href="">Why do I have this issue?</a>'
                            })

                        } else {
                            $('#dataTeams').empty();

                            $('#dataTeams').html(response)
                        }



                    }
                })
            })
            $('#searchTeam').keyup(function(e) {
                e.preventDefault();
                let keySearch = $(this).val();
                $.ajax({
                    url: "{{ route('admin.contest.team') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        keyword: keySearch,
                    },
                    success: function(response) {

                        $('#dataTeams').empty();
                        $('#dataTeams').html(response)
                    }
                });

            })




            $('.deleteTeams').click(function() {
                var urlTeam = $(this).attr('data-url');

                Swal.fire({
                    title: 'Bạn có muốn xóa không?',
                    text: "Sẽ không thể phục hồi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: urlTeam,
                            type: 'delete',
                            data: {
                                _token: "{{ csrf_token() }}",

                            },
                            success: function(response) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Xóa Thành Công',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $('#dataTeams').empty();
                                    $('#dataTeams').html(response)
                            }
                        })

                    }
                })
            })

        });

        function removeTeam(id) {

            Swal.fire({
                title: 'Bạn có muốn xóa không?',
                text: "Sẽ không thể phục hồi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('admin/teams') }}/" + id,
                        type: 'delete',
                        data: {
                            _token: "{{ csrf_token() }}",

                        },
                        success: function(response) {

                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Xóa Thành Công',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#dataTeams').empty();
                                $('#dataTeams').html(response)
                            // } else {
                            //     Swal.fire({
                            //         position: 'center',
                            //         icon: 'success',
                            //         title: 'Xóa thất bại',
                            //         showConfirmButton: false,
                            //         timer: 1500
                            //     })
                            // }

                        }
                    })

                }
            })
        }
    </script>

@endsection
