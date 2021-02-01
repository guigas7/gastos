<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Payday;
use App\ExpenseType;
use App\Source;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Cached\Storage\Memcached;
use Illuminate\Support\Facades\Cache;


class PaymentFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ExpenseType $expenseType)
    {
        $month = session('month', thisMonth());
        $year = session('year', thisYear());

        $payDays = $expenseType->paydaysWithPaymentsAt($year, $month);
        # Para cada Payday
        foreach ($payDays as $payDay) {
            $paidInput = $request->has($payDay->id . '-pago') ? $request->get($payDay->id . '-pago') : false;
            $fileInput = $request->hasFile($payDay->id . '-actual-btn') ? $request->file($payDay->id . '-actual-btn') : false;
            # Se ainda não tem pagamento registrado E é pra ter
            if (($payDay->payments->first() == null) && ($paidInput != false)) {
                $payment = New Payment([
                    'month_id' => $month->id,
                    'year' => $year
                ]);
                $payDay->payments()->save($payment);
            } else {
                $payment = $payDay->payments->first();
            }
            # Se já não existe arquivo salvo nesse pagamento E existe arquivo pra salvar E foi pago
            if ($payment != null && $payment->filename == null && $fileInput != false && $paidInput != false) {
                # create new directory for this expense, if it doesn't exist yet
                $directory = 'comprovantes/' . $expenseType->source->slug . '/' . $expenseType->slug;
                Storage::makeDirectory($directory, 'private');
                $mimeEx = explode('/', $fileInput->getMimeType());
                $extension = $mimeEx[count($mimeEx) - 1];
                $name = $payDay->due_day . '_' .
                        $month->number . '_' .
                        $year . '-' .
                        $payDay->id . '.' .
                        $extension;
                $path = $fileInput->storeAs(
                    $directory, # Directory
                    $name, # Filename
                    'local', # Driver
                    'private' # Visibility
                );
                $payment->filename = $name;
                $payment->save();
            }
        }
        return redirect()->route('source.despesas', $expenseType->source->slug);
    }

    public function show(Source $source, ExpenseType $expenseType, Payment $payment) {
        $path = 'app/comprovantes/' . # Base path
        $source->slug . '/' . # Source
        $expenseType->slug . '/' . # Expense Type
        $payment->filename; # Filename
        return response()->file(storage_path($path));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //-
    }
}
