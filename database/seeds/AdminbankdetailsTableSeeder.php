<?php

use Illuminate\Database\Seeder;

class AdminbankdetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
         DB::table('admin_bank_details')->insert(
        [
            'coin'      => 'USD',
            'account_name'      => 'Full name',
            'account_number'      => '12345678',
            'swift_code'      => 'ICIC0001245',
            'iban'      => 'The International Bank Account Number',
            'bank_name'      => 'The name of the bank where the recipients account is held',
            'bank_address'      => 'The address of the recipients bank',
            'account'   => 'Account Name :   Full name 
                            Account Number: 12345678 
                            IBAN:   The International Bank Account Number.
                            Bank Name:  The name of the bank where the recipients account is held
                            Bank Address:   The address of the recipients bank
                            SWIFT/BIC Code: ICIC0001245',   
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),   
        ]);

    }
}
