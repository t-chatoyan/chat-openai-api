<?php

namespace App\Exports;

use App\Models\Messages;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMessages implements FromCollection, WithHeadings
{
    /**
     * @var
     */
    protected $chat_id;

    /**
     * ExportMessages constructor.
     * @param $chat_id
     */
    public function __construct($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $messages = Messages::where('chat_id', $this->chat_id)
            ->with('chat')->orderBy('id', 'asc')
            ->select('id', 'chat_id', 'message', 'is_user')->get();
        return $messages;
    }

    public function headings(): array
    {
        return ['Message Id', 'Chat Id', 'Message', 'Type'];
    }
}
