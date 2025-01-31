<?php
namespace App\Exports;

use App\Models\Contest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Mpdf\Mpdf;

class ContestMiApuestaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $contest;
    protected $includeAllUsers;

    public function __construct($contestId, $includeAllUsers = false)
    {
        $this->contest = Contest::with('categories')->find($contestId);
        $this->includeAllUsers = $includeAllUsers;
    }

    public function collection()
    {
        // Obtener el concurso y sus categorías
        $contest = Contest::with('categories')->find($this->contest->id);

        if (! $contest) {
            return collect([]);
        }

        $categories = $contest->categories;

        // Si no se debe incluir a todos los usuarios, filtrar por el usuario logueado
        $usersQuery = User::with(['bets' => function ($query) use ($categories) {
            $query->whereIn('category_id', $categories->pluck('id')->toArray());
        }]);

        // Si no se pasan todos los apostadores, filtrar por el usuario logueado
        if (! $this->includeAllUsers) {
            $usersQuery->where('id', Auth::id());  // Filtrar por el usuario logueado
        }

        // Obtener los usuarios (pueden ser todos o solo el usuario logueado)
        $users = $usersQuery->get();

        $data = [];

        foreach ($users as $user) {
            foreach ($categories as $category) {
                // Verificar si el usuario tiene una apuesta en esta categoría
                $bet = $user->bets->where('category_id', $category->id)->first();

                // Si tiene apuesta, agregar el nombre del concursante apostado
                $data[] = [
                    'Apostador' => $user->first_name . ' ' . $user->last_name,
                    'Categoría' => $category->name,
                    'Apuesta'   => $bet ? ($bet->contestant ? $bet->contestant->names : 'Sin apuesta') : 'Sin apuesta',
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return ['Apostador', 'Categoría', 'Apuesta'];
    }

    public function styles($sheet)
    {
        // Estilo para los encabezados
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font'      => [
                'bold'  => true,
                'size'  => 12,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical'   => 'center',
            ],
            'fill'      => [
                'fillType'   => 'solid',
                'startColor' => ['argb' => '4CAF50'],
            ],
        ]);

        // Estilo para las celdas de datos
        $sheet->getStyle('A2:C' . $sheet->getHighestRow())->applyFromArray([
            'font'      => [
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical'   => 'center',
            ],
        ]);
    }

    public function exportToPdf()
    {
        // Obtener los datos del reporte
        $data = $this->collection();
    
        // Pasar los datos a la vista
        $pdfContent = view('pdfs.reportwincontest', [
            'contest'  => $this->contest,
            'headings' => $this->headings(),
            'data'     => $data,
        ])->render();
    
        // Crear una instancia de Mpdf
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($pdfContent);
    
        // Generar el PDF y guardarlo o descargarlo
        return $mpdf->Output("Reporte - " . $this->contest->name, 'D'); // 'D' para descargar
    }
    

}
