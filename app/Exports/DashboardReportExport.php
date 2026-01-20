<?php

namespace App\Exports;

use App\Models\School;
use App\Models\Message;
use App\Models\SchoolReview;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DashboardReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return collect([
            ['Total Schools', School::count()],
            ['Total Reviews', SchoolReview::count()],
            [
                'Unread Messages',
                Message::whereDoesntHave('reads', function ($q) {
                    $q->where('user_id', auth()->id());
                })->count()
            ],
        ]);
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }
}
