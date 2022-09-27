var flagDataSaveHide = true;
var dataQues = null;
var loading = `</div> <h2 class="m-2">Hệ thống đang chạy , vui lòng chờ ...</h2></div>`;
var tags = ["skill", "level", "type", "q", "page", "take"];
var urlFetchQs = "";
var urlFetchSkill = "";

function loadTast(text = "Đang chạy ...", type = "info") {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toastr-top-left",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    if (type === "info") toastr.info(text);
    if (type === "success") toastr.success(text);
}

function backClass(navs, tabs) {
    $(navs[0]).removeClass("active");
    $(tabs[0]).removeClass("active");
    $(tabs[0]).removeClass("show");
    $(navs[1]).addClass("active");
    $(tabs[1]).addClass("active");
    $(tabs[1]).addClass("show");
}

function fetchRoundGet(id) {
    $("#show-exams").html(loading);
    $.ajax({
        type: "GET",
        url: `${urlApiPublic}exam/get-by-round/${id}`,
        success: function (res) {
            // console.log(res);
            if (res.payload.length == 0)
                return $("#show-exams").html(`<h2>Không có đề bài nào !</h2>`);
            exam = res.payload;
            var html = res.payload
                .map(function (data) {
                    return `
                            <tr>
                                <td>${data.name}</td>
                                <td style="text-align: center;">${
                                    data.max_ponit
                                }</td>
                                <td>${data.ponit}</td>
                                <td>${data.time ?? "Chưa có thời gian "}</td>
                                <td>${
                                    data.time_type == 0
                                        ? "Phút"
                                        : data.time_type == 1
                                        ? "Giờ"
                                        : data.time_type == 2
                                        ? "Ngày"
                                        : "Trường hợp chưa có trong hệ thống !"
                                }</td>
                                <td style="text-align: center;">
                                 <div data-bs-toggle="tooltip" title="Cập nhật trạng thái "
                                            class="form-check form-switch">
                                            <input value="${
                                                data.status
                                            }" data-id="${data.id}" data-round_id="${id}"
                                                class="form-select-status form-check-input" ${
                                                    data.status == 1
                                                        ? "checked"
                                                        : ""
                                                }
                                                type="checkbox" role="switch">

                                        </div>
                                 </td>
                                   <td data-bs-toggle="tooltip" title="Theo dõi tiến trình  " style="text-align: center;">
                                     <button style="background: #ccc;padding: 1vh 1vh 1vh 2vh;border-radius: 20px;" type="button"
                                     data-round_id="${id}"
                                     data-exam_id="${
                                         data.id
                                     }" class="btn-click-show-result-exam btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                        <i class="bi bi-graph-down  "></i>
                                    </button>
                                </td>
                                <td data-bs-toggle="tooltip" title="Quản lý câu hỏi câu trả lời " style="text-align: center;">
                                     <button style="background: #ccc;padding: 1vh 1vh 1vh 2vh;border-radius: 20px;" type="button" data-exam_name="${
                                         data.name
                                     }" data-exam_id="${data.id}" class="btn-click-show-exams btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2">

                                        <i class="bi bi-arrows-move"></i>
                                    </button>
                                </td>
                                <td>
                                     <a target="_blank" href="/admin/rounds/${id}/detail/exam/${data.id}/edit?type=1">Chỉnh sửa</a>
                                </td>
                            </tr>
                        `;
                })
                .join(" ");
            $("#show-exams").html(html);
        },
        error: function (res) {
            alert("Đã xảy ra lỗi !");
            backClass([".nav-ql", ".nav-list"], [".tab-ql", ".tab-list"]);
        },
    });
}

function fetchHistoryExam(id) {
    //
    $("#show-result-exam").html(loading);
    $.ajax({
        type: "GET",
        url: `${urlApiPublic}exam/get-history/${id}`,
        success: function (res) {
            $("#print-show").html(`
                    <button data-exam_id="${id}" type="button" class="print-excel btn btn-warning">Xuất EXCEL </button>
                    <button data-exam_id="${id}"   type="button" class="print-pdf btn btn-primary">Xuất PDF </button>
            `);
            if (res.payload.length == 0) {
                $("#show-result-exam").html(
                    `<tr>
                        <td>Không có lịch sử tiến trình  </td>
                    </tr>`
                );
            } else {
                let html = res.payload
                    .map(function (data, index) {
                        return `
                                <tr>
                                    <td>${data.user.name}</td>
                                    <td>${data.user.email}</td>
                                    <td>${data.scores}</td>
                                    <td>${
                                        data.status == 1
                                            ? "Đã nộp"
                                            : "Chưa nộp "
                                    }</td>
                                    <td>${data.false_answer}</td>
                                    <td>${data.true_answer}</td>
                                    <td>
                                         <button data-id="${
                                             data.id
                                         }"   type="button" class="print-hítory-dowload-excel btn btn-primary">Xuất lịch sử (excel)</button>
                                    </td>
                                </tr>
                            `;
                    })
                    .join(" ");
                $("#show-result-exam").html(html);
            }
        },
        error: function (res) {
            alert("Đã xảy ra lỗi !");
            window.location.reload();
        },
    });
}

function checkUrlOut(key, value, urlParams, urlHasFetch) {
    let searchParams = new URLSearchParams(urlHasFetch);

    if (urlHasFetch.indexOf("?")) {
        tags.map(function (data) {
            if (data == key) {
                urlParams = urlParams + "&" + key + "=" + value;
            } else {
                if (searchParams.has(data)) {
                    urlParams =
                        urlParams + "&" + data + "=" + searchParams.get(data);
                }
            }
        });
        return urlParams;
    }
    urlParams = urlParams + "?" + key + "=" + value;
    return urlParams;
}

function fecthQuestionByExams(id, param = [], url = null) {
    $("#show-ques-anw").html(loading);
    $(".btn-add-question-answ").hide();
    var urlQuestion = `${urlApiPublic}exam/get-question-by-exam/${id}?`;
    if (param[0] == -1) {
        urlFetchQs = urlQuestion;
    } else {
        urlFetchQs = checkUrlOut(
            param[0] ?? "",
            param[1] ?? "",
            `${urlApiPublic}exam/get-question-by-exam/${id}?`,
            urlFetchQs
        );
    }

    $.ajax({
        type: "GET",
        url: urlFetchQs + (url ? "&" + url.split("?")[1] : ""),
        success: function (res) {
            let html = "";
            if (res.payload.data.length == 0) {
                html = `<h2>Không có câu hỏi câu trả lời nào </h2>`;
            } else {
                listSave = res.questionsSave;

                html = res.payload.data
                    .map(function (data, index) {
                        var skillChill = data.skills
                            .map(function (val_skill) {
                                return `
                                    <span style="background: #ccc ; color : white ; padding : 5px ; margin : 1px"> ${val_skill.name} </span>
                                `;
                            })
                            .join(" ");
                        if (data.skills.length == 0)
                            skillChill = `  <span style="background: #ccc ; color : white ; padding : 5px ; margin : 1px"> Không có skill </span>`;
                        let result = listSave.filter(function (dt) {
                            return dt.id == data.id;
                        });
                        if (result.length == 0)
                            listSave.push({
                                name: data.content,
                                id: data.id,
                            });

                        var htmlChild = data.answers
                            .map(function (val) {
                                return `
                                <p> ${
                                    val.content
                                } ${val.is_correct == 1 ? " <strong>- Đáp án đúng </strong> " : ""} </p>
                            `;
                            })
                            .join(" ");
                        return `
                            <tr>
                            <td>${index + 1}</td>
                                <td>
                                    <a  data-bs-toggle="collapse" href="#multiCollapseExample${index}"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="multiCollapseExample${index}">
                                    ${data.content} - ${skillChill}
                                    </a>

                                    <div class="collapse multi-collapse" id="multiCollapseExample${index}">
                                        <div class="card card-body">
                                            ${htmlChild}
                                        </div>
                                    </div>

                                    </td>
                                <td>${
                                    data.rank == 0
                                        ? "Dễ"
                                        : data.rank == 1
                                        ? "Trung bình "
                                        : data.rank == 2
                                        ? "Khó"
                                        : "No "
                                }</td>
                                <td>${
                                    data.type == 0
                                        ? "Một đáp án"
                                        : data.type == 1
                                        ? "Nhiều đáp án "
                                        : "No"
                                }</td>
                                <td>${
                                    data.status == 0
                                        ? "Đóng "
                                        : data.status == 1
                                        ? "Mở"
                                        : "No"
                                }</td>
                                <td>
                                    <i data-bs-toggle="tooltip" title="Xóa câu hỏi " role="button" data-id="${
                                        data.id
                                    }" class="btn-dettach bi bi-backspace-reverse-fill fs-2x"></i>
                                </td>
                            </tr>
                        `;
                    })
                    .join(" ");
            }
            questions = res.question;
            // let paginate = res.payload.links
            //     .map(function (link, key) {
            //         var datapage = `${link.label}`;
            //         if (key == 0)
            //             datapage = `<i class="bi bi-chevron-left"></i>`;
            //         if (key == res.payload.links.length - 1)
            //             datapage = `<i class="bi bi-chevron-right"></i>`;
            //         return `
            //             <li class="page-item ${
            //                 link.active == true ? "active" : ""
            //             }" ><a role="button" data-link="${link.url}" class="click-paginate-link page-link" >${datapage}</a></li>
            //         `;
            //     })
            //     .join(" ");
            // $("#show-paginate").html(paginate);
            $("#show-ques-anw").html(html);
            $(".btn-add-question-answ").show();
        },
        error: function (res) {
            alert("Đã xảy ra lỗi !");
            window.location.reload();
        },
    });
}

function getApiShowQues(url, param = []) {
    $("#show-add-questions").html(loading);

    if (param[0] == -1) {
        urlFetchSkill = url;
    } else {
        urlFetchSkill = checkUrlOut(
            param[0] ?? "",
            param[1] ?? "",
            url,
            urlFetchSkill
        );
    }

    $.ajax({
        type: "GET",
        url: urlFetchSkill,
        success: function (res) {
            if (!res.status) return;
            dataQues = res.payload;

            fetchShowQues(res.payload);
        },
        error: function (res) {
            alert("Đã xảy ra lỗi !");
            window.location.reload();
        },
    });
}

function fetchShowQues(dataQ) {
    if (dataQ.length > 0)
        var html = dataQ.map(function (data, index) {
            let flagActive = checkQuesSionHas(data);
            var htmlChild = data.answers
                .map(function (val) {
                    return `
                                <p> ${
                                    val.content
                                } ${val.is_correct == 1 ? "<strong>- Đáp án đúng</strong>  " : ""} </p>
                            `;
                })
                .join(" ");
            var skillChill = data.skills
                .map(function (val_skill) {
                    return `
                <span style="background: #ccc ; color : white , padding : 2px ; margin : 1px"> ${val_skill.name} </span>
            `;
                })
                .join(" ");

            return `

            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <a
                    data-bs-toggle="collapse"
                    href="#multiCollapseExample${index}"
                    role="button"
                    aria-expanded="false"
                    aria-controls="multiCollapseExample${index}">
                    ${
                        data.content
                    } ${flagActive == true ? '<i class="bi bi-check2-square"></i> ' + '<b style="color:lawngreen">Đã chọn</b> | <i data-bs-toggle="tooltip" title="Xóa" role="button" data-id="' + data.id + '" class="click-remove-save bi bi-slash-circle" title="Hủy chọn"></i>' : ""}


                    </a>
                    <p>
                    - Mức độ : ${
                        data.rank == 0
                            ? "Dễ"
                            : data.rank == 1
                            ? "Trung bình "
                            : data.rank == 2
                            ? "Khó"
                            : "No "
                    }
                    - Dạng : ${
                        data.type == 0
                            ? "Một đáp án"
                            : data.type == 1
                            ? "Nhiều đáp án "
                            : "No"
                    } -
                    Tình trạng : ${
                        data.status == 0
                            ? "Đóng "
                            : data.status == 1
                            ? "Mở"
                            : "No"
                    }
                    </p>
                    ${skillChill}
                </div>
                <div>
                    <button
                        class=" btn btn-outline btn-outline-dashed ${
                            flagActive == true ? "disable" : "btn-click-save"
                        } btn-outline-dark btn-active-light-dark btn-sm p-1"
                        data-bs-toggle="tooltip" data-bs-html="true" title="Thêm vào danh sách câu hỏi"
                        data-id="${data.id}"
                        data-name="${data.content.replace(/"/g, "'")}" >
                        <i class="bi bi-plus-square-fill"></i>
                    </button>
                </div>
            </li>
            <div class="collapse multi-collapse" id="multiCollapseExample${index}">
                <div class="card card-body">
                    ${htmlChild}
                </div>
            </div>
        `;
        });
    if (dataQ.length == 0) var html = `Không có bản ghi nào `;
    $("#show-add-questions").html(html);
}

function checkQuesSionHas(data) {
    let result = listSave.filter(function (data_list_save) {
        return data_list_save.id == data.id;
    });
    if (result.length > 0) return true;
    return false;
}

function showListSave() {
    if (dataQues) fetchShowQues(dataQues);
    let html = listSave
        .map(function (data, index) {
            var titleTable = ``;
            if (flagDataSaveHide == false && index == 0)
                titleTable = `<h2> Danh sách câu hỏi chờ (${listSave.length}) <i role="button" data-bs-toggle="tooltip" title="Ẩn danh sách  " class="click-hide-data-save bi bi-eye-fill fs-2x"></i></h2>`;
            if (flagDataSaveHide == true && index == 0)
                titleTable = `<h2> Danh sách câu hỏi chờ (${listSave.length}) <i role="button" data-bs-toggle="tooltip" title="Xem danh sách" class="click-hide-data-save bi bi-eye-slash-fill fs-2x"></i></h2>`;
            if (flagDataSaveHide == false)
                return `
                ${titleTable}
                <div class="p-1 m-1" style="background: #d7d7d7 ;border-radius: 10px ; position: relative   ;  padding-top: 15px !important;
                ">
                ${data.name}
                    <i style=" cursor: pointer;   right: 1vh; position: absolute; top: 50%; transform: translateY(-50%);" data-bs-toggle="tooltip" title="Xóa khỏi danh sách " data-key="${index}" class="click-rm-list bi bi-x fs-2x"></i>
                </div>
            `;
            if (flagDataSaveHide == true) return `${titleTable}`;
        })
        .join(" ");
    $("#show-data-save").html(html);
}

const mainPage = {
    addExam: function () {
        $(".add-exam").on("click", function () {
            backClass([".nav-list", ".nav-ql"], [".tab-list", ".tab-ql"]);
            $("#show-exam-round").html(
                `Danh sách các đề thi của vòng thi <strong style="color:blue">${$(
                    this
                ).data("round_name")}</strong>  `
            );
            fetchRoundGet($(this).data("round_id"));
        });
    },
    showExam: function () {
        $(document).on("click", ".btn-click-show-exams", function () {
            $("#show-tast-qs").hide();
            $("#show-list-qs").show();
            exam_id = $(this).data("exam_id");
            const name = $(this).data("exam_name");
            listSave = [];
            $(".modal-title").html("Quản lý câu hỏi " + name);
            fecthQuestionByExams(exam_id);
        });
    },
    addQuestionSave: function () {
        $(".btn-add-question-answ").on("click", function () {
            $("#show-tast-qs").show();
            $("#show-list-qs").hide();
            $("#select-question-has-take").val(10);
            $("select").val(-1);
            showListSave();
            getApiShowQues(urlApiPublic + "questions?", [-1]);
        });
    },
    saveQuestion: function () {
        $(document).on("click", ".btn-click-save", function () {
            var id = $(this).data("id");
            let result = listSave.filter(function (data) {
                return data.id == id;
            });
            if (result.length > 0) {
                loadTast("Đã tồn tại trong danh sách chờ ");
                return;
            }

            listSave.push({
                name: $(this).data("name"),
                id: id,
            });
            // console.log(listSave);

            showListSave();
            loadTast("Thêm vào danh sách chờ thành công", "success");
        });
    },
    removeListQuestion: function () {
        $(document).on("click", ".click-rm-list", function () {
            listSave.splice($(this).data("key"), 1);
            showListSave();
        });
    },
    removeByListQuestionById: function () {
        $(document).on("click", ".click-remove-save", function () {
            let id = $(this).data("id");
            let key = null;
            listSave.map(function (item, keyData) {
                if (id == item.id) {
                    key = keyData;
                }
            });
            if (key !== null) listSave.splice(key, 1);
            showListSave();
        });
    },
    reload: function () {
        $(".btn-reload").on("click", function () {
            getApiShowQues(urlApiPublic + "questions?", [-1]);
        });
    },
    back: function () {
        $(".btn-back").on("click", function () {
            $("#show-tast-qs").hide();
            $("#show-list-qs").show();
        });
    },
    saveQuestionApi: function () {
        $("#save-qs").on("click", function () {
            $(this).html(`Đang lưu ...`);
            var that = this;
            $.ajax({
                type: "POST",
                url: urlApiPublic + "questions/save-question",
                data: {
                    exam_id: exam_id,
                    question_ids: listSave,
                },
                success: function (response) {
                    if (!response.status) alert("Đã xảy ra lỗi ");
                    fecthQuestionByExams(exam_id);
                    $("#show-tast-qs").hide();
                    $("#show-list-qs").show();
                    $("#save-qs").html("Lưu");
                },
                error: function (res) {
                    alert("Đã xảy ra lỗi !");
                    window.location.reload();
                },
            });
        });
    },
    detachQuestion: function () {
        $(document).on("click", ".btn-dettach", function () {
            var question_id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: urlApiPublic + "questions/dettach-question",
                data: {
                    exam_id: exam_id,
                    questions_id: question_id,
                },
                success: function (response) {
                    if (!response.status) alert("Đã xảy ra lỗi ");
                    // fecthQuestionByExams(exam_id);
                },
                error: function (res) {
                    alert("Đã xảy ra lỗi !");
                    window.location.reload();
                },
            });
        });
    },
    hideDataSave: function () {
        $(document).on("click", ".click-hide-data-save", function () {
            flagDataSaveHide = !flagDataSaveHide;
            showListSave();
        });
    },
    paginateClick: function () {
        $(document).on("click", ".click-paginate-link", function (e) {
            e.preventDefault();
            fecthQuestionByExams(exam_id, [], $(this).data("link"));
        });
    },
    blockF12: function () {
        $(document).keydown(function (event) {
            if (event.keyCode == 123) {
                // Prevent F12
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
                // Prevent Ctrl+Shift+I
                return false;
            }
        });
        document.addEventListener("contextmenu", (event) =>
            event.preventDefault()
        );
    },
    selectQuestionTake: function () {
        $("#select-question-has-take").on("change", function () {
            getApiShowQues(urlApiPublic + "questions?", [
                "take",
                $(this).val(),
            ]);
        });
    },
    selectStatus: function () {
        $(document).on("change", ".form-select-status", function () {
            loadTast();
            let id = $(this).data("id");
            var that = this;
            const url =
                "/admin/rounds/" + $(this).data("round_id") + "/detail/exam";
            if ($(this).val() == 1) {
                $.ajax({
                    url: `${url}/${id}/un-status`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                        $(that).val(0);
                        loadTast("Thành công !", "success");
                    },
                    error: function (request, status, error) {
                        loadTast("Không thành công !", "info");
                    },
                });
            } else {
                $.ajax({
                    url: `${url}/${id}/re-status`,
                    method: "POST",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        if (!data.status) return alert(data.payload);
                        $(that).val(1);
                        loadTast("Thành công !", "success");
                    },
                    error: function (request, status, error) {
                        loadTast("Không thành công !", "info");
                    },
                });
            }
        });
    },
    selectShowResult: function () {
        $(document).on("click", ".btn-click-show-result-exam", function () {
            fetchHistoryExam($(this).data("exam_id"));
        });
    },
    printPDF: function () {
        $(document).on("click", ".print-pdf", function () {
            window.location =
                "admin/prinft-pdf?type=historyExam&exam_id=" +
                $(this).data("exam_id");
            return false;
        });
    },
    printEXCEL: function () {
        $(document).on("click", ".print-excel", function () {
            window.location =
                "admin/prinft-excel?type=historyExam&exam_id=" +
                $(this).data("exam_id");
            return false;
        });
    },
    printHistoryEXCEL: function () {
        $(document).on("click", ".print-hítory-dowload-excel", function () {
            window.location =
                "admin/prinft-excel?type=historyDetailCapacity&capacity_result_id=" +
                $(this).data("id");
            return false;
        });
    },
    btnHide: function () {
        $(".btn-hide").on("click", function () {
            $(".btn-show-" + $(this).data("key")).show();
            $(".btn-hide-" + $(this).data("key")).hide();
            $("#" + $(this).data("key")).hide(500);
        });
    },
    btnShow: function () {
        //
        $(".btn-show").on("click", function () {
            $(".btn-hide-" + $(this).data("key")).show();
            $(".btn-show-" + $(this).data("key")).hide();
            $("#" + $(this).data("key")).show(500);
        });
    },
};
$(".btn-hide").hide();
$("#card_1").hide();
$("#card_2").hide();
mainPage.addExam();
mainPage.showExam();
mainPage.addQuestionSave();
mainPage.saveQuestion();
mainPage.removeListQuestion();
mainPage.reload();
mainPage.back();
mainPage.saveQuestionApi();
mainPage.detachQuestion();
mainPage.hideDataSave();
mainPage.paginateClick();
mainPage.removeByListQuestionById();
mainPage.selectQuestionTake();
mainPage.selectStatus();
mainPage.selectShowResult();
mainPage.printPDF();
mainPage.printEXCEL();
mainPage.printHistoryEXCEL();
mainPage.btnHide();
mainPage.btnShow();

$("#selectSkill").on("change", function () {
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?", [-1]);
    skill = "&skill=" + value;
    getApiShowQues(urlApiPublic + "questions?", ["skill", value]);
});
$("#select-level").on("change", function () {
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?", [-1]);
    skill = "&level=" + value;
    getApiShowQues(urlApiPublic + "questions?", ["level", value]);
});
$("#select-type").on("change", function () {
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?", [-1]);
    skill = "&type=" + value;
    getApiShowQues(urlApiPublic + "questions?", ["type", value]);
});
$("#ip-search").on("keyup", function (e) {
    if (e.key !== "Enter") return;
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?", [-1]);
    skill = "&q=" + value;
    getApiShowQues(urlApiPublic + "questions?", ["q", value]);
});
/////
$("#selectSkillQs").on("change", function () {
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id, [-1]);
    skill = "&skill=" + value;
    fecthQuestionByExams(exam_id, ["skill", value]);
});
$("#select-levelQs").on("change", function () {
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id, [-1]);
    skill = "&level=" + value;
    fecthQuestionByExams(exam_id, ["level", value]);
});
$("#select-typeQs").on("change", function () {
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id, [-1]);
    skill = "&type=" + value;
    fecthQuestionByExams(exam_id, ["type", value]);
});
$("#ip-searchQs").on("keyup", function (e) {
    if (e.key !== "Enter") return;
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id, [-1]);
    skill = "&q=" + value;
    fecthQuestionByExams(exam_id, ["q", value]);
});
