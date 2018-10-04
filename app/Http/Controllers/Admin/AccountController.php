<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Accounting\AccountType;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::where('parent_id', 0)->orderBy('number')->get();

        return view('admins.accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes = AccountType::all()->pluck('name', 'id');
        $parentAccounts = Account::all()->pluck('name', 'id');

        return view('admins.accounts.create', compact('accountTypes', 'parentAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = new Account;

        $account->account_type_id = $request->account_type_id;
        $account->number = $request->number;
        $account->name = $request->name;
        $account->parent_id = $request->parent_id;

        $account->save();
        
        return redirect()->route('admins.accounts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $accountTypes = AccountType::all()->pluck('name', 'id');
        $parentAccounts = Account::all()->pluck('name', 'id');

        return view('admins.accounts.edit', compact('account', 'accountTypes', 'parentAccounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
