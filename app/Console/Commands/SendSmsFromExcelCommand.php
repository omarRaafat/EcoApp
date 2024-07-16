<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendSmsJob;

class SendSmsFromExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendSmsFromExcelCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            ['phone' => '0530803969','order_code'=>'152770110984','vendor'=>'آل منيف للزراعة','region'=>'منطقة الاسياح'],
            ['phone' => '0558882848','order_code'=>'565625168938','vendor'=>'آل منيف للزراعة','region'=>'منطقة الاسياح'],
            ['phone' => '0502811156','order_code'=>'629513182391','vendor'=>'آل منيف للزراعة','region'=>'منطقة الاسياح'],
            ['phone' => '0569138610','order_code'=>'775267274247','vendor'=>'آل منيف للزراعة','region'=>'منطقة تبوك'],
            ['phone' => '0567379028','order_code'=>'371916277133','vendor'=>'آل منيف للزراعة','region'=>'منطقة تبوك'],
            ['phone' => '0581351111','order_code'=>'570225296555','vendor'=>'آل منيف للزراعة','region'=>'منطقة بريدة'],
            ['phone' => '0544213777','order_code'=>'381679453899','vendor'=>'آل منيف للزراعة','region'=>'منطقة الاسياح'],
            ['phone' => '0555515410','order_code'=>'552944605487','vendor'=>'آل منيف للزراعة','region'=>'منطقة طبرجل'],

            ['phone' => '0504127274','order_code'=>'798199069694','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة خميس مشيط'],
            ['phone' => '0557807801','order_code'=>'335061074485','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة العلا'],
            ['phone' => '0546460014','order_code'=>'666290163653','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة العلا'],
            ['phone' => '0594029993','order_code'=>'250281404759','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة عين دار الجديده'],
            ['phone' => '0508371529','order_code'=>'269610406386','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة عين دار الجديده'],
            ['phone' => '0506177906','order_code'=>'606077414311','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة حائل'],
            ['phone' => '0553611630','order_code'=>'393046419270','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة عنيزة'],
            ['phone' => '0544213777','order_code'=>'298696453899','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة الاسياح'],
            ['phone' => '0534037174','order_code'=>'154405498731','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة العلا'],
            ['phone' => '0503704164','order_code'=>'830726959573','vendor'=>'شركة الوسائل الصناعية','region'=>'منطقة الخرمة'],
            ['phone' => '0502811156','order_code'=>'604015182393','vendor'=>'شركة الياسين الزراعية','region'=>'منطقة الاسياح'],
            ['phone' => '0505925986','order_code'=>'801001328002','vendor'=>'شركة الياسين الزراعية','region'=>'منطقة المبرز'],
            ['phone' => '0506177906','order_code'=>'965886414311','vendor'=>'شركة الياسين الزراعية','region'=>'منطقة حائل'],

            
            ['phone' => '0535614321','order_code'=>'10000000009','vendor'=>'متجر تجريبي','region'=>'منطقة الرياض'],

        ];


        foreach ($data as $index => $item) {
            $msg = "عزيزي العميل

            منصة مزارع : طلبكم رقم (".$item['order_code'].") من التاجر ".$item['vendor'].",  في ".$item['region'].", جاهز للاستلام
    
            مع تحيات فريق منصة مزارع";
    
            dispatch(new SendSmsJob($msg, $item['phone']))->delay(($index * 0.2))->onQueue("customer-sms");
    
        }

        
        return Command::SUCCESS;
    }
}
