<?php

//namespace App\Filament\Widgets;

//use App\Models\Tamu;
//use Filament\Widgets\ChartWidget;

//class StatusTamuChart extends ChartWidget
//{
  //  protected static ?string $heading = 'Status Kunjungan Tamu';
  //  protected int | string | array $columnSpan = 'lg';

   // protected function getData(): array
   // {
   //     $data = Tamu::selectRaw('posisi, COUNT(*) as total')
    //        ->groupBy('posisi')
    //        ->get();

      //  return [
      //      'datasets' => [
       //         [
      //              'label' => 'Total',
      //              'data' => $data->pluck('total'),
       //             'backgroundColor' => ['#16a34a', '#f97316'],
       //         ],
       //     ],
      //      'labels' => $data->pluck('posisi'),
      //  ];
  //  }

  //  protected function getType(): string
  //  {
 //       return 'doughnut';
 //   }
//}
