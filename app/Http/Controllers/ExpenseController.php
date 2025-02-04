<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Group;



class ExpenseController extends Controller
{
    //
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->with('user', 'category', 'group')->latest()->get();
        return view('expenses.index')->with('expenses', $expenses);
    }

    public function family()
    {

        $expenses = Expense::where('group_id', Auth::user()->groups->firstWhere('type', 'family')->id)->with('user', 'category', 'group')->latest()->get();


        return view('expenses.index')->with('expenses', $expenses);
    }



    public function create()
    {

        $groups = Auth::user()->groups;

        $categories = Category::get();
        return view('expenses.create')->with([
            'categories' => $categories,
            'groups' => $groups
        ]);
    }

    public function store()
    {

        request()->validate([
            'group' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Auth::user()->groups->contains('id', $value)) {
                        $fail('The selected group is invalid.');
                    }
                },
            ],
            'category' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Category::where('id', $value)) {
                  //if (!Category::where('id', $value)->where('user_id', Auth::id())->exists()) {
                        $fail('The selected category is invalid.');
                    }
                },
            ],
            'title' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable',
        ]);


        Expense::create([
            'group_id' => request('group'),
            'category_id' => request('category'),
            'title' => request('title'),
            'amount' => request('amount'),
            'description' => request('description'),
            'user_id' => Auth::id(),
        ]);

        Session::flash('message', 'Expense added');
        return redirect(route('expenses'));
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit')->with('expense', $expense);
    }

    public function update(Expense $expense)
    {


        request()->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable',
        ]);

        if ($expense->user->isNot(Auth::user())) {
            abort(403);
        }

        $expense->update([
            'title' => request('title'),
            'amount' => request('amount'),
            'description' => request('description'),
        ]);

        Session::flash('message', 'Record has been updated');
        return redirect(route('expenses'));
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user->isNot(Auth::user())) {
            abort(403);
        }
        $expense->delete();

        Session::flash('message', 'Record has been deleted');
        return redirect(route('expenses'));
    }
}
