@extends('layouts.main')
@section('title', 'Danh sách đội thi')
@section('page-title', 'Danh sách đội thi')
@section('content')
    <style>
        #loading {
            position: fixed;
            z-index: 100;
            top: 40%;
            left: 55%;
            display: none;
            width: 3.5em;
            height: 3.5em;
            border: 3px solid transparent;
            border-top-color: #3cefff;
            border-bottom-color: #3cefff;
            border-radius: 50%;
            animation: spin 1.5s linear infinite;
        }

        #loading:before {
            content: '';
            display: block;
            margin: auto;
            width: 0.75em;
            height: 0.75em;
            border: 3px solid #3cefff;
            border-radius: 50%;
            animation: pulse 1s alternate ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            from {
                transform: scale(0.5);
            }

            to {
                transform: scale(1);
            }
        }

    </style>

    <div id="loading"></div>
    <div class="content">
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
        <div id="listTeams">
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

                            <td> <a data-url="{{ route('admin.delete.teams', $valueTeam->id) }}"
                                    id="{{ $valueTeam->id }}" class="btn btn-danger deleteTeams"><i
                                        class="fas fa-trash-alt"></i></a>

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

    </div>




@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.pagination a').unbind('click').on('click', function(
                e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                getPosts(page, key = '', value = '');
            });

            function getPosts(page, key, value) {
                $('#loading').css('display', 'flex');
                $.ajax({

                    url: "{{ url('admin/teams/api-teams') }}?" + key + "=" + value + "&page=" + page,
                    type: 'get',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#loading').css('display', 'none');
                        $('#listTeams').empty();
                        $('#listTeams').html(data)
                        $('.paginate .pagination a').unbind('click').on('click', function(
                            e) {
                            e.preventDefault();
                            var page = $(this).attr('href').split('page=')[1];
                            getPosts(page, key = '', value);
                        });
                    }
                })

            }


            $(document).on('change', '#selectContest', function(e) {
                e.preventDefault();
                let idContest = $(this).val();
                $('#loading').css('display', 'flex');
                $.ajax({
                    url: "{{ route('admin.contest.team') }}",
                    type: 'get',
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
                            $('#loading').css('display', 'none');
                            $('#listTeams').empty();
                            $('#listTeams').html(response)
                            $('.paginate .pagination a').unbind('click').on('click', function(
                                e) {
                                e.preventDefault();
                                var page = $(this).attr('href').split('page=')[1];
                                getPosts(page, key = 'contest', orderBy);
                            });
                        }
                    }
                });
            });
            $('#selectOderByTeam').change(function(e) {

                e.preventDefault();
                let orderBy = $(this).val();
                $('#loading').css('display', 'flex');
                // alert(orderBy)
                $.ajax({
                    url: "{{ route('admin.contest.team') }}",
                    type: 'get',
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
                            $('#loading').css('display', 'none');
                            $('#listTeams').empty();

                            $('#listTeams').html(response)
                            $('.paginate .pagination a').unbind('click').on('click', function(
                                e) {
                                e.preventDefault();
                                var page = $(this).attr('href').split('page=')[1];
                                getPosts(page, key = 'orderBy', sortBy = orderBy);
                            });
                        }



                    }
                })
            })
            $('#searchTeam').keyup(function(e) {
                e.preventDefault();
                $('#loading').css('display', 'flex');
                let keySearch = $(this).val();
                $.ajax({
                    url: "{{ route('admin.contest.team') }}",
                    type: 'get',
                    data: {
                        _token: "{{ csrf_token() }}",
                        keyword: keySearch,
                    },
                    success: function(response) {
                        $('#loading').css('display', 'none');
                        $('#listTeams').empty();

                        $('#listTeams').html(response)
                        $('.paginate .pagination a').unbind('click').on('click', function(
                            e) {
                            e.preventDefault();
                            var page = $(this).attr('href').split('page=')[1];
                            getPosts(page, key = 'keyword', keySearch);
                        });
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
                        $('#loading').css('display', 'flex');
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
                                $('#loading').css('display', 'none');
                                $('#listTeams').empty();
                                $('#listTeams').html(response)

                            }
                        })

                    }
                })
            })

            function removeTeam(id) {

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Xóa Thành Công',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#loading').css('display', 'none');
                            $('#listTeams').empty();
                            $('#listTeams').html(response)
                            $(document).ready(function() {
                                $('.paginate .pagination a').unbind('click').on('click',
                                    function(
                                        e) {
                                        e.preventDefault();
                                        $('#loading').css('display', 'flex');
                                        var page = $(this).attr('href').split('page=')[1];
                                        $.ajax({

                                            url: "{{ url('admin/teams/api-teams') }}?page=" +
                                                page,
                                            type: 'POST',
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                            },
                                            success: function(data) {
                                                $('#loading').css('display',
                                                    'none');
                                                $('#listTeams').empty();

                                                $('#listTeams').html(data)
                                                $('.paginate .pagination a')
                                                    .unbind('click')
                                                    .on('click', function(
                                                        e) {
                                                        e.preventDefault();
                                                        var page = $(this)
                                                            .attr('href')
                                                            .split('page=')[
                                                                1];
                                                        $('#loading').css(
                                                            'display',
                                                            'flex');
                                                        $.ajax({

                                                            url: "{{ url('admin/teams/api-teams') }}?page=" +
                                                                page,
                                                            type: 'POST',
                                                            data: {
                                                                _token: "{{ csrf_token() }}",
                                                            },
                                                            success: function(
                                                                data
                                                            ) {
                                                                $('#loading')
                                                                    .css(
                                                                        'display',
                                                                        'none'
                                                                    );
                                                                $('#listTeams')
                                                                    .empty();

                                                                $('#listTeams')
                                                                    .html(
                                                                        data
                                                                    ) {
                                                                        $('#loading')
                                                                            .css(
                                                                                'display',
                                                                                'none'
                                                                                );
                                                                        $('#listTeams')
                                                                            .empty();

                                                                        $('#listTeams')
                                                                            .html(
                                                                                data
                                                                            )
                                                                        $('.paginate .pagination a')
                                                                            .unbind(
                                                                                'click'
                                                                            )
                                                                            .on('click',
                                                                                function(
                                                                                    e
                                                                                ) {
                                                                                    e
                                                                                        .preventDefault();
                                                                                    var page =
                                                                                        $(
                                                                                            this
                                                                                        )
                                                                                        .attr(
                                                                                            'href'
                                                                                        )
                                                                                        .split(
                                                                                            'page='
                                                                                        )[
                                                                                            1
                                                                                        ];

                                                                                }
                                                                            );
                                                                    }
                                                                })
                                                            });
                                                }
                                            })
                                        });
                                })

                            }

                        })

                    }
                })
            }
        });
    </script>

@endsection
