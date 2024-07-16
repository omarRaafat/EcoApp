<?php

namespace App\Imports;

use App\Models\YourModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Validator;
use App\Models\VendorWalletTransaction;
use App\Models\Vendor;
use App\Enums\VendorWallet as VendorWalletEnum;

class VendorWalletTransactionImport implements ToModel, WithValidation
{
    protected $errors = [];
    protected $lineNumber = 0;
    protected $ipans = [];
    protected $reference_nums = [];
    
    public function model(array $row)
    {
        $this->lineNumber++;

        if($this->lineNumber == 1 && is_string($row[4])) return;;


        if((empty($row[1]) && empty($row[2]) && empty($row[6]))) return;

        

        if((!isset($row[1]) || !isset($row[2]) || !isset($row[6]))){
            $this->errors[] = ' صيغة الملف غير صحيحة! ';
            return;
        }

        if(floatval($row[4]) <= 0){
            $this->errors[] = ' قيمة الخصم غير صحيحة! '  . $row[1];
            return;
        }

        if (in_array($row[2], $this->ipans)) {
            $this->errors[] = 'هذا الأيبان مكرر في الملف!' . $row[2];
            return;
        } 
        if (in_array($row[6], $this->reference_nums)) {
            $this->errors[] = 'هذا الرقم المرجعى مكرر في الملف!' . $row[6];
            return;
        } 

        
        $vendor = Vendor::whereHas('wallet')->with('wallet')->where('ipan',$row[2])->first();
        if(!$vendor){
            $this->errors[] = 'لا يوجد بائع مسجل بهذا الإيبان: ' . $row[2];
            return;
        }

        if(floatval($row[4]) > $vendor->wallet->completedTransactionAmount() ){
            $this->errors[] = 'لايمكن خصم قيمة أكبر من الرصيد المتاح: ' . $row[1];
            return;
        }

        $transaction = VendorWalletTransaction::where('reference_num',$row[6])->first();
        if($transaction){
            $this->errors[] = 'الرقم المرجعى مسجل مسبقا: ' . $row[6];
            return;
        }


        array_push($this->ipans,$row[2]);
        array_push($this->reference_nums,$row[6]);

        $transactionRecorde = VendorWalletTransaction::create([
            'wallet_id' => $vendor->wallet->id,
            'amount' => floatval($row[4]),
            'operation_type' => VendorWalletEnum::OUT,
            'admin_id' => 1,
            'reference' => null,
            'reference_id' =>  null,
            'reference_num' => $row[6],
            'reason' => $row[5],
            'status' => 'completed',
        ]);

      
        $transactionRecorde->wallet()->update([
            "balance" => ($vendor->wallet->balance - floatval($row[4]))
        ]);
        
        return $transactionRecorde;
    }

    public function getErrors()
    {
        return array_unique($this->errors);;
    }

    public function rules(): array
    {
        return [
            '0' => ['required'],
            '1' => ['required'],
            '2' => ['required'],
            '3' => ['required'],
            '4' => ['required'],
            '5' => ['nullable'],
            '6' => ['required'],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'operation_number',
            '1' => 'fullname',
            '2' => 'iban',
            '3' => 'bank',
            '4' => 'amount',
            '5' => 'description',
            '6' => 'reference_number',
        ];
    }

}