<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Accounting\Journal;
use App\Models\Admin\Accounting\JournalEntry;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::all();

        return view('admins.journals.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::all()->pluck('name', 'id');
        return view('admins.journals.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $debit = 0;
        $credit = 0;

        foreach($request->journalEntries as $key => $row)
        {
            foreach($row as $index => $value)
            {
                switch ($key)
                {
                    case 'debit':
                        if($value > 0)
                        {
                            $journalEntryRows[$index]['debit_credit'] = $key;
                            $journalEntryRows[$index]['amount'] = $value;
                            $debit += $value;
                        }
                        break;

                    case 'credit':
                        if($value > 0)
                        {
                            $journalEntryRows[$index]['debit_credit'] = $key;
                            $journalEntryRows[$index]['amount'] = $value;
                            $credit += $value;
                        }
                        break;
                    
                    default:
                        $journalEntryRows[$index][$key] = $value;
                        break;
                }
            }
        }

        foreach($journalEntryRows as $row)
        {
            if(isset($row['account_id']) && isset($row['amount']))
            {
                $journalEntries[] = $row;
            }
        }

        $journal = new Journal;

        $journal->date = $request->date;
        $journal->description = $request->description;

        $journal->save();

        foreach ($journalEntries as $entry)
        {
            $account = Account::find($entry['account_id']);

            $journal->accounts()->save($account, ['debit_credit' => $entry['debit_credit'], 'amount' => $entry['amount'], 'memo' => $entry['memo']]);
        }

        return redirect()->route('admins.journals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journal = Journal::findOrFail($id);

        return view('admins.journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function entries()
    {
        $journalEntries = JournalEntry::all();

        return view('admins.journals.entries', compact('journalEntries'));
    }
}
