<?php

namespace App\Exports;

use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;
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
            'Link CV',
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
            !empty($data->post->code_recruitment) ? $data->post->code_recruitment : '',
            'Ngày ' . date('d', strtotime($data->created_at)),
            'Tháng ' . date('m', strtotime($data->created_at)),
            $data->student_code,
            $data->name,
            $data->email,
            $data->phone,
            !empty($data->major->name) ? $data->major->name : '',
            Storage::disk('s3')->temporaryUrl($data->file_link, now()->addDay(7)),
            !empty($data->post->position) ? $data->post->position : '',
            !empty($data->post->enterprise->address) ? $data->post->enterprise->address : '',
            '',
            !empty($data->post->note) ? $data->post->note : '',
            '',
            !empty($data->candidateNotes) ? $data->candidateNotes->pluck('content')->join(' | ') : '',
            !empty($data->post->user->name) ? $data->post->user->name : '',
        ];
    }
}
