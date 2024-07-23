
<?php
namespace app\Imports;

use App\Models\Column;
use App\Models\Dataset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatasetImport
{
    protected $dataset;
    protected $header;
    protected $rows;

    public function __construct(Dataset $dataset, array $header, array $rows)
    {
        $this->dataset = $dataset;
        $this->header = $header;
        $this->rows = $rows;
    }

    public function handle()
    {
        DB::transaction(function () {
            foreach ($this->header as $header) {
                $type = $this->detectType(collect($this->rows)->pluck(array_search($header, $this->header)));
                Column::create([
                    'name' => $header,
                    'type' => $type,
                    'dataset_id' => $this->dataset->id,
                ]);
            }
        });
    }

    private function detectType(Collection $values)
    {
        $isNumeric = $values->every(fn($value) => is_numeric($value));
        return $isNumeric ? 'numeric' : 'string';
    }
}
