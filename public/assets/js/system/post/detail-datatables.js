const statusCol = 4;
const resultCol = 5;
const table = $('#myTable').DataTable({
    select: {
        style: 'multi',
    },
    columnDefs: [
        {
            targets: [statusCol, resultCol],
            width: "30%"
        }
    ],
    paging: false, // Tắt tính năng phân trang
    language: {
        select: {
            rows: {
                _: "%d dòng đã chọn",
                0: "",
                1: "1 dòng đã chọn"
            }
        },

        "zeroRecords": "Không tìm thấy kết quả",
        "infoFiltered": "(được lọc từ _MAX_ dữ liệu)",
        "rows": {
            "1": "1 dòng đang được chọn",
            "_": "%d dòng đang được chọn"
        },

        "info": "Hiển thị _START_ tới _END_ của _TOTAL_ dữ liệu",
        "infoEmpty": "Hiển thị 0 tới 0 của 0 dữ liệu",
        "lengthMenu": "Hiển thị _MENU_ dữ liệu",
    },
});

// Cập nhật trạng thái ô checkbox selectAll
function updateSelectAllCheckbox() {
    var allCheckboxes = $('input[type="checkbox"][name=candidate_ids]');
    var selectedCheckboxes = $('input[type="checkbox"][name=candidate_ids]:checked');
    $('#selectAll').prop('checked', allCheckboxes.length === selectedCheckboxes.length);
    var anyChecked = $('input[name="candidate_ids"]:checked').length > 0;
    $('#collectDataButton').prop('disabled', !anyChecked);
}

// Sự kiện khi chọn/deselect ô checkbox
$('input[type="checkbox"][name=candidate_ids]').on('change', function () {
    updateSelectAllCheckbox();
});

// Sự kiện khi chọn/deselect tất cả
$('#selectAll').on('change', function () {
    var isChecked = $(this).is(':checked');
    $('input[type="checkbox"][name=candidate_ids]').prop('checked', isChecked);
    if (isChecked) {
        table.rows().select();
    } else {
        table.rows().deselect();
    }
    // table.rows().select();
});

// Sự kiện khi chọn/deselect dòng
table.on('select deselect', function () {
    updateSelectAllCheckbox();
});

// Đặt sự kiện select để checked/unchecked ô input checkbox
table.on('select', function (e, dt, type, indexes) {
    var rows = table.rows(indexes).nodes();
    $(rows).find('input[type="checkbox"]').prop('checked', true);
    updateSelectAllCheckbox();

});

table.on('deselect', function (e, dt, type, indexes) {
    var rows = table.rows(indexes).nodes();
    $(rows).find('input[type="checkbox"]').prop('checked', false);
    updateSelectAllCheckbox();
});

$('#applyFiltersButton').on('click', function () {
    var statusFilterValue = $('#statusFilter').val();
    var resultFilterValue = $('#resultFilter').val();

    table.column(statusCol).search(statusFilterValue).draw();
    table.column(resultCol).search(resultFilterValue).draw();
});

