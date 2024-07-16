<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\City;

class UpdateCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_city = City::where('name->ar', 'like', 'أبها')->first();if($new_city){$new_city->latitude = 18.23360554617769;$new_city->longitude = 42.501525485792214;$new_city->postcode = 61411;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بقيق')->first();if($new_city){$new_city->latitude = 25.9256423846808;$new_city->longitude = 49.66564139155393;$new_city->postcode = 31992;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'أبو عريش')->first();if($new_city){$new_city->latitude = 16.965983458204096;$new_city->longitude = 42.83879717616087;$new_city->postcode = 45911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الافلاج')->first();if($new_city){$new_city->latitude = 22.297529102374625;$new_city->longitude = 46.73212012080198;$new_city->postcode = 11912;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'أحد المسارحة')->first();if($new_city){$new_city->latitude = 16.709056057803668;$new_city->longitude = 42.95007666377073;$new_city->postcode = 45952;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'أحد رفيدة')->first();if($new_city){$new_city->latitude = 18.195001063489283;$new_city->longitude = 42.820858562269265;$new_city->postcode = 61974;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'عين دار الجديده')->first();if($new_city){$new_city->latitude = 25.947678890158752;$new_city->longitude = 49.42510088709837;$new_city->postcode = 33288;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'البدع')->first();if($new_city){$new_city->latitude = 28.47640104575849;$new_city->longitude = 35.0217243078137;$new_city->postcode = 49779;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الدليمية')->first();if($new_city){$new_city->latitude = 26.029478874857347;$new_city->longitude = 43.27923735407835;$new_city->postcode = 54602;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الحناكية')->first();if($new_city){$new_city->latitude = 24.881078368335423;$new_city->longitude = 40.519952380933816;$new_city->postcode = 41961;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الخرج')->first();if($new_city){$new_city->latitude = 24.1549131440455;$new_city->longitude = 47.30117758540159;$new_city->postcode = 11942;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الخبر')->first();if($new_city){$new_city->latitude = 26.247865636714227;$new_city->longitude = 50.20637472895628;$new_city->postcode = 31952;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القارة')->first();if($new_city){$new_city->latitude = 25.419182139277016;$new_city->longitude = 49.678086841383035;$new_city->postcode = 36351;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العيينة')->first();if($new_city){$new_city->latitude = 24.90077642538529;$new_city->longitude = 46.38622244624143;$new_city->postcode = 13939;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الأحساء')->first();if($new_city){$new_city->latitude = 25.364206831057555;$new_city->longitude = 49.58530386713987;$new_city->postcode = 31982;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الغاط')->first();if($new_city){$new_city->latitude = 26.027030138711922;$new_city->longitude = 44.949245059766824;$new_city->postcode = 11914;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الهدى')->first();if($new_city){$new_city->latitude = 21.36614360280727;$new_city->longitude = 40.27885397700315;$new_city->postcode = 21955;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'المجاردة')->first();if($new_city){$new_city->latitude = 19.141615468174116;$new_city->longitude = 41.923713290967996;$new_city->postcode = 61937;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الرس')->first();if($new_city){$new_city->latitude = 25.86974149819342;$new_city->longitude = 43.49887808588987;$new_city->postcode = 51921;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'عنك')->first();if($new_city){$new_city->latitude = 26.523435819041758;$new_city->longitude = 50.02029379633909;$new_city->postcode = 32464;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'عسفان')->first();if($new_city){$new_city->latitude = 21.894647463932426;$new_city->longitude = 39.36458548335081;$new_city->postcode = 25333;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'عين ابن فهيد')->first();if($new_city){$new_city->latitude = 26.766777409671594;$new_city->longitude = 44.20646628169065;$new_city->postcode = 52465;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الزلفي')->first();if($new_city){$new_city->latitude = 26.30512509471234;$new_city->longitude = 44.8244472387219;$new_city->postcode = 11932;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'البدائع')->first();if($new_city){$new_city->latitude = 25.981208145003073;$new_city->longitude = 43.73302420405393;$new_city->postcode = 51951;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بدر')->first();if($new_city){$new_city->latitude = 23.770592871969523;$new_city->longitude = 38.79329642085081;$new_city->postcode = 41931;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بحرة')->first();if($new_city){$new_city->latitude = 21.400989655497824;$new_city->longitude = 39.44560965327268;$new_city->postcode = 21955;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بللسمر')->first();if($new_city){$new_city->latitude = 18.781856780622096;$new_city->longitude = 42.250556552686746;$new_city->postcode = 61988;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بارق')->first();if($new_city){$new_city->latitude = 18.92871122522061;$new_city->longitude = 41.931953037061746;$new_city->postcode = 61967;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بيش')->first();if($new_city){$new_city->latitude = 17.371952822830206;$new_city->longitude = 42.538947665967996;$new_city->postcode = 45971;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بيشة')->first();if($new_city){$new_city->latitude = 19.97884902693848;$new_city->longitude = 42.593879306592996;$new_city->postcode = 61361;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'البكيرية')->first();if($new_city){$new_city->latitude = 26.14343307293021;$new_city->longitude = 43.648566806592996;$new_city->postcode = 51941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بريدة')->first();if($new_city){$new_city->latitude = 26.355280837892174;$new_city->longitude = 43.96579703120237;$new_city->postcode = 51411;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ذهبان')->first();if($new_city){$new_city->latitude = 21.933187921069315;$new_city->longitude = 39.127692783155496;$new_city->postcode = 21442;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ضمد')->first();if($new_city){$new_city->latitude = 17.10482333117801;$new_city->longitude = 42.777900302686746;$new_city->postcode = 45913;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الدمام')->first();if($new_city){$new_city->latitude = 26.411872237435436;$new_city->longitude = 50.086555087842996;$new_city->postcode = 31146;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الدرب')->first();if($new_city){$new_city->latitude = 17.732024921949908;$new_city->longitude = 42.27046927241331;$new_city->postcode = 45971;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الدرعية')->first();if($new_city){$new_city->latitude = 24.749963603339335;$new_city->longitude = 46.53728445796018;$new_city->postcode = 11922;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الظهران')->first();if($new_city){$new_city->latitude = 26.23585603964706;$new_city->longitude = 50.00003775385862;$new_city->postcode = 31932;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ظهران الجنوب')->first();if($new_city){$new_city->latitude = 17.66252141931474;$new_city->longitude = 43.52016409663206;$new_city->postcode = 61953;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ضرما')->first();if($new_city){$new_city->latitude = 24.59022665752626;$new_city->longitude = 46.14006003169065;$new_city->postcode = 11923;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الدلم')->first();if($new_city){$new_city->latitude = 23.983130307215077;$new_city->longitude = 47.1590419652844;$new_city->postcode = 11942;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'دومة الجندل')->first();if($new_city){$new_city->latitude = 29.807000308917274;$new_city->longitude = 39.86995657710081;$new_city->postcode = 42421;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ضباء')->first();if($new_city){$new_city->latitude = 27.34647303647735;$new_city->longitude = 35.7057948949719;$new_city->postcode = 71911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'فرسان')->first();if($new_city){$new_city->latitude = 16.696395811676485;$new_city->longitude = 42.12215384272581;$new_city->postcode = 54943;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'جيزان')->first();if($new_city){$new_city->latitude = 16.88538977800457;$new_city->longitude = 42.56778677729612;$new_city->postcode = 45142;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حالة عمار')->first();if($new_city){$new_city->latitude = 29.160270324833423;$new_city->longitude = 36.08207663325315;$new_city->postcode = 71411;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حقل')->first();if($new_city){$new_city->latitude = 29.28461606290498;$new_city->longitude = 34.9477382543469;$new_city->postcode = 71951;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الحوية')->first();if($new_city){$new_city->latitude = 21.42376297787115;$new_city->longitude = 40.47909697321897;$new_city->postcode = 21944;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الهفوف')->first();if($new_city){$new_city->latitude = 25.371962269606357;$new_city->longitude = 49.594916904249246;$new_city->postcode = 31982;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حريمل')->first();if($new_city){$new_city->latitude = 25.55372307744455;$new_city->longitude = 38.70802363184934;$new_city->postcode = 41941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حريملاء')->first();if($new_city){$new_city->latitude = 25.115770619477633;$new_city->longitude = 46.096801364698464;$new_city->postcode = 11962;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الجعرانة')->first();if($new_city){$new_city->latitude = 21.553063956218796;$new_city->longitude = 39.94960745600706;$new_city->postcode = 21955;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'جدة')->first();if($new_city){$new_city->latitude = 21.530071321600296;$new_city->longitude = 39.201850497999246;$new_city->postcode = 21442;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الجبيل')->first();if($new_city){$new_city->latitude = 27.102852456117162;$new_city->longitude = 49.53861197260862;$new_city->postcode = 31951;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الجموم')->first();if($new_city){$new_city->latitude = 21.616274903364552;$new_city->longitude = 39.696235263624246;$new_city->postcode = 21955;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الكربوس')->first();if($new_city){$new_city->latitude = 16.873562640271604;$new_city->longitude = 42.63370474604612;$new_city->postcode = 45142;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'خيبر')->first();if($new_city){$new_city->latitude = 25.67651039979875;$new_city->longitude = 39.292487705030496;$new_city->postcode = 41311;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'خميس مشيط')->first();if($new_city){$new_city->latitude = 18.2988101203202;$new_city->longitude = 42.747687900342996;$new_city->postcode = 61961;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'خليص')->first();if($new_city){$new_city->latitude = 22.147040461674276;$new_city->longitude = 39.341926181592996;$new_city->postcode = 21921;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'المدينة المنورة')->first();if($new_city){$new_city->latitude = 24.462477633245513;$new_city->longitude = 39.594611728467996;$new_city->postcode = 41311;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'مهد الذهب')->first();if($new_city){$new_city->latitude = 23.49569522903421;$new_city->longitude = 40.87589224604612;$new_city->postcode = 41951;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'المجمعة')->first();if($new_city){$new_city->latitude = 25.889819449223186;$new_city->longitude = 45.373420322217996;$new_city->postcode = 11952;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'مكة المكرمة')->first();if($new_city){$new_city->latitude = 21.429755367356737;$new_city->longitude = 39.85141714838987;$new_city->postcode = 21955;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'مستورة')->first();if($new_city){$new_city->latitude = 23.099643004014613;$new_city->longitude = 38.82900198725706;$new_city->postcode = 21911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'محايل عسير')->first();if($new_city){$new_city->latitude = 18.54213169036113;$new_city->longitude = 42.05314596919065;$new_city->postcode = 61913;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'المبرز')->first();if($new_city){$new_city->latitude = 25.41755417552272;$new_city->longitude = 49.553718173780496;$new_city->postcode = 31982;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'نجران')->first();if($new_city){$new_city->latitude = 17.565826045320193;$new_city->longitude = 44.230842197217996;$new_city->postcode = 55461;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'النماص')->first();if($new_city){$new_city->latitude = 19.114368595183496;$new_city->longitude = 42.162665927686746;$new_city->postcode = 61977;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'نمرة')->first();if($new_city){$new_city->latitude = 19.57250236656204;$new_city->longitude = 41.67643507746702;$new_city->postcode = 65931;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'نمران')->first();if($new_city){$new_city->latitude = 22.613510507255295;$new_city->longitude = 41.13926371363645;$new_city->postcode = 21915;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'عنيزة')->first();if($new_city){$new_city->latitude = 26.08177706455616;$new_city->longitude = 43.978156650342996;$new_city->postcode = 51911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العثمانية')->first();if($new_city){$new_city->latitude = 25.193616794719507;$new_city->longitude = 49.30910071162229;$new_city->postcode = 31982;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العلا')->first();if($new_city){$new_city->latitude = 26.607267665280826;$new_city->longitude = 37.92674978999143;$new_city->postcode = 41941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القطيف')->first();if($new_city){$new_city->latitude = 26.57472485520093;$new_city->longitude = 49.995917880811746;$new_city->postcode = 31911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رأس تنورة')->first();if($new_city){$new_city->latitude = 26.771988380502087;$new_city->longitude = 49.9990077855969;$new_city->postcode = 31941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رجال ألمع')->first();if($new_city){$new_city->latitude = 18.210778163928826;$new_city->longitude = 42.27596243647581;$new_city->postcode = 61956;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رماح')->first();if($new_city){$new_city->latitude = 25.562898754086127;$new_city->longitude = 47.16590842036253;$new_city->postcode = 11981;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الرياض')->first();if($new_city){$new_city->latitude = 24.7197166530086;$new_city->longitude = 46.702766025342996;$new_city->postcode = 11461;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رياض الخبراء')->first();if($new_city){$new_city->latitude = 26.052170635134367;$new_city->longitude = 43.502997958936746;$new_city->postcode = 51961;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'سبت العلاية')->first();if($new_city){$new_city->latitude = 19.57565631438697;$new_city->longitude = 41.973151767530496;$new_city->postcode = 61985;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'صبيا')->first();if($new_city){$new_city->latitude = 17.16212910187123;$new_city->longitude = 42.629584872999246;$new_city->postcode = 45931;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'صفوى')->first();if($new_city){$new_city->latitude = 26.65818632173229;$new_city->longitude = 49.930185746981635;$new_city->postcode = 31921;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'صلبوخ')->first();if($new_city){$new_city->latitude = 25.073486041248447;$new_city->longitude = 46.348456943311746;$new_city->postcode = 15469;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'سلوى')->first();if($new_city){$new_city->latitude = 24.73219051345897;$new_city->longitude = 50.751227939405496;$new_city->postcode = 36621;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'صامطة')->first();if($new_city){$new_city->latitude = 16.612850067212737;$new_city->longitude = 42.945441806592996;$new_city->postcode = 45922;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'سراة عبيدة')->first();if($new_city){$new_city->latitude = 18.099207130830898;$new_city->longitude = 43.126716220655496;$new_city->postcode = 61914;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'سيهات')->first();if($new_city){$new_city->latitude = 26.486874552103977;$new_city->longitude = 50.0319667699719;$new_city->postcode = 31911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'شقراء')->first();if($new_city){$new_city->latitude = 25.254957470855384;$new_city->longitude = 45.274543369092996;$new_city->postcode = 11912;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'شرورة')->first();if($new_city){$new_city->latitude = 17.497731963140865;$new_city->longitude = 47.142219150342996;$new_city->postcode = 51730;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'تبوك')->first();if($new_city){$new_city->latitude = 28.374801495042743;$new_city->longitude = 36.570624912061746;$new_city->postcode = 71411;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الطائف')->first();if($new_city){$new_city->latitude = 21.27947208785138;$new_city->longitude = 40.440558994092996;$new_city->postcode = 21944;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'تنومة')->first();if($new_city){$new_city->latitude = 18.93520623621647;$new_city->longitude = 42.18051871088987;$new_city->postcode = 61988;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'تاروت')->first();if($new_city){$new_city->latitude = 26.585164122891076;$new_city->longitude = 50.07144888667112;$new_city->postcode = 31991;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'تثليث')->first();if($new_city){$new_city->latitude = 19.542011023052794;$new_city->longitude = 43.511237705030496;$new_city->postcode = 61935;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'تيماء')->first();if($new_city){$new_city->latitude = 27.60963990370577;$new_city->longitude = 38.51932486323362;$new_city->postcode = 71941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ثول')->first();if($new_city){$new_city->latitude = 22.283710593475767;$new_city->longitude = 39.122199619092996;$new_city->postcode = 23953;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'تربة')->first();if($new_city){$new_city->latitude = 21.20751352457357;$new_city->longitude = 41.620387637891824;$new_city->postcode = 29751;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'أملج')->first();if($new_city){$new_city->latitude = 25.038341421327136;$new_city->longitude = 37.2643943670178;$new_city->postcode = 71931;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العيون')->first();if($new_city){$new_city->latitude = 25.663204543138185;$new_city->longitude = 49.5511432531262;$new_city->postcode = 36255;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الوجه')->first();if($new_city){$new_city->latitude = 26.23100565832843;$new_city->longitude = 36.465031707563455;$new_city->postcode = 71921;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ينبع')->first();if($new_city){$new_city->latitude = 24.036131656188125;$new_city->longitude = 38.19866141108518;$new_city->postcode = 41912;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الدوادمي')->first();if($new_city){$new_city->latitude = 24.518403344643122;$new_city->longitude = 44.41554983881956;$new_city->postcode = 11911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'عفيف')->first();if($new_city){$new_city->latitude = 23.90853082553288;$new_city->longitude = 42.916473949232156;$new_city->postcode = 11921;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العقيق')->first();if($new_city){$new_city->latitude = 20.266398947802717;$new_city->longitude = 41.6713710668469;$new_city->postcode = 65931;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الأرطاوية')->first();if($new_city){$new_city->latitude = 26.496092774970517;$new_city->longitude = 45.35282095698362;$new_city->postcode = 15738;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الاسياح')->first();if($new_city){$new_city->latitude = 26.78945871414804;$new_city->longitude = 44.21092947749143;$new_city->postcode = 51922;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الباحة')->first();if($new_city){$new_city->latitude = 20.01256351199635;$new_city->longitude = 41.46675070551878;$new_city->postcode = 61008;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'البرك')->first();if($new_city){$new_city->latitude = 18.205070850664843;$new_city->longitude = 41.536960208692605;$new_city->postcode = 63533;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الحرجة')->first();if($new_city){$new_city->latitude = 17.922162834294138;$new_city->longitude = 43.36910208491331;$new_city->postcode = 64421;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الحريق')->first();if($new_city){$new_city->latitude = 23.623249193000184;$new_city->longitude = 46.521041000165994;$new_city->postcode = 11941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الخفجي')->first();if($new_city){$new_city->latitude = 28.418140420278025;$new_city->longitude = 48.475856387891824;$new_city->postcode = 31971;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الخرمة')->first();if($new_city){$new_city->latitude = 21.929764294382323;$new_city->longitude = 42.02301939753538;$new_city->postcode = 21985;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الليث')->first();if($new_city){$new_city->latitude = 20.152667214672192;$new_city->longitude = 40.28185805109983;$new_city->postcode = 21961;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'المذنب')->first();if($new_city){$new_city->latitude = 25.862945110963174;$new_city->longitude = 44.21779593256956;$new_city->postcode = 51931;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'المزاحمية')->first();if($new_city){$new_city->latitude = 24.46560263028689;$new_city->longitude = 46.27412756709104;$new_city->postcode = 11972;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القحمة')->first();if($new_city){$new_city->latitude = 18.006656534727494;$new_city->longitude = 41.679063642301614;$new_city->postcode = 63251;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القصب')->first();if($new_city){$new_city->latitude = 25.301214251615384;$new_city->longitude = 45.52834471491819;$new_city->postcode = 15271;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القيصومة')->first();if($new_city){$new_city->latitude = 28.308739766509248;$new_city->longitude = 46.121778095045144;$new_city->postcode = 39551;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القنفذة')->first();if($new_city){$new_city->latitude = 19.12868187299924;$new_city->longitude = 41.09218558100706;$new_city->postcode = 21912;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القريات')->first();if($new_city){$new_city->latitude = 31.34456121710502;$new_city->longitude = 37.36026724604612;$new_city->postcode = 75911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القويعية')->first();if($new_city){$new_city->latitude = 24.066777786987924;$new_city->longitude = 45.288276279249246;$new_city->postcode = 19247;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الواديين')->first();if($new_city){$new_city->latitude = 18.097983369729516;$new_city->longitude = 42.810644710340554;$new_city->postcode = 62261;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الطرف')->first();if($new_city){$new_city->latitude = 25.36319858748842;$new_city->longitude = 49.72323378352171;$new_city->postcode = 31982;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'النعيرية')->first();if($new_city){$new_city->latitude = 27.471433835506083;$new_city->longitude = 48.48873099116331;$new_city->postcode = 31982;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'عرعر')->first();if($new_city){$new_city->latitude = 30.96761412721528;$new_city->longitude = 41.03004416255003;$new_city->postcode = 91431;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'السفانية')->first();if($new_city){$new_city->latitude = 27.937104519939894;$new_city->longitude = 48.66279562739378;$new_city->postcode = 39216;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الصحنة')->first();if($new_city){$new_city->latitude = 23.988031495881753;$new_city->longitude = 47.13436564234739;$new_city->postcode = 11992;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الصرار')->first();if($new_city){$new_city->latitude = 26.98692341306731;$new_city->longitude = 48.38856657771116;$new_city->postcode = 37412;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'السليل')->first();if($new_city){$new_city->latitude = 20.47222462226269;$new_city->longitude = 45.5715175512219;$new_city->postcode = 11913;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الشقرة')->first();if($new_city){$new_city->latitude = 24.755965344814147;$new_city->longitude = 40.28314551142698;$new_city->postcode = 42230;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'البطحاء')->first();if($new_city){$new_city->latitude = 24.15209375277505;$new_city->longitude = 51.54087027338987;$new_city->postcode = 36806;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بلجرشي')->first();if($new_city){$new_city->latitude = 19.864585641846595;$new_city->longitude = 41.573695743360574;$new_city->postcode = 22888;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حفر الباطن')->first();if($new_city){$new_city->latitude = 28.379634587441675;$new_city->longitude = 45.96530874995237;$new_city->postcode = 31991;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حائل')->first();if($new_city){$new_city->latitude = 27.4988453248497;$new_city->longitude = 41.69918020991331;$new_city->postcode = 81411;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حرض')->first();if($new_city){$new_city->latitude = 24.13783921139809;$new_city->longitude = 49.05281027583128;$new_city->postcode = 36969;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حوطة بني تميم')->first();if($new_city){$new_city->latitude = 23.508761183035553;$new_city->longitude = 46.84455832270628;$new_city->postcode = 11941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حوطة سدير')->first();if($new_city){$new_city->latitude = 25.58860239157165;$new_city->longitude = 45.62541922358518;$new_city->postcode = 15270;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'جلاجل')->first();if($new_city){$new_city->latitude = 25.695692973403666;$new_city->longitude = 45.458564365186746;$new_city->postcode = 15357;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الجفر')->first();if($new_city){$new_city->latitude = 25.37630509776116;$new_city->longitude = 49.72194632319456;$new_city->postcode = 31982;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'مرات')->first();if($new_city){$new_city->latitude = 25.07224215599041;$new_city->longitude = 45.4616542699719;$new_city->postcode = 11933;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'مليجة')->first();if($new_city){$new_city->latitude = 27.26608835253867;$new_city->longitude = 48.42058142451292;$new_city->postcode = 37445;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رابغ')->first();if($new_city){$new_city->latitude = 22.788699352434048;$new_city->longitude = 39.03774222163206;$new_city->postcode = 21911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رفحاء')->first();if($new_city){$new_city->latitude = 29.61705645039405;$new_city->longitude = 43.52737387446409;$new_city->postcode = 91911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رنية')->first();if($new_city){$new_city->latitude = 21.25075687442714;$new_city->longitude = 42.84278830317503;$new_city->postcode = 29451;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رأس الخير')->first();if($new_city){$new_city->latitude = 27.493972669858124;$new_city->longitude = 49.185676181592996;$new_city->postcode = 37256;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'رأس تنورة')->first();if($new_city){$new_city->latitude = 26.766470874530402;$new_city->longitude = 49.98939474848753;$new_city->postcode = 31941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'روضة سدير')->first();if($new_city){$new_city->latitude = 25.61089505131877;$new_city->longitude = 45.588168704786355;$new_city->postcode = 15270;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'ساجر')->first();if($new_city){$new_city->latitude = 25.18755869608747;$new_city->longitude = 44.60128744868284;$new_city->postcode = 17658;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'سكاكا')->first();if($new_city){$new_city->latitude = 29.883829677991766;$new_city->longitude = 40.110969150342996;$new_city->postcode = 42421;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'طبرجل')->first();if($new_city){$new_city->latitude = 30.512152839062455;$new_city->longitude = 38.23196371821409;$new_city->postcode = 42421;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'طريف')->first();if($new_city){$new_city->latitude = 31.67253526773432;$new_city->longitude = 38.65922888545042;$new_city->postcode = 91411;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'أم الجماجم')->first();if($new_city){$new_city->latitude = 25.87653749451136;$new_city->longitude = 45.374450290479714;$new_city->postcode = 11952;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'وادي الدواسر')->first();if($new_city){$new_city->latitude = 20.45075370947777;$new_city->longitude = 44.85251387385374;$new_city->postcode = 11991;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الحائط')->first();if($new_city){$new_city->latitude = 25.9904665541816;$new_city->longitude = 40.4683681371594;$new_city->postcode = 81941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'القويعية')->first();if($new_city){$new_city->latitude = 24.061526923409442;$new_city->longitude = 45.28175314692503;$new_city->postcode = 11971;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'حبونا')->first();if($new_city){$new_city->latitude = 17.846493552150168;$new_city->longitude = 44.02020295886045;$new_city->postcode = 29613;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'بقعاء')->first();if($new_city){$new_city->latitude = 27.900852568344767;$new_city->longitude = 42.401103580274636;$new_city->postcode = 81911;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'مليح')->first();if($new_city){$new_city->latitude = 26.146669114581453;$new_city->longitude = 44.91096457270628;$new_city->postcode = 11914;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'تيماء')->first();if($new_city){$new_city->latitude = 27.620591531348868;$new_city->longitude = 38.53855093745237;$new_city->postcode = 71941;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الفارعه')->first();if($new_city){$new_city->latitude = 27.14870553860435;$new_city->longitude = 37.05758532313352;$new_city->postcode = 71411;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العيدابي')->first();if($new_city){$new_city->latitude = 17.236086416209957;$new_city->longitude = 42.94303854731565;$new_city->postcode = 45992;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'الدائر')->first();if($new_city){$new_city->latitude = 17.338896873518824;$new_city->longitude = 43.13259562281614;$new_city->postcode = 45962;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العيص')->first();if($new_city){$new_city->latitude = 25.059802608614174;$new_city->longitude = 38.11454733637815;$new_city->postcode = 46926;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'العارضة')->first();if($new_city){$new_city->latitude = 17.038090208488043;$new_city->longitude = 43.07298620966917;$new_city->postcode = 45933;$new_city->save();}
        $new_city = City::where('name->ar', 'like', 'قرية العليا')->first();if($new_city){$new_city->latitude = 27.556995980294296;$new_city->longitude = 47.699775302686746;$new_city->postcode = 37955;$new_city->save();}

    }
}