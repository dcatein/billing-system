<?php

namespace App\Domains\Orders\Repositories;

use App\Domains\Orders\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportOrderRepository implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Order::query();

        if (!empty($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['created_at_start'])) {
            $query->whereDate('created_at', '>=', $this->filters['created_at_start']);
        }

        if (!empty($this->filters['created_at_end'])) {
            $query->whereDate('created_at', '<=', $this->filters['created_at_end']);
        }

        return $query->get(['id','user_id','status','subtotal','discount','total','created_at']);
    }

    public function headings(): array
    {
        return ['ID', 'Vendedor', 'Status', 'Subtotal', 'Desconto', 'Total', 'Data de Criação'];
    }
}
