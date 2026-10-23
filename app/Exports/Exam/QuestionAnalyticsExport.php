<?php

namespace App\Exports\Exam;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class QuestionAnalyticsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Mã câu hỏi',
            'Câu hỏi',
            'Số câu trả lời đúng',
            'Tổng số câu trả lời',
            'Tỉ lệ trả lời đúng (%)',
            'Xác định có vấn đề (<40% hoặc >95%)',
        ];
    }

    public function map($data): array
    {
        $percent = round($data->correct_answers / $data->total_answers, 2)*100;

        return [
            $data->question_id,
            preg_replace('/<[^>]*>/', '', $data->question_text),
            $data->correct_answers,
            $data->total_answers,
            $percent,
            ($percent < 40 || $percent > 95) ? 'Có' : 'Không'
        ];
    }

    public function title(): string
    {
        return "Phân tích kết quả";
    }
}
