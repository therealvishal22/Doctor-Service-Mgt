<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;



class UserExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'status',
            'approve',
            'gender',
            'image',
            'age',
          
        ];
    }

    public function collection()
    {
        return User::with('services')->where('is_admin', '0')->where('approve', 'T')
 
       ->get(

        'id',
        'name',
        'email',
        'status',
        'approve',
        'gender',
        'image',
        'age' );
    }
}