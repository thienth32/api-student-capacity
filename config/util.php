<?php
return [
    'CAREER_FULLTIME_TYPE' => 1,
    'CAREER_PARTTIME_TYPE' => 0,
    'CAREER_FULL_PART_TYPE' => 2,

    'CAREER_TYPES' => [
        '0' => 'Part-time',
        '1' => 'Full-time',
        '2' => 'Online',
        '3' => 'Part-time + Full-time',
        '4' => 'Part-time + Online',
        '5' => 'Full-time + Online',
        '6' => 'Part-time + Full-time + Online',
    ],

    'PROVINCES' => [
        1 => 'Hà Nội',
        2 => 'TP Hồ Chí Minh',
        3 => 'Đà Nẵng',
        4 => 'Hải Phòng',
        5 => 'Cần Thơ',
        6 => 'An Giang',
        7 => 'Bà Rịa - Vũng Tàu',
        8 => 'Bắc Giang',
        9 => 'Bắc Kạn',
        10 => 'Bạc Liêu',
        11 => 'Bắc Ninh',
        12 => 'Bến Tre',
        13 => 'Bình Định',
        14 => 'Bình Dương',
        15 => 'Bình Phước',
        16 => 'Bình Thuận',
        17 => 'Cà Mau',
        18 => 'Cao Bằng',
        19 => 'Đắk Lắk',
        20 => 'Đắk Nông',
        21 => 'Điện Biên',
        22 => 'Đồng Nai',
        23 => 'Đồng Tháp',
        24 => 'Gia Lai',
        25 => 'Hà Giang',
        26 => 'Hà Nam',
        27 => 'Hà Tĩnh',
        28 => 'Hải Dương',
        29 => 'Hậu Giang',
        30 => 'Hòa Bình',
        31 => 'Hưng Yên',
        32 => 'Khánh Hòa',
        33 => 'Kiên Giang',
        34 => 'Kon Tum',
        35 => 'Lai Châu',
        36 => 'Lâm Đồng',
        37 => 'Lạng Sơn',
        38 => 'Lào Cai',
        39 => 'Long An',
        40 => 'Nam Định',
        41 => 'Nghệ An',
        42 => 'Ninh Bình',
        43 => 'Ninh Thuận',
        44 => 'Phú Thọ',
        45 => 'Phú Yên',
        46 => 'Quảng Bình',
        47 => 'Quảng Nam',
        48 => 'Quảng Ngãi',
        49 => 'Quảng Ninh',
        50 => 'Quảng Trị',
        51 => 'Sóc Trăng',
        52 => 'Sơn La',
        53 => 'Tây Ninh',
        54 => 'Thái Bình',
        55 => 'Thái Nguyên',
        56 => 'Thanh Hóa',
        57 => 'Huế',
        58 => 'Tiền Giang',
        59 => 'Trà Vinh',
        60 => 'Tuyên Quang',
        61 => 'Vĩnh Long',
        62 => 'Vĩnh Phúc',
        63 => 'Yên Bái',
    ],

    'FAQ' => [
        'RATING' => [
            'TYPE' => [
                'UPVOTE' => 1,
                'DOWNVOTE' => 0,
            ],
        ],
    ],
    'COMPANY_CONTACT' => [
        'STATUS' => [
            'NEW' => 0,
            'REPLIED' => 1,
        ]
    ],
 
    'EVENT' => [
        'PARTICIPANT' => [
            'ROLE' => [
                'USER' => 0,
                'MENTOR' => 1,
            ],
            'STATUS' => [
                'REVIEWING' => 0,
                'APPROVE' => 1,
                'REJECT' => 2,
            ],
        ],
    ],

    'SPONSOR_PRIORITY' => [
        'HOST' => 0, //BTC
        'PARTICIPANT' => 1, //tham gia thường
        'SILVER' => 2, //tài trợ bạc
        'GOLD' => 3, //tài trợ vàng
        'DIAMOND' => 4, //tài trợ kim cương
    ],

    'SERVICE' => [
        'REQUEST_STATUS' => [
            'IN_PROGRESS' => 0,
            'FINISH' => 1,
        ]
    ],

    'TAKE_EXAM_STATUS_CANCEL' => 0, //TRẠNG THÁI HỦY BÀI THI
    'TAKE_EXAM_STATUS_UNFINISHED' => 1, // TRẠNG THÁI CHƯA HOÀN THÀNH BÀI THI
    'TAKE_EXAM_STATUS_COMPLETE' => 2, // TRẠNG THái đã HOÀN THÀNH BÀI THI
    'ROUND_TEAM_STATUS_ANNOUNCED' => 1, // trạng thái đã công bố đội thitrong vòng thi
    'ROUND_TEAM_STATUS_NOT_ANNOUNCED' => 2, //trạng thái chưa công bố đội thi

    'ACTIVE_STATUS' => 1,
    'INACTIVE_STATUS' => 0,

    'HOMEPAGE_ITEM_AMOUNT' => 6,
    'HOMEPAGE_ITEM_TEAM' => 10,
    'DEFAULT_PAGE_SIZE' => 20,

    'SUPER_ADMIN_ROLE' => 1,
    'ADMIN_ROLE' => 2,
    'STUDENT_ROLE' => 3,
    'JUDGE_ROLE' => 4,
    'TEACHER_ROLE' => 5,
    'STAFF_ROLE' => 6,
    'MENTOR_ROLE' => 7,

    "CONTEST_STATUS_REGISTERING" => 0,
    "CONTEST_STATUS_GOING_ON" => 1,
    "CONTEST_STATUS_DONE" => 2,

    "ROLE_DELETE" => "super admin",
    "ROLE_ADMINS" => 'admin|super admin',

    "CONTEST_STATUS_2" => "Cuộc thi đã kết thúc",

    "END_EMAIL_FPT" => "@fpt.edu.vn",

    "MS_SV" => [
        "ph"
    ],

    "TYPE_CONTEST" => 0,
    "TYPE_TEST" => 1,

    "RANK_QUESTION_EASY" => 0,
    "RANK_QUESTION_MEDIUM" => 1,
    "RANK_QUESTION_DIFFICULT" => 2,

    "TYPE_TIMES" => [
        [
            "TYPE" => 0,
            "VALUE" => "Phút"
        ],
        [
            "TYPE" => 1,
            "VALUE" => "Giờ"
        ],
        [
            "TYPE" => 2,
            "VALUE" => "Ngày "
        ],
    ],
    "TYPE_TIME_P" => 0,
    "TYPE_TIME_H" => 1,
    "TYPE_TIME_D" => 2,


    "STATUS_RESULT_CAPACITY_DOING" => 0,
    "STATUS_RESULT_CAPACITY_DONE" => 1,
    "ANSWER_FALSE" => 0,
    "ANSWER_TRUE" => 1,

    "NAME_DOCKER" => "capacity_",
    "EXCEL_QUESTIONS" => [
        "TYPE" => "Một đáp án",
        "RANKS" => [
            "Dễ",
            "Trung bình",
            "Khó",
        ],
        "KEY_COLUMNS" => [
            "TYPE" => 0,
            "QUESTION" => 1,
            "ANSWER" => 2,
            "IS_CORRECT" => 3,
            "RANK" => 4,
            "SKILL" => 5
        ],
        "IS_CORRECT" => "Đáp án đúng"
    ],
    "post-contest" => "post-contest",
    "post-capacity" => "post-capacity",
    "post-round" => "post-round",
    "post-recruitment" => "post-recruitment",
    /**bÀI VIẾT TUYỂN DỤNG HOT */
    "POST_HOT" => 1,
    /** bÀI VIẾT TUYỂN DỤNG THƯỜNG  */
    "POST_NORMAL" => 0,

    "POST_NOT_FULL_RECRUITMENT" => 0, //đang tuyển
    "POST_FULL_RECRUITMENT" => 1, //đã tuyển đủ (ngừng tuyển)

    /** trạng thái doanh nghiệp không hiện thị tại trang chủ */
    "STATUS_ENTERPRISE_HIDDEN" => 0,
    /** trạng thái doanh nghiệp được hiện thị tại trang chủ */
    "STATUS_ENTERPRISE_SHOW" => 1,


    'TYPE_POSTS' => 0,
    'TYPE_RECRUITMENTS' => 1,
    'TYPE_CAPACITY_TEST' => 2,

    "CANDIDATE_OPTIONS" => [
        "STATUS_KEYS" => [
            "EDIT_CV" => 0,
            "SEND_TO_ENTERPRISE" => 1,
            "CANDIDATE_NOT_RESEND_CV" => 2,
            "NOT_SUPPORT" => 3,
            "CV_MEET_REQUIREMENT" => 4,
        ],
        "STUDENT_STATUS_KEYS" => [
            "STUDYING" => 0,
            "GRADUATED" => 1,
        ],
        "STATUSES" => [
            "0" => "Sửa CV",
            "1" => "Đã gửi sang DN",
            "2" => "Ứng viên không gửi lại CV",
            "3" => "Không thuộc đối tượng hỗ trợ",
            "4" => "CV đạt yêu cầu",
        ],
        "STUDENT_STATUSES" => [
            "0" => "Đang học",
            "1" => "Đã tốt nghiệp",
        ],
        "RESULTS" => [
            "fail" => "Fail",
            "pass" => "Pass",
            "to_another_recruitment" => "Chuyển sang mã TD khác",
            "full" => "DN đã tuyển đủ",
        ],
    ],


    'CHALLENEGE' => [
        "php" => [
            "INOPEN" => "
                <?php
                function FC(INPUT)
                {
                };
            ",
            "OUTPEN" => '
                $result =  FC(INPUT);
                if(is_array($result))
                {
                    foreach($result  as $r)
                    {
                        echo $r;
                    }
                }else{
                    echo $result;
                }
            ',
            "TEST_CASE" => "
                INOPEN
                OUTPEN
            "
        ],
        "js" => [
            "INOPEN" => "
                function FC(INPUT)
                {};
            ",
            "OUTPEN" => '
                var result =  FC(INPUT);
                if(Array.isArray(result))
                {

                    for(var i = 0 ; i < result.length ; i ++ )
                    {
                        console.log(result[i]);
                    }

                }else{
                    console.log(result);
                }
            ',
            "TEST_CASE" => "
                INOPEN
                OUTPEN
            "
        ],
        // "c" => [
        //     "INOPEN" => '
        //         #include <stdio.h>
        //         void FC(INPUT) {
        //         }
        //     ',
        //     "OUTPEN" => '
        //     ',
        //     "TEST_CASE" => "
        //     "
        // ],
        // 'cpp' => [
        //     "INOPEN" => '',
        //     "OUTPEN" => '
        //     ',
        //     "TEST_CASE" => "
        //     "
        // ],
        'py' => [
            "INOPEN" => '
                def FC(INPUT):
            ',
            "OUTPEN" => '
result = FC(INPUT);
if isinstance(result,list):
    for x in result:
        print(x + " ")
else:
    print(result)
            ',
            "TEST_CASE" => "
INOPEN
OUTPEN
            "
        ],
        // 'java' => [
        //     "INOPEN" => '',
        //     "OUTPEN" => '
        //     ',
        //     "TEST_CASE" => "
        //     "
        // ]
    ]
];
