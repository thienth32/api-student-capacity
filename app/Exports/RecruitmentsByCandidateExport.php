<?php

namespace App\Exports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;

class RecruitmentsByCandidateExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ToModel
{
    use RemembersRowNumber;

    private $row = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Candidate::all();
    }

    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();

        return new Candidate([
            'row_number' => $currentRowNumber,
        ]);
    }
    public function title(): string
    {
        return 'DS SV ứng tuyển';
    }

    public function headings(): array
    {
        return [
            'STT',
            'Mã TD',
            'Ngày tiếp nhận hồ sơ',
            'Tháng',
            'MSSV',
            'Họ tên',
            'Email',
            'Số điện thoại',
            'Ngành học',
            'Vị trí ứng tuyển',
            'Nơi ứng tuyển',
            'Tình trạng',
            'Ghi chú',
            'Kết quả',
            'Ghi chú',
            'Phụ trách',
        ];
    }

    public function map($data): array
    {
        return [
            $data->row_number,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];
    }
}
