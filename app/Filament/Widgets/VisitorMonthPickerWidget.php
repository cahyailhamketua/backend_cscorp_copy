<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class VisitorMonthPickerWidget extends Widget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = 'Pilih bulan pengunjung';

    public function render(): \Illuminate\Contracts\View\View
    {
        $selected = request()->query('visitor_month')
            ?? session('visitor_month')
            ?? request()->cookie('visitor_month')
            ?? now()->format('Y-m');

        return view('filament.widgets.visitor-month-picker', [
            'selected' => $selected,
        ]);
    }
}
