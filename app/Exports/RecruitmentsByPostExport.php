<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;

class RecruitmentsByPostExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ToModel
{
    use RemembersRowNumber;
    private $row = 0;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Post::all();
    }

    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();

        return new Post([
            'row_number' => ++$this->row,
        ]);
    }

    public function title(): string
    {
        return 'DS Tin TD';
    }

    public function headings(): array
    {
        return [
            'STT',
            'THÁNG',
            'Ngày cập nhật',
            'Mã tuyển dụng',
            'Tên nhà tuyển dụng',
            'Địa chỉ',
            'Người liên hệ',
            'Thông tin liên hệ',
            'Email',
            'Ngành',
            'Vị trí cầu tuyển dụng',
            'Số lượng cần tuyển',
            'Thời hạn tuyển dụng',
            'Loại hình công việc',
            'Nguồn',
            'Y/c Kinh nghiệm',
            'Note',
            'Phụ trách',
        ];
    }

    public function map($post): array
    {

        return [
            $post->row_number,
            date("m", strtotime($post->created_at)),
            $post->updated_at,
            $post->code_recruitment,
            $post->enterprise->name ?? '',
            $post->enterprise->address ?? '',
            $post->contact_name,
            $post->contact_phone,
            $post->contact_email,
            $post->major->name ?? '',
            $post->position,
            $post->total,
            $post->deadline,
            $post->career_type,
            $post->career_source,
            $post->career_require,
            '',
            $post->user->name ?? ''
        ];
    }
}
