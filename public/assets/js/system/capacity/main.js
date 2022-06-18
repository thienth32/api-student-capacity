var flagDataSaveHide = false;
var dataQues = null;
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
    $("#show-exams").html(`<h2>Đang tải dữ liệu , vui lòng chờ ...</h2>`);
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
                                <td>${data.time ?? "Chưa có thời gian "}</td>
                                <td style="text-align: center;">${
                                    data.status == 1
                                        ? "Mở"
                                        : data.status == 0
                                        ? "Đóng"
                                        : ""
                                }</td>
                                <td style="text-align: center;">
                                     <button style="background: #ccc;padding: 1vh 1vh 1vh 2vh;border-radius: 20px;" type="button" data-exam_name="${
                                         data.name
                                     }" data-exam_id="${data.id}" class="btn-click-show-exams btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2">
                                        <i class="bi bi-ui-checks-grid"></i>
                                    </button>
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

function fecthQuestionByExams(id, param = "?", url = null) {
    $("#show-ques-anw").html(`<h2>Đang tải dữ liệu , vui lòng chờ ... </h2>`);
    $(".btn-add-question-answ").hide();
    $.ajax({
        type: "GET",
        url: url ?? `${urlApiPublic}exam/get-question-by-exam/${id}${param}`,
        success: function (res) {
            if (res.payload.length == 0)
                $("#show-ques-anw").html(
                    `<h2>Không có câu hỏi câu trả lời nào </h2>`
                );
            questions = res.question;
            let html = res.payload.data
                .map(function (data, index) {
                    var skillChill = data.skills
                        .map(function (val_skill) {
                            return `
                        <span style="background: #ccc ; color : white , padding : 2px ; margin : 1px"> ${val_skill.name} </span>
                    `;
                        })
                        .join(" ");
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
                                    <i role="button" data-id="${
                                        data.id
                                    }" class="btn-dettach bi bi-backspace-reverse-fill fs-2x"></i>
                                </td>
                            </tr>
                        `;
                })
                .join(" ");
            let paginate = res.payload.links
                .map(function (link, key) {
                    var datapage = `${link.label}`;
                    if (key == 0)
                        datapage = `<i class="bi bi-chevron-left"></i>`;
                    if (key == res.payload.links.length - 1)
                        datapage = `<i class="bi bi-chevron-right"></i>`;
                    return `
                        <li class="page-item ${
                            link.active == true ? "active" : ""
                        }" ><a role="button" data-link="${link.url}" class="click-paginate-link page-link" >${datapage}</a></li>
                    `;
                })
                .join(" ");
            $("#show-paginate").html(paginate);
            $("#show-ques-anw").html(html);
            $(".btn-add-question-answ").show();
        },
    });
}

function getApiShowQues(url) {
    $("#show-add-questions").html(
        `<h2>Đang tải dữ liệu , vui lòng chờ ...</h2>`
    );
    $.ajax({
        type: "GET",
        url: url,
        success: function (res) {
            if (!res.status) return;
            dataQues = res.payload;
            fetchShowQues(res.payload);
        },
    });
}

function fetchShowQues(dataQ) {
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
                    } ${flagActive == true ? '<i class="bi bi-check2-square"></i> ' + '<b style="color:lawngreen">Đã chọn</b> | <i role="button" data-id="' + data.id + '" class="click-remove-save bi bi-slash-circle" title="Hủy chọn"></i>' : ""}


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
                        data-name="${data.content}"
                        data-id="${data.id}"
                    >
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
                titleTable = `<h2> Danh sách câu hỏi chờ (${listSave.length}) <i role="button" class="click-hide-data-save bi bi-eye-fill fs-2x"></i></h2>`;
            if (flagDataSaveHide == true && index == 0)
                titleTable = `<h2> Danh sách câu hỏi chờ (${listSave.length}) <i role="button" class="click-hide-data-save bi bi-eye-slash-fill fs-2x"></i></h2>`;
            if (flagDataSaveHide == false)
                return `
                ${titleTable}
                <div class="p-1 m-1" style="background: #d7d7d7 ;border-radius: 10px ; position: relative   ;  padding-top: 15px !important;
                ">
                ${data.name}
                    <i style=" cursor: pointer;   right: 1vh; position: absolute; top: 50%; transform: translateY(-50%);" data-key="${index}" class="click-rm-list bi bi-x fs-2x"></i>
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
                `Danh sách các đề bài của bài làm <strong style="color:blue">${$(
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
            showListSave();
            getApiShowQues("http://127.0.0.1:8000/api/public/questions");
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
            getApiShowQues("http://127.0.0.1:8000/api/public/questions?");
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
            $(this).html(`<h2>Đang tải dữ liệu , vui lòng chờ ...</h2>`);
            var that = this;
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:8000/api/public/questions/save-question",
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
            });
        });
    },
    detachQuestion: function () {
        $(document).on("click", ".btn-dettach", function () {
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:8000/api/public/questions/dettach-question",
                data: {
                    exam_id: exam_id,
                    questions_id: $(this).data("id"),
                },
                success: function (response) {
                    if (!response.status) alert("Đã xảy ra lỗi ");
                    fecthQuestionByExams(exam_id);
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
            fecthQuestionByExams(exam_id, "", $(this).data("link"));
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
};

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
mainPage.blockF12();

$("#selectSkill").on("change", function () {
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?");
    skill = "&skill=" + value;
    getApiShowQues(urlApiPublic + "questions?" + skill + type + level + q);
});
$("#select-level").on("change", function () {
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?");
    skill = "&level=" + value;
    getApiShowQues(urlApiPublic + "questions?" + skill + type + level + q);
});
$("#select-type").on("change", function () {
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?");
    skill = "&type=" + value;
    getApiShowQues(urlApiPublic + "questions?" + skill + type + level + q);
});
$("#ip-search").on("keyup", function (e) {
    if (e.key !== "Enter") return;
    var value = $(this).val();
    if (value == -1) return getApiShowQues(urlApiPublic + "questions?");
    skill = "&q=" + value;
    getApiShowQues(urlApiPublic + "questions?" + skill + type + level + q);
});
/////
$("#selectSkillQs").on("change", function () {
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id);
    skill = "&skill=" + value;
    fecthQuestionByExams(exam_id, "?" + skill + type + level + q);
});
$("#select-levelQs").on("change", function () {
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id);
    skill = "&level=" + value;
    fecthQuestionByExams(exam_id, "?" + skill + type + level + q);
});
$("#select-typeQs").on("change", function () {
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id);
    skill = "&type=" + value;
    fecthQuestionByExams(exam_id, "?" + skill + type + level + q);
});
$("#ip-searchQs").on("keyup", function (e) {
    if (e.key !== "Enter") return;
    var value = $(this).val();
    if (value == -1) return fecthQuestionByExams(exam_id);
    skill = "&q=" + value;
    fecthQuestionByExams(exam_id, "?" + skill + type + level + q);
});
