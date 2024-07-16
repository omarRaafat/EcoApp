<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\City;

class UpdateCitiesSplSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_city = City::where('name->ar', 'like', 'الرياض')->first();if($new_city){$new_city->spl_id = 3;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مكة المكرمة')->first();if($new_city){$new_city->spl_id = 6;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'جدة')->first();if($new_city){$new_city->spl_id = 18;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدمام')->first();if($new_city){$new_city->spl_id = 13;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المدينة المنورة')->first();if($new_city){$new_city->spl_id = 14;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'أبها')->first();if($new_city){$new_city->spl_id = 15;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'تبوك')->first();if($new_city){$new_city->spl_id = 1;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حائل')->first();if($new_city){$new_city->spl_id = 10;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'عرعر')->first();if($new_city){$new_city->spl_id = 2213;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'نجران')->first();if($new_city){$new_city->spl_id = 3417;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الباحة')->first();if($new_city){$new_city->spl_id = 1542;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الطائف')->first();if($new_city){$new_city->spl_id = 5;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القريات')->first();if($new_city){$new_city->spl_id = 2226;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المجمعة')->first();if($new_city){$new_city->spl_id = 24;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الزلفي')->first();if($new_city){$new_city->spl_id = 270;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الغاط')->first();if($new_city){$new_city->spl_id = 306;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حوطة سدير')->first();if($new_city){$new_city->spl_id = 165;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'عفيف')->first();if($new_city){$new_city->spl_id = 418;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'شقراء')->first();if($new_city){$new_city->spl_id = 500;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القويعية')->first();if($new_city){$new_city->spl_id = 880;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'رماح')->first();if($new_city){$new_city->spl_id = 294;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحريق')->first();if($new_city){$new_city->spl_id = 3158;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدرعية')->first();if($new_city){$new_city->spl_id = 664;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مرات')->first();if($new_city){$new_city->spl_id = 820;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المزاحمية')->first();if($new_city){$new_city->spl_id = 990;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حوطة بني تميم')->first();if($new_city){$new_city->spl_id = 3161;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ساجر')->first();if($new_city){$new_city->spl_id = 682;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدوادمي')->first();if($new_city){$new_city->spl_id = 669;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حريملاء')->first();if($new_city){$new_city->spl_id = 795;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'السليل')->first();if($new_city){$new_city->spl_id = 1361;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'وادي الدواسر')->first();if($new_city){$new_city->spl_id = 1351;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الخرج')->first();if($new_city){$new_city->spl_id = 1061;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدلم')->first();if($new_city){$new_city->spl_id = 1073;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'رابغ')->first();if($new_city){$new_city->spl_id = 377;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الليث')->first();if($new_city){$new_city->spl_id = 1390;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'خليص')->first();if($new_city){$new_city->spl_id = 1105;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الجموم')->first();if($new_city){$new_city->spl_id = 1257;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ينبع')->first();if($new_city){$new_city->spl_id = 483;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بحرة')->first();if($new_city){$new_city->spl_id = 3504;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حفر الباطن')->first();if($new_city){$new_city->spl_id = 47;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القيصومة')->first();if($new_city){$new_city->spl_id = 55;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الخبر')->first();if($new_city){$new_city->spl_id = 31;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القطيف')->first();if($new_city){$new_city->spl_id = 67;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'رأس تنورة')->first();if($new_city){$new_city->spl_id = 2590;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بقيق')->first();if($new_city){$new_city->spl_id = 243;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'صفوى')->first();if($new_city){$new_city->spl_id = 2167;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'سيهات')->first();if($new_city){$new_city->spl_id = 454;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'النعيرية')->first();if($new_city){$new_city->spl_id = 115;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الخفجي')->first();if($new_city){$new_city->spl_id = 2464;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الأحساء')->first();if($new_city){$new_city->spl_id = 3677;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الظهران')->first();if($new_city){$new_city->spl_id = 227;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الجبيل')->first();if($new_city){$new_city->spl_id = 113;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بدر')->first();if($new_city){$new_city->spl_id = 1053;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'طريف')->first();if($new_city){$new_city->spl_id = 2208;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'رفحاء')->first();if($new_city){$new_city->spl_id = 2256;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'نمرة')->first();if($new_city){$new_city->spl_id = 1576;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بريدة')->first();if($new_city){$new_city->spl_id = 11;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'عنيزة')->first();if($new_city){$new_city->spl_id = 80;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الرس')->first();if($new_city){$new_city->spl_id = 2421;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البكيرية')->first();if($new_city){$new_city->spl_id = 2630;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'رياض الخبراء')->first();if($new_city){$new_city->spl_id = 2467;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المذنب')->first();if($new_city){$new_city->spl_id = 2448;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البدائع')->first();if($new_city){$new_city->spl_id = 2481;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'النماص')->first();if($new_city){$new_city->spl_id = 2519;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'خميس مشيط')->first();if($new_city){$new_city->spl_id = 62;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'سراة عبيدة')->first();if($new_city){$new_city->spl_id = 3328;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'أحد رفيدة')->first();if($new_city){$new_city->spl_id = 65;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ظهران الجنوب')->first();if($new_city){$new_city->spl_id = 3381;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المجاردة')->first();if($new_city){$new_city->spl_id = 1294;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'تثليث')->first();if($new_city){$new_city->spl_id = 1443;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بارق')->first();if($new_city){$new_city->spl_id = 1297;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حقل')->first();if($new_city){$new_city->spl_id = 36;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'أملج')->first();if($new_city){$new_city->spl_id = 323;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ضباء')->first();if($new_city){$new_city->spl_id = 1947;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حالة عمار')->first();if($new_city){$new_city->spl_id = 16;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'تيماء')->first();if($new_city){$new_city->spl_id = 74;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الوجه')->first();if($new_city){$new_city->spl_id = 233;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحائط')->first();if($new_city){$new_city->spl_id = 2721;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'صامطة')->first();if($new_city){$new_city->spl_id = 3542;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'أبو عريش')->first();if($new_city){$new_city->spl_id = 3525;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بيش')->first();if($new_city){$new_city->spl_id = 3462;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'شرورة')->first();if($new_city){$new_city->spl_id = 3347;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بيشة')->first();if($new_city){$new_city->spl_id = 1301;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بلجرشي')->first();if($new_city){$new_city->spl_id = 1531;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العقيق')->first();if($new_city){$new_city->spl_id = 2819;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'دومة الجندل')->first();if($new_city){$new_city->spl_id = 2268;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'طبرجل')->first();if($new_city){$new_city->spl_id = 2240;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'رنية')->first();if($new_city){$new_city->spl_id = 2800;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الخرمة')->first();if($new_city){$new_city->spl_id = 1248;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'تربة')->first();if($new_city){$new_city->spl_id = 2156;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البرك')->first();if($new_city){$new_city->spl_id = 2893;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدرب')->first();if($new_city){$new_city->spl_id = 3402;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'أحد المسارحة')->first();if($new_city){$new_city->spl_id = 3652;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ثول')->first();if($new_city){$new_city->spl_id = 1879;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الصحنة')->first();if($new_city){$new_city->spl_id = 1086;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القصب')->first();if($new_city){$new_city->spl_id = 574;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'تاروت')->first();if($new_city){$new_city->spl_id = 456;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الصرار')->first();if($new_city){$new_city->spl_id = 118;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحناكية')->first();if($new_city){$new_city->spl_id = 777;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'خيبر')->first();if($new_city){$new_city->spl_id = 288;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العارضة')->first();if($new_city){$new_city->spl_id = 3597;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'فرسان')->first();if($new_city){$new_city->spl_id = 3571;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ضمد')->first();if($new_city){$new_city->spl_id = 3499;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'حبونا')->first();if($new_city){$new_city->spl_id = 3396;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'جلاجل')->first();if($new_city){$new_city->spl_id = 162;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'روضة سدير')->first();if($new_city){$new_city->spl_id = 166;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'عسفان')->first();if($new_city){$new_city->spl_id = 1342;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العيدابي')->first();if($new_city){$new_city->spl_id = 3455;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'عنك')->first();if($new_city){$new_city->spl_id = 2171;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الهفوف')->first();if($new_city){$new_city->spl_id = 12;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المبرز')->first();if($new_city){$new_city->spl_id = 2748;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مهد الذهب')->first();if($new_city){$new_city->spl_id = 360;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مليح')->first();if($new_city){$new_city->spl_id = 307;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'صلبوخ')->first();if($new_city){$new_city->spl_id = 801;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العيينة')->first();if($new_city){$new_city->spl_id = 830;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البدع')->first();if($new_city){$new_city->spl_id = 894;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القارة')->first();if($new_city){$new_city->spl_id = 2739;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الطرف')->first();if($new_city){$new_city->spl_id = 2763;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الجفر')->first();if($new_city){$new_city->spl_id = 2764;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مليجة')->first();if($new_city){$new_city->spl_id = 117;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العيينة')->first();if($new_city){$new_city->spl_id = 128;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحوية')->first();if($new_city){$new_city->spl_id = 2034;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العيون')->first();if($new_city){$new_city->spl_id = 2038;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ذهبان')->first();if($new_city){$new_city->spl_id = 2891;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القحمة')->first();if($new_city){$new_city->spl_id = 2894;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدرب')->first();if($new_city){$new_city->spl_id = 1862;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الجفر')->first();if($new_city){$new_city->spl_id = 2662;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'نمران')->first();if($new_city){$new_city->spl_id = 1474;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مليح')->first();if($new_city){$new_city->spl_id = 3250;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الواديين')->first();if($new_city){$new_city->spl_id = 3680;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العيون')->first();if($new_city){$new_city->spl_id = 3047;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الشقرة')->first();if($new_city){$new_city->spl_id = 3101;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الجفر')->first();if($new_city){$new_city->spl_id = 3109;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الهدى')->first();if($new_city){$new_city->spl_id = 1027;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الطرف')->first();if($new_city){$new_city->spl_id = 3449;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مستورة')->first();if($new_city){$new_city->spl_id = 3610;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القحمة')->first();if($new_city){$new_city->spl_id = 3634;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البدع')->first();if($new_city){$new_city->spl_id = 2298;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الجفر')->first();if($new_city){$new_city->spl_id = 2316;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الطرف')->first();if($new_city){$new_city->spl_id = 2840;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'مليح')->first();if($new_city){$new_city->spl_id = 41;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'سلوى')->first();if($new_city){$new_city->spl_id = 1932;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القويعية')->first();if($new_city){$new_city->spl_id = 358;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القويعية')->first();if($new_city){$new_city->spl_id = 3146;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القيصومة')->first();if($new_city){$new_city->spl_id = 2512;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'ذهبان')->first();if($new_city){$new_city->spl_id = 1885;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القويعية')->first();if($new_city){$new_city->spl_id = 2136;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'رأس الخير')->first();if($new_city){$new_city->spl_id = 3702;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'سبت العلاية')->first();if($new_city){$new_city->spl_id = 1627;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الهفوف')->first();if($new_city){$new_city->spl_id = 501;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحريق')->first();if($new_city){$new_city->spl_id = 580;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدرعية')->first();if($new_city){$new_city->spl_id = 828;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البدع')->first();if($new_city){$new_city->spl_id = 1079;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'السليل')->first();if($new_city){$new_city->spl_id = 1210;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المجمعة')->first();if($new_city){$new_city->spl_id = 1343;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المجمعة')->first();if($new_city){$new_city->spl_id = 1494;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بيشة')->first();if($new_city){$new_city->spl_id = 1514;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الصحنة')->first();if($new_city){$new_city->spl_id = 1578;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'بيش')->first();if($new_city){$new_city->spl_id = 1667;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'فرسان')->first();if($new_city){$new_city->spl_id = 1675;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'المجمعة')->first();if($new_city){$new_city->spl_id = 1761;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحوية')->first();if($new_city){$new_city->spl_id = 1901;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'طريف')->first();if($new_city){$new_city->spl_id = 1990;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحائط')->first();if($new_city){$new_city->spl_id = 2039;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'السليل')->first();if($new_city){$new_city->spl_id = 2322;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البدائع')->first();if($new_city){$new_city->spl_id = 2358;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'النماص')->first();if($new_city){$new_city->spl_id = 2663;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الدوادمي')->first();if($new_city){$new_city->spl_id = 2679;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الباحة')->first();if($new_city){$new_city->spl_id = 2693;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البدع')->first();if($new_city){$new_city->spl_id = 2785;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العقيق')->first();if($new_city){$new_city->spl_id = 2973;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الواديين')->first();if($new_city){$new_city->spl_id = 3274;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'القصب')->first();if($new_city){$new_city->spl_id = 3385;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'البرك')->first();if($new_city){$new_city->spl_id = 3424;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'السليل')->first();if($new_city){$new_city->spl_id = 3496;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'الحوية')->first();if($new_city){$new_city->spl_id = 2055;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العقيق')->first();if($new_city){$new_city->spl_id = 15607;$new_city->save();}
$new_city = City::where('name->ar', 'like', 'العقيق')->first();if($new_city){$new_city->spl_id = 5730;$new_city->save();}

    }
}