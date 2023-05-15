<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Expense;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExpenseApprovalDatatables extends Controller
{
    public function index(Request $request)
    {
        $expense = Expense::where('school_id', session('school_id'))
                                ->with('expense_details')
                                ->withTrashed()
                                ->get();
        
        return DataTables::of($expense)
                        ->addColumn('expense_number', function ($row) {
                            return $row->expense_number;
                        })
                        ->addColumn('expense_date', function ($row) {
                            return $row->expense_date;
                        })
                        ->addColumn('status', function ($row) {
                            if ($row->deleted_at) 
                                return '<span class="badge badge-danger">Ditolak</span>';

                            if ($row->approval_by)
                                return '<span class="badge badge-success">Disetujui</span>';
                            
                            return '<span class="badge badge-primary">Menunggu Persetujuan</span>';
                        })
                        
                        ->addColumn('total', function ($row) {
                            return 'Rp. ' . number_format($row->expense_details()->sum(DB::raw('price * quantity')), 0, ', ', '.');
                        })
                        ->addColumn('action', function (Expense $row) use($request) {
                            $data = [
                                'redirect_url' => route('expense-approval.index'),
                                'resource'     => 'expense-approval',
                                'custom_links' => [
                                    [
                                        'label' => 'Detail',
                                        'url' => route('expense-approval.show', ['expense_approval' => $row->getKey()]),
                                    ]
                                ]
                            ];
                            return view('components.datatable-action', $data);
                        })
                        ->rawColumns(['status'])
                        ->toJson();
    }
}
