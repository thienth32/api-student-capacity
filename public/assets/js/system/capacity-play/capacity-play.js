const capacity_play = {
    copytext: function() {
        $(document).on("click", "button.copy_to", function(e) {
            e.preventDefault();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).text()).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success("Copied!");
        });
    },
    selcetSkills: function() {

        var questionArray = [];
        function loadConten(data) {
            var _html = ``;
            _html += /*html*/ `<div class="list-group" >`
            data.forEach(key => {
                _html += /*html*/ `
                    <div data-id="${key.id}" class="add-question list-group-item list-group-item-action flex-column align-items-start p-5 cursor-pointer">
                        <div class="a d-flex w-100 justify-content-between">
                            <h5 class="mb-1">${key.content}</h5>
                        </div>
                        <div class="b d-flex lign-items-start mb-1 user-select-none">
                            <div class="badge bg-warning text-dark w-100px me-3">
                                ${key.rank == 0 ? "Dễ" : key.rank == 1 ? "Trung bình ": key.rank == 2 ? "Khó": "No "}
                            </div>
                            <div class="badge bg-danger text-white w-100px">
                                ${key.type == 0 ?  'Một đáp án' :key.type == 1? 'Nhiều đáp án':'No'}        
                            </div>
                        </div>
                    </div>
                `
            });
            _html += /*html*/ `</div> `
            $('#result-question').html(_html);
        }

        function loadQuestionArr(flag= true, data , data_id , classTotal , eleAppend) {
          
            if (flag) {
               var deleteEl =  /*html*/`
                 <div class="c d-flex justify-content-end">
                        <button data-id="${data_id}" type="button" class="delete_question badge bg-danger">Xóa</button>
                        <input hidden type="text" value="${data_id}" name="questions[]">
                    </div>
                `     
            } else {
                var deleteEl =  /*html*/`    `     
            }
            if (flag) {

                var _html = /*html*/`
                    <div class="list-group" >
                        <div data-id="${data_id}" class="${classTotal} list-group-item list-group-item-action flex-column align-items-start p-5 ">
                                ${data}
                            ${deleteEl}
                        </div>
                    </div>
                `
            } else {
                var _html = /*html*/`
            
                    <div data-id="${data_id}" class="${classTotal} list-group-item list-group-item-action flex-column align-items-start p-5 ">
                            ${data}
                        ${deleteEl}
                    </div>
                   
                `
            }

           return $(eleAppend).append(_html);
        }
        $(document).on('change', 'select.skill-select', function(e) {
            e.preventDefault();
         
                let valueSkill = $(this).val();
                if (valueSkill == 'null') {
                    questionArray = [];
                    $('#result-question-array').empty();
                    $('#result-question').empty();
                    return;
                } else {     
                $(".parent-loading #loading").css({ "display": "block" });
                $.ajax({
                    type: "get",
                    url: skillQuestionRoute,
                    data: {
                        _token: _token,
                        skill_id: valueSkill
                    },
                    success: function(res) {
                        if (res.status) {
                            console.log(res.payload);
                            $(".parent-loading #loading").css("display", "none");
                            return loadConten(res.payload);
                        }
                    }
                });
            }
        });

        $(document).on( 'click', '.add-question', function (e) { 
            e.preventDefault();
           var id=  $(this).attr('data-id');
            var check=   questionArray.filter(function (key) {
                return key == id;
            })
            if (check.length > 0) {
                toastr.warning('Câu hỏi đã được thêm !')
            } else {
                questionArray.push(id);
               $(this).remove(); 
                loadQuestionArr(true,  $(this).html(), id ,'question_arr','#result-question-array' )
                toastr.success('Thêm câu hỏi thành công !')
            }
        });
        $(document).on('click', 'button.delete_question', function (e) { 
            e.preventDefault();
            let key = $(this).attr('data-id');
            // questionArray.splice(key, 1)
            while (questionArray.indexOf(key) !== -1) {
                questionArray.splice(questionArray.indexOf(key), 1);
            }
              loadQuestionArr(false,  $('div.question_arr[data-id="'+key+'"]').html(), key ,'add-question cursor-pointer','#result-question .list-group' )
            $('div.question_arr[data-id="'+key+'"]').remove();
            $('#result-question div.add-question[data-id="'+key+'"] div.c').remove();
            toastr.success('Xóa thành công !')
        });

    }
};

capacity_play.copytext();
capacity_play.selcetSkills();