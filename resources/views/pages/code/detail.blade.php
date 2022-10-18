@extends('layouts.main')
@section('title', 'Quản lý bài thử thách')
@section('page-title', 'Quản lý bài thử thách')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.code.manager.list') }}" class="pe-3">
                        Danh sách bài thử thách
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">Chi tiết bài thử thách </li>
            </ol>
        </div>
    </div>

    <div class="card card-flush h-lg-100 p-5 ">
        <div class="row">
            <div class="col-lg-4 ">
                <div class="p-5 bg-secondary rounded">

                    <div>
                        <span class="h6">Tên bộ thử thách:</span> {{ $data->name }}
                    </div>
                    <hr>
                    <div>
                        <span class="h6">Nội dung:</span>
                        <br>
                        {!! $data->content !!}
                    </div>
                    <hr>
                    <div>
                        <span class="h6">Kết quả bài test:</span>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalId">
                            Hiển thị {{ count($data->result) }} kết quả
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitleId">Danh sách kết quả bài test</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped  table-hover	  table-borderless   align-middle">
                                                <thead class=" table-dark">
                                                    <tr>
                                                        <th>Thông tin người làm</th>
                                                        <th>Ngôn ngữ</th>
                                                        <th>Điểm</th>
                                                        <th>Trạng thái</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-group-divider">
                                                    @if ($data->result->count())
                                                        @foreach ($data->result as $resu)
                                                            <tr class="">
                                                                <td scope="row">
                                                                    {{ $resu->user->name }}
                                                                    <br>
                                                                    {{ $resu->user->email }}
                                                                </td>
                                                                <td>{{ $resu->code_language->name }}</td>
                                                                <td> {{ $resu->point }}</td>
                                                                <td> <span
                                                                        class="badge badge-primary">{{ $resu->status == 0 ? 'Đang làm' : 'Đã làm xong' }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>

                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="p-5 bg-secondary rounded">
                    <div class=" d-flex justify-content-start align-items-baseline">
                        <span style="width: 20%" class="h6 me-4 ">Điểm thưởng:</span>
                        <div class="d-flex justify-content-start align-items-baseline">
                            <div class="h1 me-10">TOP1 : <span>{{ $data->rank_point->top1 }}</span>
                            </div>
                            <div class="h2 me-10">TOP2 : <span>{{ $data->rank_point->top2 }}</span> </div>
                            <div class="h3 me-10">TOP3 : <span>{{ $data->rank_point->top3 }}</span></div>
                            <div class="h4">Leave : <span>{{ $data->rank_point->leave }}</span></div>
                        </div>
                    </div>
                    <hr>
                    <div class=" d-flex justify-content-start align-items-baseline">
                        <span style="width: 20%" class="h6 me-4 ">Mức độ thử thách :</span>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm">
                                {{ $data->type == 0 ? 'Dễ' : ($data->type == 1 ? 'Trung bình ' : 'Khó') }}
                            </button>
                        </div>
                    </div>

                    <hr>
                    <div class=" d-flex justify-content-start align-items-baseline">
                        <span style="width: 20%" class="h6 me-4 ">Ngôn ngữ hỗ trợ:</span>
                        <div>
                            @if (count($data->sample_code) > 0)
                                @foreach ($data->sample_code as $sample_code)
                                    <span class="badge badge-info"> {{ $sample_code->code_language->name }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <hr>
                    <div class=" d-flex justify-content-start align-items-baseline">
                        <span style="width: 20%" class="h6 me-4 ">Test case:</span>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_{{ $data->id }}">
                                Xem {{ count($data->test_case) }} test case
                            </button>

                            <div class="modal fade" tabindex="-1" id="kt_modal_{{ $data->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Test case {{ $data->name }}</h5>
                                        </div>

                                        <form
                                            action="{{ route('admin.code.manager.update.test.case', ['id' => $data->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="test_case">
                                                    <!--begin::Form group-->
                                                    <div class="form-group">
                                                        <div data-repeater-list="test_case">
                                                            @if (count($data->test_case) > 0)
                                                                @foreach ($data->test_case as $test_case)
                                                                    <div data-repeater-item>
                                                                        <div class="form-group row">
                                                                            <input type="hidden"
                                                                                value="{{ $test_case->id }}"
                                                                                name="id_test_case">
                                                                            <div class="col-md-3">
                                                                                <label for="" class="form-label">Đầu
                                                                                    vào </label>
                                                                                <input type="text" name="input"
                                                                                    value="{{ $test_case->input }}"
                                                                                    class=" form-control" placeholder="">
                                                                                @error('input')
                                                                                    <p class="text-danger">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <label for=""
                                                                                    class="form-label">Đầu
                                                                                    ra </label>
                                                                                <input type="text" name="output"
                                                                                    value="{{ $test_case->output }}"
                                                                                    class=" form-control" placeholder="">
                                                                                @error('output')
                                                                                    <p class="text-danger">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="col-md-2">
                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                                                    <input class="form-check-input"
                                                                                        name="status" type="checkbox"
                                                                                        value="1"
                                                                                        @checked($test_case->status == 0)
                                                                                        id="form_checkbox" />
                                                                                    <label class="form-check-label"
                                                                                        for="form_checkbox">
                                                                                        Test ẩn
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <a href="javascript:;" data-repeater-delete
                                                                                    class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                    <i class="la la-trash-o"></i>Xóa
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div data-repeater-item>
                                                                    <div class="form-group row">
                                                                        <input type="hidden" name="id_test_case">
                                                                        <div class="col-md-3">
                                                                            <label for="" class="form-label">Đầu
                                                                                vào </label>
                                                                            <input type="text" name="input"
                                                                                class=" form-control" placeholder="">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="" class="form-label">Đầu
                                                                                ra </label>
                                                                            <input type="text" name="output"
                                                                                class=" form-control" placeholder="">
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <div
                                                                                class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                                                <input class="form-check-input"
                                                                                    name="status" type="checkbox"
                                                                                    value="1" id="form_checkbox" />
                                                                                <label class="form-check-label"
                                                                                    for="form_checkbox">
                                                                                    Test ẩn
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <a href="javascript:;" data-repeater-delete
                                                                                class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                <i class="la la-trash-o"></i>Xóa
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-5">
                                                        <a href="javascript:;" data-repeater-create
                                                            class="btn btn-light-primary">
                                                            <i class="la la-plus"></i>Thêm mới
                                                        </a>
                                                    </div>
                                                </div>
                                                @error('test_case')
                                                    <script>
                                                        toastr.warning("{{ $message }}");
                                                    </script>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light btn-sm"
                                                    data-bs-dismiss="modal">Thoát
                                                </button>
                                                <button class="btn btn-primary btn-sm">Lưu lại</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('page-script')
    <script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script>
        const _token = "{{ csrf_token() }}";
        $('.test_case').slideDown();
        $('.test_case').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endsection
