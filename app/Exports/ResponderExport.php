<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResponderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    private $header;
    private $body;

    public function __construct($data)
    {
        $this->data = $data;
        
        $arrayData = $this->data->toArray();
        $this->header = array_map(function($item){
           return $item['kolom'];
        },$arrayData[0]);

        $body = array_map(function($item){
            $answerArray = [];
            foreach ($item as $key => $value) {
                $answerArray[] = $value['answer'];
            }
           return $answerArray;
        },$arrayData);
        $this->body = collect($body);
    }


    public function collection()
    {
        return $this->body;
    }

    public function headings(): array
    {
        return $this->header;
    }
}
