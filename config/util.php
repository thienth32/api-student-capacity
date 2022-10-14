<?php
return [
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
    "EXCEL_QESTIONS" => [
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

    /** trạng thái doanh nghiệp không hiện thị tại trang chủ */
    "STATUS_ENTERPRISE_HIDDEN" => 0,
    /** trạng thái doanh nghiệp được hiện thị tại trang chủ */
    "STATUS_ENTERPRISE_SHOW" => 1,


    'TYPE_POSTS' => 0,
    'TYPE_RECRUITMENTS' => 1,
    'TYPE_CAPACITY_TEST' => 2,


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