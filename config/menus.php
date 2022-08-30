<?php
$ROLE_HAS_ADMINS = 'admin|super admin';
$ROLE_JUDGE = 'admin|super admin|judge';
$TYPE_CAPACITY = 1;
return [
    [
        "icon" => '<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Star.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <polygon points="0 0 24 0 24 24 0 24"/>
            <path d="M12,18 L7.91561963,20.1472858 C7.42677504,20.4042866 6.82214789,20.2163401 6.56514708,19.7274955 C6.46280801,19.5328351 6.42749334,19.309867 6.46467018,19.0931094 L7.24471742,14.545085 L3.94038429,11.3241562 C3.54490071,10.938655 3.5368084,10.3055417 3.92230962,9.91005817 C4.07581822,9.75257453 4.27696063,9.65008735 4.49459766,9.61846284 L9.06107374,8.95491503 L11.1032639,4.81698575 C11.3476862,4.32173209 11.9473121,4.11839309 12.4425657,4.36281539 C12.6397783,4.46014562 12.7994058,4.61977315 12.8967361,4.81698575 L14.9389263,8.95491503 L19.5054023,9.61846284 C20.0519472,9.69788046 20.4306287,10.2053233 20.351211,10.7518682 C20.3195865,10.9695052 20.2170993,11.1706476 20.0596157,11.3241562 L16.7552826,14.545085 L17.5353298,19.0931094 C17.6286908,19.6374458 17.263103,20.1544017 16.7187666,20.2477627 C16.5020089,20.2849396 16.2790408,20.2496249 16.0843804,20.1472858 L12,18 Z" fill="#000000"/>
        </g>
    </svg><!--end::Svg Icon--></span>',
        "name" => "Cuộc thi",
        "role" => $ROLE_JUDGE,
        "link" => "admin.contest.list",
        "param" => ""
    ], // Cuoc thi
    [
        "icon" => '<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Shield-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="24"/>
            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
            <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"/>
            <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"/>
        </g>
    </svg><!--end::Svg Icon--></span>',
        "name" => "Đội thi",
        "role" => $ROLE_HAS_ADMINS,
        "param" => '',
        "link" => "admin.teams",
    ], // Doi thi
    [
        "icon" => '<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/File.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <polygon points="0 0 24 0 24 24 0 24"/>
            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
            <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
            <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
        </g>
    </svg><!--end::Svg Icon--></span>',
        "name" => "Bài viết",
        "role" => $ROLE_HAS_ADMINS,
        "param" => '',
        "link" => "admin.post.list",
    ], // Bai viet
    [
        "icon" => '<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="24"/>
            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
        </g>
    </svg><!--end::Svg Icon--></span>',
        "name" => "Tuyển dụng",
        "role" => $ROLE_HAS_ADMINS,
        "param" => '',
        "link" => "admin.recruitment.list",
    ], // Tuyen dung
    [
        "icon" => '<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Building.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="24"/>
            <path d="M13.5,21 L13.5,18 C13.5,17.4477153 13.0522847,17 12.5,17 L11.5,17 C10.9477153,17 10.5,17.4477153 10.5,18 L10.5,21 L5,21 L5,4 C5,2.8954305 5.8954305,2 7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,21 L13.5,21 Z M9,4 C8.44771525,4 8,4.44771525 8,5 L8,6 C8,6.55228475 8.44771525,7 9,7 L10,7 C10.5522847,7 11,6.55228475 11,6 L11,5 C11,4.44771525 10.5522847,4 10,4 L9,4 Z M14,4 C13.4477153,4 13,4.44771525 13,5 L13,6 C13,6.55228475 13.4477153,7 14,7 L15,7 C15.5522847,7 16,6.55228475 16,6 L16,5 C16,4.44771525 15.5522847,4 15,4 L14,4 Z M9,8 C8.44771525,8 8,8.44771525 8,9 L8,10 C8,10.5522847 8.44771525,11 9,11 L10,11 C10.5522847,11 11,10.5522847 11,10 L11,9 C11,8.44771525 10.5522847,8 10,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 L8,14 C8,14.5522847 8.44771525,15 9,15 L10,15 C10.5522847,15 11,14.5522847 11,14 L11,13 C11,12.4477153 10.5522847,12 10,12 L9,12 Z M14,12 C13.4477153,12 13,12.4477153 13,13 L13,14 C13,14.5522847 13.4477153,15 14,15 L15,15 C15.5522847,15 16,14.5522847 16,14 L16,13 C16,12.4477153 15.5522847,12 15,12 L14,12 Z" fill="#000000"/>
            <rect fill="#FFFFFF" x="13" y="8" width="3" height="3" rx="1"/>
            <path d="M4,21 L20,21 C20.5522847,21 21,21.4477153 21,22 L21,22.4 C21,22.7313708 20.7313708,23 20.4,23 L3.6,23 C3.26862915,23 3,22.7313708 3,22.4 L3,22 C3,21.4477153 3.44771525,21 4,21 Z" fill="#000000" opacity="0.3"/>
        </g>
    </svg><!--end::Svg Icon--></span>',
        "name" => "Doanh nghiệp",
        "param" => '',
        "link" => "admin.enterprise.list",
        "role" => $ROLE_HAS_ADMINS,
    ], // Doanh nghiep
    [
        "icon" => '
        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
        <span class="svg-icon svg-icon-primary svg-icon-2x">
            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24" />
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
                        r="10" />
                    <path
                        d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
                        fill="#000000" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
        <!--end::Svg Icon-->
        ',
        "name" => "Đánh giá năng lực",
        "role" => $ROLE_HAS_ADMINS,
        "subs-menu" => [
            [
                "name" => "Bài đánh giá",
                "param" => '?type=' . $TYPE_CAPACITY,
                "link" => "admin.contest.list",
                "role" => $ROLE_HAS_ADMINS
            ],
            [
                "name" => "Bộ câu hỏi ",
                "param" => '',
                "link" => "admin.question.index",
                "role" => $ROLE_HAS_ADMINS
            ],
        ]
    ], // Test nang luc
    [
        "icon" => '
        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Settings-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
        ',
        "name" => "Cấu hình",
        "role" => $ROLE_HAS_ADMINS,
        "subs-menu" => [
            [
                "name" => "Chuyên ngành",
                "role" => $ROLE_HAS_ADMINS,
                "param" => '',
                "link" => "admin.major.list",
            ],
            [
                "name" => "Kỹ năng",
                "role" => $ROLE_HAS_ADMINS,
                "param" => '',
                "link" => "admin.skill.index",
            ],
            [
                "name" => "Hình ảnh (slider)",
                "param" => '',
                "link" => "admin.sliders.list",
                "role" => $ROLE_HAS_ADMINS,
            ],
            [
                "name" => "Tài khoản",
                "role" => $ROLE_HAS_ADMINS,
                "param" => '',
                "link" => "admin.acount.list",
            ],
        ]
    ], // Cau hinh
];
// <?php
// $ROLE_HAS_ADMINS = 'admin|super admin';
// $ROLE_JUDGE = 'admin|super admin|judge';
// $TYPE_CAPACITY = 1;
// return [
//     [
//         "icon" => '
//                     <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//                     <span class="svg-icon svg-icon-primary svg-icon-2x">
//                         <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Layout/Layout-grid.svg--><svg
//                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                             width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                                 <rect x="0" y="0" width="24" height="24" />
//                                 <rect fill="#000000" opacity="0.3" x="4" y="4" width="4"
//                                     height="4" rx="1" />
//                                 <path
//                                     d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z"
//                                     fill="#000000" />
//                             </g>
//                         </svg>
//                         <!--end::Svg Icon-->
//                     </span>
//                     <!--end::Svg Icon-->',
//         "name" => "Quản lý cuộc thi",
//         "role" => $ROLE_JUDGE,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách cuộc thi ",
//                 "link" => "admin.contest.list",
//                 "param" => "",
//                 "role" => $ROLE_JUDGE
//             ],
//             [
//                 "name" => "Thêm mới cuộc thi",
//                 "link" => "admin.contest.create",
//                 "param" => "",
//                 "role" => $ROLE_HAS_ADMINS,
//             ]
//         ]
//     ], // Cuoc thi
//     [
//         "icon" => '
//             <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//                 <span class="svg-icon svg-icon-primary svg-icon-2x">
//                     <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Layout/Layout-grid.svg--><svg
//                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                         <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                             <rect x="0" y="0" width="24" height="24" />
//                             <rect fill="#000000" opacity="0.3" x="4" y="4" width="4"
//                                 height="4" rx="1" />
//                             <path
//                                 d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z"
//                                 fill="#000000" />
//                         </g>
//                     </svg>
//                     <!--end::Svg Icon-->
//                 </span>
//                 <!--end::Svg Icon-->
//         ',
//         "name" => "Quản lý test năng lực",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách test năng lực ",
//                 "param" => '?type=' . $TYPE_CAPACITY,
//                 "link" => "admin.contest.list",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới test năng lực",
//                 "link" => "admin.contest.create",
//                 "param" => '?type=' . $TYPE_CAPACITY,
//                 "role" => $ROLE_HAS_ADMINS,
//             ]
//         ]
//     ], // Test nang luc
//     [
//         "icon" => '
//            <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//                             <span class="svg-icon svg-icon-2 svg-icon-2x">
//                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
//                                     viewBox="0 0 24 24" fill="none">
//                                     <path
//                                         d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
//                                         fill="black" />
//                                     <rect opacity="0.3" x="8" y="3" width="8" height="8"
//                                         rx="4" fill="black" />
//                                 </svg>
//                             </span>
//                             <!--end::Sv
//                             g Icon-->
//         ',
//         "name" => "Quản lý tài khoản",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Tổng quan",
//                 "param" => '',
//                 "link" => "admin.acount.list",
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Tai khoan
//     [
//         "icon" => '
//             <span class="svg-icon svg-icon-primary svg-icon-2x">
//                                 <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/CMD.svg--><svg
//                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                                         <rect x="0" y="0" width="24" height="24" />
//                                         <path
//                                             d="M9,15 L7.5,15 C6.67157288,15 6,15.6715729 6,16.5 C6,17.3284271 6.67157288,18 7.5,18 C8.32842712,18 9,17.3284271 9,16.5 L9,15 Z M9,15 L9,9 L15,9 L15,15 L9,15 Z M15,16.5 C15,17.3284271 15.6715729,18 16.5,18 C17.3284271,18 18,17.3284271 18,16.5 C18,15.6715729 17.3284271,15 16.5,15 L15,15 L15,16.5 Z M16.5,9 C17.3284271,9 18,8.32842712 18,7.5 C18,6.67157288 17.3284271,6 16.5,6 C15.6715729,6 15,6.67157288 15,7.5 L15,9 L16.5,9 Z M9,7.5 C9,6.67157288 8.32842712,6 7.5,6 C6.67157288,6 6,6.67157288 6,7.5 C6,8.32842712 6.67157288,9 7.5,9 L9,9 L9,7.5 Z M11,13 L13,13 L13,11 L11,11 L11,13 Z M13,11 L13,7.5 C13,5.56700338 14.5670034,4 16.5,4 C18.4329966,4 20,5.56700338 20,7.5 C20,9.43299662 18.4329966,11 16.5,11 L13,11 Z M16.5,13 C18.4329966,13 20,14.5670034 20,16.5 C20,18.4329966 18.4329966,20 16.5,20 C14.5670034,20 13,18.4329966 13,16.5 L13,13 L16.5,13 Z M11,16.5 C11,18.4329966 9.43299662,20 7.5,20 C5.56700338,20 4,18.4329966 4,16.5 C4,14.5670034 5.56700338,13 7.5,13 L11,13 L11,16.5 Z M7.5,11 C5.56700338,11 4,9.43299662 4,7.5 C4,5.56700338 5.56700338,4 7.5,4 C9.43299662,4 11,5.56700338 11,7.5 L11,11 L7.5,11 Z"
//                                             fill="#000000" fill-rule="nonzero" />
//                                     </g>
//                                 </svg>
//                                 <!--end::Svg Icon-->
//                             </span>
//         ',
//         "name" => "Quản lí đội thi",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách đội thi",
//                 "param" => '',
//                 "link" => "admin.teams",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới đội thi",
//                 "link" => "admin.teams.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Doi thi
//     [
//         "icon" => '
//            <span class="svg-icon svg-icon-primary svg-icon-2x">
//                                 <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Layout/Layout-arrange.svg--><svg
//                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                                         <rect x="0" y="0" width="24" height="24" />
//                                         <path
//                                             d="M5.5,4 L9.5,4 C10.3284271,4 11,4.67157288 11,5.5 L11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L5.5,8 C4.67157288,8 4,7.32842712 4,6.5 L4,5.5 C4,4.67157288 4.67157288,4 5.5,4 Z M14.5,16 L18.5,16 C19.3284271,16 20,16.6715729 20,17.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,17.5 C13,16.6715729 13.6715729,16 14.5,16 Z"
//                                             fill="#000000" />
//                                         <path
//                                             d="M5.5,10 L9.5,10 C10.3284271,10 11,10.6715729 11,11.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,12.5 C20,13.3284271 19.3284271,14 18.5,14 L14.5,14 C13.6715729,14 13,13.3284271 13,12.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z"
//                                             fill="#000000" opacity="0.3" />
//                                     </g>
//                                 </svg>
//                                 <!--end::Svg Icon-->
//                             </span>
//         ',
//         "name" => "Quản lý doanh nghiệp",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách doanh nghiệp",
//                 "param" => '',
//                 "link" => "admin.enterprise.list",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới doanh nghiệp",
//                 "link" => "admin.enterprise.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Doanh nghiep
//     [
//         "icon" => '
//             <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//                             <span class="svg-icon svg-icon-primary svg-icon-2x">
//                                 <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Devices/Cardboard-vr.svg--><svg
//                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                                         <rect x="0" y="0" width="24" height="24" />
//                                         <polygon fill="#000000" opacity="0.3" points="6 4 18 4 20 6.5 4 6.5" />
//                                         <path
//                                             d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L20.999994,17.0000172 C20.999994,18.1045834 20.1045662,19.0000112 19,19.0000112 C17.4805018,19.0000037 16.4805051,19 16,19 C15,19 14.5,17 12,17 C9.5,17 9.5,19 8,19 C7.31386312,19 6.31387037,19.0000034 5.00002173,19.0000102 L5.00002173,19.0000216 C3.89544593,19.0000273 3.00000569,18.1045963 3,17.0000205 C3,17.000017 3,17.0000136 3,17.0000102 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M8,14 C9.1045695,14 10,13.1045695 10,12 C10,10.8954305 9.1045695,10 8,10 C6.8954305,10 6,10.8954305 6,12 C6,13.1045695 6.8954305,14 8,14 Z M16,14 C17.1045695,14 18,13.1045695 18,12 C18,10.8954305 17.1045695,10 16,10 C14.8954305,10 14,10.8954305 14,12 C14,13.1045695 14.8954305,14 16,14 Z"
//                                             fill="#000000" />
//                                     </g>
//                                 </svg>
//                                 <!--end::Svg Icon-->
//                             </span>
//                             <!--end::Svg Icon-->
//         ',
//         "name" => "Quản lý chuyên ngành",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách chuyên ngành ",
//                 "param" => '',
//                 "link" => "admin.major.list",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới chuyên ngành ",
//                 "link" => "admin.major.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Chuyen nganh
//     [
//         "icon" => '
//             <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//                             <span class="svg-icon svg-icon-primary svg-icon-2x">
//                                 <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Layout/Layout-polygon.svg--><svg
//                                     xmlns="http://www.w3.org/2000/svg" width="70px" height="70px" viewBox="0 0 70 70"
//                                     fill="none">
//                                     <g stroke="none" stroke-width="1" fill-rule="evenodd">
//                                         <path
//                                             d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911  49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z"
//                                             fill="#000000" />
//                                     </g>
//                                 </svg>
//                                 <!--end::Svg Icon-->
//                             </span>
//                             <!--end::Svg Icon-->
//         ',
//         "name" => "Quản lý kỹ năng",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách kỹ năng ",
//                 "param" => '',
//                 "link" => "admin.skill.index",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới kỹ năng ",
//                 "link" => "admin.skill.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Ki nang
//     [
//         "icon" => '
//            <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//                             <span class="svg-icon svg-icon-primary svg-icon-2x">
//                                 <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Image.svg--><svg
//                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                                         <polygon points="0 0 24 0 24 24 0 24" />
//                                         <path
//                                             d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z"
//                                             fill="#000000" />
//                                     </g>
//                                 </svg>
//                                 <!--end::Svg Icon-->
//                             </span>
//                             <!--end::Svg Icon-->
//         ',
//         "name" => "Quản lý slider",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách slider ",
//                 "param" => '',
//                 "link" => "admin.sliders.list",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới slider",
//                 "link" => "admin.sliders.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Slider
//     [
//         "icon" => '
//          <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//                             <span class="svg-icon svg-icon-primary svg-icon-2x">
//                                 <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg
//                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                                         <rect x="0" y="0" width="24" height="24" />
//                                         <circle fill="#000000" opacity="0.3" cx="12" cy="12"
//                                             r="10" />
//                                         <path
//                                             d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
//                                             fill="#000000" />
//                                     </g>
//                                 </svg>
//                                 <!--end::Svg Icon-->
//                             </span>
//                             <!--end::Svg Icon-->
//         ',
//         "name" => "Quản lý bộ câu hỏi",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách bộ câu hỏi ",
//                 "param" => '',
//                 "link" => "admin.question.index",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới bộ câu hỏi",
//                 "link" => "admin.question.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Cau hoi
//     [
//         "icon" => '
//         <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Communication/Add-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//         <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//             <polygon points="0 0 24 0 24 24 0 24"/>
//             <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
//             <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
//         </g>
//     </svg><!--end::Svg Icon--></span>
//         ',
//         "name" => "Quản lý tuyển dụng",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách tuyển dụng ",
//                 "param" => '',
//                 "link" => "admin.recruitment.list",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới tuyển dụng",
//                 "link" => "admin.recruitment.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Tuyen dung
//     [
//         "icon" => '
//         <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Communication/Clipboard-list.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//         <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//             <rect x="0" y="0" width="24" height="24"/>
//             <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
//             <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
//             <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"/>
//             <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"/>
//             <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"/>
//             <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"/>
//             <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"/>
//             <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"/>
//         </g>
//         </svg><!--end::Svg Icon--></span>
//         ',
//         "name" => "Quản lý bài viết",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             [
//                 "name" => "Danh sách bài viết ",
//                 "param" => '',
//                 "link" => "admin.post.list",
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới bài viết",
//                 "link" => "admin.post.create",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ],
//             [
//                 "name" => "Thêm mới bài viết bên ngoài trang",
//                 "link" => "admin.post.insert",
//                 "param" => '',
//                 "role" => $ROLE_HAS_ADMINS
//             ]
//         ]
//     ], // Bai viet
//     [
//         "icon" => '
//             <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Sketch.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                     <rect x="0" y="0" width="24" height="24"/>
//                     <polygon fill="#000000" opacity="0.3" points="5 3 19 3 23 8 1 8"/>
//                     <polygon fill="#000000" points="23 8 12 20 1 8"/>
//                 </g>
//             </svg><!--end::Svg Icon--></span>
//         ',
//         "name" => "Quản lý ngôn ngữ ",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             // [
//             //     "name" => "Danh sách bài viết ",
//             //     "param" => '',
//             //     "link" => "admin.post.list",
//             //     "role" => $ROLE_HAS_ADMINS
//             // ],
//         ]
//     ], // Ngon ngữ
//     [
//         "icon" => '
//            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Commode1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                     <rect x="0" y="0" width="24" height="24"/>
//                     <path d="M5.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L5.5,11 C4.67157288,11 4,10.3284271 4,9.5 L4,5.5 C4,4.67157288 4.67157288,4 5.5,4 Z M11,6 C10.4477153,6 10,6.44771525 10,7 C10,7.55228475 10.4477153,8 11,8 L13,8 C13.5522847,8 14,7.55228475 14,7 C14,6.44771525 13.5522847,6 13,6 L11,6 Z" fill="#000000" opacity="0.3"/>
//                     <path d="M5.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M11,15 C10.4477153,15 10,15.4477153 10,16 C10,16.5522847 10.4477153,17 11,17 L13,17 C13.5522847,17 14,16.5522847 14,16 C14,15.4477153 13.5522847,15 13,15 L11,15 Z" fill="#000000"/>
//                 </g>
//             </svg><!--end::Svg Icon--></span>
//         ',
//         "name" => "Quản lý bài thi code online  ",
//         "role" => $ROLE_HAS_ADMINS,
//         "subs-menu" => [
//             // [
//             //     "name" => "Danh sách bài viết ",
//             //     "param" => '',
//             //     "link" => "admin.post.list",
//             //     "role" => $ROLE_HAS_ADMINS
//             // ],
//         ]
//     ], // Bai viet
// ];