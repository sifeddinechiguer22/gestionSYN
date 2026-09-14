<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Residence;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $expenses = $query->latest('expense_date')->paginate(10)->withQueryString();
        $totalExpensesThisMonth = Expense::whereMonth('expense_date', now()->month)->sum('amount');

        return view('syndic.expenses.index', compact('expenses', 'totalExpensesThisMonth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:maintenance,electricity,water,cleaning,security,repairs,other'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'expense_date' => ['required', 'date'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $residence = Residence::first();

        Expense::create([
            'residence_id' => $residence->id,
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'vendor_name' => $request->vendor_name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Dépense enregistrée avec succès.');
    }
}
