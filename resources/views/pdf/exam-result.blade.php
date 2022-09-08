 <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
     <thead>
         <tr>
             <th>Sinh viên</th>
             <th>Mail</th>
             <th>So diem</th>
             <th>Trang thai</th>
             <th>Chon sai</th>
             <th>Chon dung</th>
         </tr>
     </thead>
     <tbody id="show-result-exam">
         @foreach ($data as $v)
             <tr>
                 <td>{{ $v->user->name }}</td>
                 <td>{{ $v->user->email }}</td>
                 <td>{{ $v->scores }}</td>
                 <td>{{ $v->status == 1 ? 'Đã nộp' : 'Chưa nộp ' }}
                 </td>
                 <td>{{ $v->false_answer }}</td>
                 <td>{{ $v->true_answer }}</td>
             </tr>
         @endforeach
     </tbody>
 </table>
