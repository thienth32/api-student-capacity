<div id="modalImageBanner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitleId" class="modal-title">Chỉnh sửa hình ảnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="img-container">
                                <img id="image" src="{{ asset('images/FPT_Polytechnic_Hanoi.webp') }}"
                                    alt="Picture" />
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="docs-preview clearfix">
                                <div class="img-preview preview-lg"></div>
                                <div class="img-preview preview-md"></div>
                                {{-- <div class="img-preview preview-sm"></div> --}}
                                {{-- <div class="img-preview preview-xs"></div> --}}
                            </div>
                            <div class="docs-toggles mt-3">
                                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                    <div>
                                        <input id="aspectRatio0" value="1.7777777777777777" type="radio"
                                            class="btn-check" name="aspectRatio" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="aspectRatio0"
                                            title="aspectRatio: 16 / 9">
                                            16:9</label>
                                    </div>
                                    <div>
                                        <input id="aspectRatio1" value="1" type="radio" class="btn-check"
                                            name="aspectRatio" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="aspectRatio1"
                                            title="aspectRatio: 1/1">
                                            1:1</label>
                                    </div>
                                    <div>
                                        <input id="aspectRatio2" value="1.5" type="radio" class="btn-check"
                                            name="aspectRatio" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="aspectRatio2"
                                            title="aspectRatio: 3/2">
                                            3:2</label>
                                    </div>
                                    <div>
                                        <input id="aspectRatio3" value="0.75" type="radio" class="btn-check"
                                            name="aspectRatio" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="aspectRatio3"
                                            title="aspectRatio: 3/4">
                                            3:4</label>
                                    </div>
                                    <div>
                                        <input id="aspectRatio4" value="1.33333" type="radio" class="btn-check"
                                            name="aspectRatio" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="aspectRatio4"
                                            title="aspectRatio: 4/3 ">
                                            4:3</label>
                                    </div>
                                    <div>
                                        <input id="aspectRatio5" value="0.8" type="radio" class="btn-check"
                                            name="aspectRatio" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="aspectRatio5"
                                            title="aspectRatio: 4/5 ">
                                            4:5</label>
                                    </div>
                                    <div>
                                        <input id="aspectRatio6" value="5.2" type="radio" class="btn-check"
                                            name="aspectRatio" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="aspectRatio6"
                                            title="aspectRatio: Free">
                                            Mặc định</label>
                                    </div>

                                </div>
                                <div class="btn-group d-flex flex-nowrap  mt-4" data-toggle="buttons">
                                    <label class="btn btn-primary active">
                                        <input id="viewMode0" hidden type="radio" class="sr-only" name="viewMode"
                                            value="0" checked />
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                                            title="View Mode 0">
                                            VM0
                                        </span>
                                    </label>
                                    <label class="btn btn-primary">
                                        <input id="viewMode1" hidden type="radio" class="sr-only" name="viewMode"
                                            value="1" />
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                                            title="View Mode 1">
                                            VM1
                                        </span>
                                    </label>
                                    <label class="btn btn-primary">
                                        <input id="viewMode2" hidden type="radio" class="sr-only" name="viewMode"
                                            value="2" />
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                                            title="View Mode 2">
                                            VM2
                                        </span>
                                    </label>
                                    <label class="btn btn-primary">
                                        <input id="viewMode3" hidden type="radio" class="sr-only" name="viewMode"
                                            value="3" />
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                                            title="View Mode 3">
                                            VM3
                                        </span>
                                    </label>
                                </div>
                                <hr>
                            </div>
                            <div class="docs-buttons">
                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="setDragMode"
                                        data-option="move" title="Move">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-arrows"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="setDragMode"
                                        data-option="crop" title="Crop">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-crop"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="zoom"
                                        data-option="0.1" title="Zoom In">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-search-plus"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="zoom"
                                        data-option="-0.1" title="Zoom Out">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-search-minus"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="move"
                                        data-option="-10" data-second-option="0" title="Move Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-arrow-left"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move"
                                        data-option="10" data-second-option="0" title="Move Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-arrow-right"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move"
                                        data-option="0" data-second-option="-10" title="Move Up">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-arrow-up"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move"
                                        data-option="0" data-second-option="10" title="Move Down">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-arrow-down"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="rotate"
                                        data-option="-45" title="Rotate Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-rotate-left"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="rotate"
                                        data-option="45" title="Rotate Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" tit>
                                            <span class="fa fa-rotate-right"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="scaleX"
                                        data-option="-1" title="Flip Horizontal">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-arrows-h"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="scaleY"
                                        data-option="-1" title="Flip Vertical">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-arrows-v"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="crop"
                                        title="Crop">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                        </span>
                                        <span class="fa fa-check"></span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="clear"
                                        title="Clear">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-remove"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="disable"
                                        title="Disable">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-lock"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="enable"
                                        title="Enable">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-unlock"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="mb-4 btn-group">
                                    <button type="button" class="btn btn-primary" data-method="reset"
                                        title="Reset">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
                                            <span class="fa fa-refresh"></span>
                                        </span>
                                    </button>
                                    <label class="btn btn-primary btn-upload" for="inputImage"
                                        title="Upload image file">
                                        <input id="inputImage" type="file" class="sr-only" name="file"
                                            accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" />
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                                            title="Import image with Blob URLs">
                                            <span class="fa fa-upload"></span> Thay đổi
                                            file
                                        </span>
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy chỉnh sửa</button>
                <button id="crop"type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<textarea hidden name="{{ $name }}" id="valueImageCrop" cols="30" rows="10"></textarea>
{{-- <input type="text" id="valueImageCrop"> --}}
