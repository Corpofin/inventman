<?php

namespace App\DataTables;

use App\Models\Product;
use Form;
use Yajra\Datatables\Services\DataTable;

class ProductDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'products.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $products = Product::query();

        return $this->applyScopes($products);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
                         ],
                    ],
                    'colvis'
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'name' => ['name' => 'name', 'data' => 'name'],
            'description' => ['name' => 'description', 'data' => 'description'],
            'providers_id' => ['name' => 'providers_id', 'data' => 'providers_id'],
            'price' => ['name' => 'price', 'data' => 'price'],
            'cost' => ['name' => 'cost', 'data' => 'cost'],
            'productstypes_id' => ['name' => 'productstypes_id', 'data' => 'productstypes_id'],
            'code' => ['name' => 'code', 'data' => 'code'],
            'productscategories_id' => ['name' => 'productscategories_id', 'data' => 'productscategories_id'],
            'urlimage' => ['name' => 'urlimage', 'data' => 'urlimage']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'products';
    }
}
