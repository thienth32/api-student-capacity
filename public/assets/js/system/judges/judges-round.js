let arrUser = [];
$(".form-select-judges").on("change", function () {
    const user = JSON.parse($(this).val());
    const checkUserHasIsset = listUserIsset.filter(function (data) {
        return data.user.id == user.id;
    });
    const check = arrUser.filter(function (data) {
        return data.id == user.id;
    });
    if (checkUserHasIsset.length > 0 || check.length > 0) {
        return alert("Người này đã tồn tại ");
    }
    arrUser.push({
        ...user,
    });
    renderListUser();
});
function renderListUser() {
    let html = arrUser
        .map(function (data) {
            return `
            <li  data-id="${data.id}" class="list-group-item d-flex justify-content-between align-items-center">
                    ${data.name} - ${data.email}
                <span role="button" data-id="${data.id}" class="click-peo badge badge-danger badge-pill">Xóa người này </span>
            </li>
        `;
        })
        .join("");
    html += `
        <button class="btn-add-judges btn btn-primary">Thêm giám khảo </button>
    `;
    $(".show-us").html(html);
}
$(document).on("click", ".click-peo", function () {
    let id = $(this).data("id");
    arrUser = arrUser.filter(function (data) {
        return data.id !== id;
    });
    renderListUser();
});
$(document).on("click", ".btn-add-judges", function () {
    if (arrUser.length == 0) return alert("Không có người để thêm !");
    $.ajax({
        url: URL_ATTACH,
        method: "POST",
        data: { users: arrUser, _token: _token },
        success: function (data) {
            if (data.status) {
                location.reload();
                return false;
            } else {
                alert(data.payload);
            }
        },
    });
});
$(".deleteJudges").on("click", function () {
    $.ajax({
        url: URL_DETACH,
        method: "POST",
        data: {
            users: [$(this).data("key")],
            _token: _token,
        },
        success: function (data) {
            if (data.status) {
                location.reload();
                return false;
            } else {
                alert(data.payload);
            }
        },
    });
});
