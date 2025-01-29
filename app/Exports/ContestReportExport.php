<?php
namespace App\Exports;

use App\Models\Contest;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContestReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $contest;

    public function __construct($contestId)
    {
        $this->contest = Contest::with('categories')->find($contestId);
    }

    public function headings(): array
    {
        if (! $this->contest) {
            return ['Error: Concurso no encontrado'];
        }

        // Obtener los nombres de las categorías
        $categoryNames = $this->contest->categories->pluck('name')->toArray();

        // Encabezados: Apostador | Categoría1 | Categoría2 | ... | Total
        return array_merge(['Apostador'], $categoryNames, ['Total']);
    }

    public function collection()
    {
        if (! $this->contest) {
            return new Collection([]);
        }

        $categories = $this->contest->categories;

        // Obtener usuarios con sus apuestas en este concurso
        $users = User::with(['bets' => function ($query) use ($categories) {
            $query->whereIn('category_id', $categories->pluck('id'));
        }])->whereNull('deleted_at')->get();

        $reportData = [];

        foreach ($users as $user) {
            $row              = [];
            $row['Apostador'] = sprintf('%s %s', $user->first_name, $user->last_name);
            $totalScore       = 0;

            foreach ($categories as $category) {
                // Encontrar apuesta del usuario en esta categoría
                $bet = $user->bets->where('category_id', $category->id)->first();

                // Verificar si ganó en esta categoría
                $score = ($bet && $bet->status === "Confirmado" && $bet->contestant_id == $category->contestantwin_id) ? 1 : 0;

                // Convertir el puntaje a string
                $row[$category->name] = (string) $score;
                $totalScore += $score;
            }

            // Total en string
            $row['Total'] = (string) $totalScore;
            $reportData[] = $row;
        }

        // Ordenar los datos por el puntaje total de mayor a menor
        return new Collection(collect($reportData)->sortByDesc('Total')->values());
    }

    public function styles(Worksheet $sheet)
    {
        // Limitar el nombre de la hoja si es demasiado largo
        $sheetTitle = strlen($this->contest->name) > 30 ? substr($this->contest->name, 0, 30) : $this->contest->name;

        // Establecer el título de la hoja
        $sheet->setTitle($sheetTitle);

        // Aplicar estilo al encabezado
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font'      => [
                'bold'  => true,
                'size'  => 10,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => 'center', // Centrado horizontal
                'vertical'   => 'center', // Centrado vertical
            ],
            'fill'      => [
                'fillType'   => 'solid',
                'startColor' => ['argb' => '4CAF50'],
            ],
        ]);

        // Estilo para todas las celdas (A2 en adelante)
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'font'      => [
                'size' => 9,
            ],
            'alignment' => [
                'horizontal' => 'center', // Centrado horizontal
                'vertical'   => 'center', // Centrado vertical
                'wrapText'   => true,     // Ajustar el texto si es largo
            ],
        ]);

        // Recorrer todas las columnas desde 'A' hasta la última columna y establecer un ancho fijo
        foreach (range('A', $sheet->getHighestColumn()) as $column) {
            // Ajuste de texto para cada columna
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);

                                                               // Establecer un ancho fijo para cada columna
            $sheet->getColumnDimension($column)->setWidth(10); // Ajusta el valor a lo que necesites
        }
    }

}
