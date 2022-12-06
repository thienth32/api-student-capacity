
const cropperImage = {
    cropperImage: function (elementInputImageChange, form_submit) {

        var $modal = $('#modalImageBanner');
        // $modal.modal('show');
        var console = window.console || {
            log: function () { }
        };
        var URL = window.URL || window.webkitURL;
        var $image = $("#image");

        var options = {
            aspectRatio: 5.2,
            autoCrop: true,
            center: true,
            // data: {
            //     height: 300,
            //     width: 1600
            // },
            preview: ".img-preview",
        };
        var originalImageURL = $image.attr("src");
        var uploadedImageURL;

        function runOptionsCropper() {
            $image.cropper("destroy").cropper(options);
        }

        $(document).on('change', elementInputImageChange, function (event) {
            var files = event.target.files;
            var done = function (url) {
                $image.attr("src", url);
                // $image.cropper("destroy").attr("src", url).cropper(options);
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    return done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function () {
            $image.on({}).cropper("destroy")
                .cropper(options);
        }).on('hidden.bs.modal', function () {
            $image.cropper("destroy")
        });
        if (
            typeof document.createElement("cropper").style.transition === "undefined"
        ) {
            $('button[data-method="rotate"]').prop("disabled", true);
        }

        $(".docs-buttons").on("click", "[data-method]", function () {
            var $this = $(this);
            var data = $this.data();
            var cropper = $image.data("cropper");
            var cropped;
            var $target;
            var result;

            if ($this.prop("disabled") || $this.hasClass("disabled")) {
                return;
            }

            if (cropper && data.method) {
                data = $.extend({}, data); // Clone a new one

                if (typeof data.target !== "undefined") {
                    $target = $(data.target);

                    if (typeof data.option === "undefined") {
                        try {
                            data.option = JSON.parse($target.val());
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }

                cropped = cropper.cropped;

                switch (data.method) {
                    case "rotate":
                        if (cropped && options.viewMode > 0) {
                            $image.cropper("clear");
                        }

                        break;


                }

                result = $image.cropper(data.method, data.option, data.secondOption);

                switch (data.method) {
                    case "rotate":
                        if (cropped && options.viewMode > 0) {
                            $image.cropper("crop");
                        }
                        break;

                    case "scaleX":
                    case "scaleY":
                        $(this).data("option", -data.option);
                        break;
                    case "destroy":
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                            uploadedImageURL = "";
                            $image.attr("src", originalImageURL);
                        }
                        break;
                }
                if ($.isPlainObject(result) && $target) {
                    try {
                        $target.val(JSON.stringify(result));
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }
        });
        $(".docs-toggles").on("change", "input", function () {
            var $this = $(this);
            var name = $this.attr("name");
            var type = $this.prop("type");
            var canvasData;
            if (!$image.data("cropper")) return;

            if (type === "checkbox") {
                options[name] = $this.prop("checked");
                cropBoxData = $image.cropper("getCropBoxData");
                canvasData = $image.cropper("getCanvasData");

                options.ready = function () {
                    $image.cropper("setCropBoxData", cropBoxData);
                    $image.cropper("setCanvasData", canvasData);
                };
            } else if (type === "radio") {
                options[name] = $this.val();
            }
            runOptionsCropper()
            // return $image.cropper("destroy").cropper(options);
        });

        $(document.body).on("keydown", function (e) {
            if (e.target !== this || !$image.data("cropper") || this.scrollTop > 300) {
                return;
            }
            switch (e.which) {
                case 37:
                    e.preventDefault();
                    $image.cropper("move", -1, 0);
                    break;
                case 38:
                    e.preventDefault();
                    $image.cropper("move", 0, -1);
                    break;
                case 39:
                    e.preventDefault();
                    $image.cropper("move", 1, 0);
                    break;
                case 40:
                    e.preventDefault();
                    $image.cropper("move", 0, 1);
                    break;
            }
        });

        var $inputImage = $("#inputImage");
        if (URL) {
            $inputImage.change(function () {
                var files = this.files;
                var file;
                if (!$image.data("cropper")) {
                    return;
                }
                if (files && files.length) {
                    file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {
                        uploadedImageName = file.name;
                        uploadedImageType = file.type;
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }

                        uploadedImageURL = URL.createObjectURL(file);
                        $image
                            .cropper("destroy")
                            .attr("src", uploadedImageURL)
                            .cropper(options);
                        $inputImage.val("");
                    } else {
                        window.alert("Please choose an image file.");
                    }
                }
            });
        } else {
            $inputImage.prop("disabled", true).parent().addClass("disabled");
        }

        const convertBase64 = (file) => {
            return new Promise((resolve, reject) => {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(file);

                fileReader.onload = () => {
                    resolve(fileReader.result);
                };

                fileReader.onerror = (error) => {
                    reject(error);
                };
            });
        };

        $(document).on('click', 'button#crop', function () {
            try {
                var cropper = $image.data("cropper");
                cropper.getCroppedCanvas().toBlob((blob) => {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        $('#uploaded_image').attr('src', base64data);
                        $modal.modal('hide');
                        $('textarea#valueImageCrop').val(base64data);
                    };
                });
            } catch (error) {
                console.log(error);
            }


        });

        // $(form_submit).submit(function (e) {
        //     e.preventDefault();
        //     let textarea = `<textarea name="fileimage" id="" cols="30" rows="10">${dataFileImage}</textarea>`
        //     $(this).append(textarea);
        //     // `<input id="" hidden type="text" name="fileimage" value="${dataFileImage}">`
        //     setTimeout(() => {
        //         this.submit();
        //     }, 500);
        // });
    }
}


