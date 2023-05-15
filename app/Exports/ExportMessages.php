<?php

namespace App\Exports;

use App\Models\Messages;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportMessages implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithColumnFormatting
{
    /**
     * @var int
     */
    protected $chat_id;

    /**
     * ExportMessages constructor.
     *
     * @param int $chat_id
     */
    public function __construct(int $chat_id)
    {
        $this->chat_id = $chat_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Messages::with('chat')
            ->where('chat_id', $this->chat_id)
            ->orderBy('id', 'asc')
            ->select('id', 'chat_id', 'message', 'is_user')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Message Id',
            'Chat Id',
            'Message',
            'Type'
        ];
    }

    /**
     * @param mixed $message
     * @return array
     */
    public function map($message): array
    {
        return [
            $message->id,
            $message->chat_id,
            $message->message,
            $message->is_user ? 'question' : 'answer'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'C' => 100,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('C')->getAlignment()->setWrapText(true);
    }
}
