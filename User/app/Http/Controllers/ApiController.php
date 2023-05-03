<?php
namespace App\Http\Controllers;

use App\Common\ApiResponseData;
use App\Models\Cost;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use stdClass;
//use Thread;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input,
            [
                'email' => ['required', 'exists:users,email'],
                'password' => ['required', 'string'],
            ]);

        $responseData = new ApiResponseData($request);

        try {
            if ($validator->fails()) {
                $responseData->status = self::ERROR;
                $errors = $validator->errors();
                if ($errors->has('email')) {
                    $responseData->message =  self::ERR_INVALID_USER_EMAIL;
                }
                else {
                    $responseData->message =  self::ERR_INVALID_PASSWORD;
                }
                return response()->json($responseData);
            }
        }
        catch (Exception $e){
            Log::info('$e : ' . $e->getMessage());
        }
        // get user object
        $user = User::where('email', $request->email)->where('role', 'client')->first();
        if(isset($user)){
            if($user->status == 0){
                $responseData->status = self::ERROR;
                $responseData->message = self::ERR_INVALID_USER_STATUS;
                return response()->json($responseData);
            }
            else{
                if (!Hash::check($request->password, $user->password)) {
                    // no they don't
                    $responseData->status = self::ERROR;
                    $responseData->message = self::ERR_INVALID_PASSWORD;
                    return response()->json($responseData);
                }
                else{
                    Auth::login($user);
                    $success = array(
                        'token' =>  $user->createToken(config('app.name'))-> accessToken,
                        'user' => $user
                    );

                    //event(new QuestionArrived('question arrived'));
                    $responseData->result = $success;
                    $responseData->message = "success";
                    $responseData->status = self::SUCCESS;
                    return response()->json($responseData);
                }
            }
        }
        else {
            $responseData->status = self::ERROR;
            $responseData->message = self::ERR_INVALID_USER;
            return response()->json($responseData);
        }
    }
    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $responseData = new ApiResponseData($request);
        $responseData->message = "logout";
        $responseData->status = self::SUCCESS;
        return response()->json($responseData);
    }
    public function ocrImageUpload(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,
            [
                'image' => ['required'],
                'type' => ['required']
            ]);

        $responseData = new ApiResponseData($request);
        try {
            if ($validator->fails()) {
                $responseData->status = self::ERROR;
                $errors = $validator->errors();
                if ($errors->has('image')) {
                    $responseData->message =  self::ERR_INVALID_IMAGE;
                }
                if ($errors->has('type')) {
                    $responseData->message =  self::ERR_INVALID_TYPE;
                }
                return response()->json($responseData);
            }
        }
        catch (Exception $e){
            Log::info('$e : ' . $e->getMessage());
        }
        $type = $request->type;
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('file_', true) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/upload/';
            $file->move($destinationPath, $filename);
            $path = public_path(). '/upload/'. $filename;

            if($type == 1){
                $parseData = $this->getOCRInfo($path);
                $data = [
                    'shop_name' => $parseData->name,
                    'total' => $parseData->total,
                    'percent' => $parseData->percent,
                    'url' => asset('upload'). '/'. $filename,
                    'year' => $parseData->year,
                    'month' => $parseData->month,
                    'day' => $parseData->day
                ];
                $responseData->result = $data;
            }
            else{
                $ex = true;
                $code = 0;
                $parent_code = Auth::user()->user_code;
                while($ex){
                    $code = rand(100, 999);
                    $code = $parent_code . date('Ymd') . $code;
                    $c_cost = Cost::where('cost_code', $code)->first();
                    if(!isset($c_cost)) {
                        $ex = false;
                    }
                }
                $data = [
                    'user_id' => Auth::user()->id,
                    'url' => $filename,
                    'type' => 0,
                    'cost_code' => $code
                ];
                Cost::create($data);
            }
            Log::info("AsyncOperation End: " . date('d-m-y h:i:s'));
            $responseData->message = "success";
            $responseData->status = self::SUCCESS;
            return response()->json($responseData);
        }
        $responseData->status = self::ERROR;
        $responseData->message =  self::ERR_INVALID_IMAGE;
        return response()->json($responseData);
    }
    public function ocrResultSave(Request $request){
        $responseData = new ApiResponseData($request);
        $shop_name = $request->shop_name;
        $shop_id = null;
        if(!empty($shop_name)){
            $shop = Shop::where('shop_name', $shop_name)->first();
            if(isset($shop)){
                $shop_id = $shop->id;
            }
            else{
                $shop_data = [
                    'shop_name' => $shop_name
                ];
                $shop = Shop::create($shop_data);
                $shop_id = $shop->id;
            }
        }

        $url = "";
        $img_url = $request->url;
        if(isset($img_url)){
            $img_arr = explode('/', $img_url);
            $url = $img_arr[count($img_arr) - 1];
        }
        $ex = true;
        $code = 0;
        $parent_code = Auth::user()->user_code;
        while($ex){
            $code = rand(100, 999);
            $code = $parent_code . date('Ymd') . $code;
            $c_cost = Cost::where('cost_code', $code)->first();
            if(!isset($c_cost)) {
                $ex = false;
            }
        }
        //for second auto select account Id
        if($shop_id != null){
            $sql = "SELECT account_id, COUNT(*) AS cnt FROM costs WHERE shop_id = " . $shop_id . " AND user_id = " . Auth::user()->id . " AND account_id IS NOT NULL GROUP BY account_id";
            $data = DB::select($sql);
            if(isset($data)){
                $account_id = null;
                $max = $this->max_attribute_in_array($data, 'cnt');
                $data = json_decode(json_encode($data, true), true);
                foreach ($data as $item){
                    if($item['cnt'] == $max){
                        $account_id = $item['account_id'];
                    }
                }
                Log::info("max: " . $account_id);
                $data = [
                    'user_id' => Auth::user()->id,
                    'shop_id' => $shop_id,
                    'pay_date' => $request->pay_date,
                    'total' => $request->total,
                    'percent' => $request->percent,
                    'content' => $request->contents,
                    'note' => $request->note,
                    'url' => $url,
                    'cost_code' => $code,
                    'account_id' => $account_id
                ];
            }
            else{
                $data = [
                    'user_id' => Auth::user()->id,
                    'shop_id' => $shop_id,
                    'pay_date' => $request->pay_date,
                    'total' => $request->total,
                    'percent' => $request->percent,
                    'content' => $request->contents,
                    'note' => $request->note,
                    'url' => $url,
                    'cost_code' => $code
                ];
            }
        }
        else{
            $data = [
                'user_id' => Auth::user()->id,
                'shop_id' => $shop_id,
                'pay_date' => $request->pay_date,
                'total' => $request->total,
                'percent' => $request->percent,
                'content' => $request->contents,
                'note' => $request->note,
                'url' => $url,
                'cost_code' => $code,
            ];
        }

        Cost::create($data);
        $responseData->message = "success";
        $responseData->status = self::SUCCESS;
        return response()->json($responseData);

    }
    function max_attribute_in_array($array, $prop) {
        return max(array_map(function($o) use($prop) {
            return $o->$prop;
        }, $array));
    }
    public function getShopList(Request $request){
        $responseData = new ApiResponseData($request);
        $user_id = Auth::user()->id;
        $shop_data = Cost::with('shop')->where('user_id', $user_id)->whereNotNull('shop_id')->get()->groupBy('shop_id')->toArray();
        $data = [];
        foreach($shop_data as $key=>$datum){
            $tmp = [];
            $tmp['shop_id'] = $datum[0]['shop']['id'];
            $tmp['shop_name'] = $datum[0]['shop']['shop_name'];
            array_push($data, $tmp);
        }
        $responseData->result = $data;
        $responseData->status = self::SUCCESS;
        $responseData->message = "success";
        return response()->json($responseData);
    }

    private function getOCRInfo($path) {
        $content = '納品 書 ( 級 填
1 2022 年 11 月 O07 日 08:13 <
ENEOS T カ ー ド 会 員 様 -
XXXXXXXXXXXX2957
ENEOS T カ ー ド
車両 番号 実車 番 ;
1100-00 5
ENEOS NM Ral es
店 語 9L * : 。
。 (175 円 ) ¥3,088 >
( ア EID 値 引 5 円 -\88) .
値 引 後 単価 (170 円 ) \3,000 =
0 人 言 十 3,000 rr
( 消 税 10% 対 象 \3,000 =
: 内 消費 税 等 ¥273) - =
お 預り \¥3,000 :
お 釣り \¥0 =
T# イト : 基本 過 3 3
特別 P OR E :
今回 計 83P ; a
, 利用 ポイ ント OR - ; i
利用 可能 ポイ ント 3
本 日 付与 され た ポイ ント は 2ー3 日 : : A
目 以 降 に 反映 され ます 。 有 効 期 限 切 ” ;
等 の 理由 で 、T カー ド に ポイ ント が ;
加算 され な いこ と が あり ます 。 -
詳細 は www. tsite. jp に て ご 確認 下さ ;
\
財 の - ;
ne ネクサ スエ ナジ ー 軸 ツ
Dr. Drive Tt セル mS ;
大 阪 府 大 阪 市 淀川 区
新高 lr 10739 :
TEL:06-6393-2458 5-027171 . 。
by- ト No 4557-06 デー- 狼 52940-2942
O77 Zam 2022/11/07 -
';
        $command = 'tesseract --tessdata-dir /home/ubuntu/tessdata_best '.$path.' - -l script/Japanese --psm 6';
        $content = shell_exec($command);
        Log::info($content);
        $name = '';
        $total = '';
        $percent = '';
        $year = '';
        $month = '';
        $day = '';
        $line = strtok($content, PHP_EOL);
        $prevLine = $line;
        /*do something with the first line here...*/
        $isContainNumber = false;
        while ($line !== FALSE) {
            // get the next line
            $line = strtok(PHP_EOL);
            if($isContainNumber) {
                $splits = explode(' ', $line);
                for($i = 0, $iMax = count($splits); $i < $iMax; $i ++) {
                    if(strlen($splits[$i]) > 1) {
                        $name = $splits[$i];
                        break;
                    }
                }
                $isContainNumber = false;
            } else {
                if(str_contains($line, '年')) {
                    $len = strlen($line);

                    for($i = 0; $i < $len; $i++) {
                        if ($line[$i] == '年') {
                            for ($j = $i - 1; $j >= 0; $j--) {
                                if ($line[$j] == ' ' || $line[$j] == ',' || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if (is_numeric($line[$j])) {
                                        $year = $line[$j] . $year;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                        if ($line[$i] == '月') {
                            for ($j = $i - 1; $j >= 0; $j--) {
                                if ($line[$j] == ' ' || $line[$j] == ',' || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if (is_numeric($line[$j])) {
                                        $month = $line[$j] . $month;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }

                        if ($line[$i] == '日') {
                            for ($j = $i - 1; $j >= 0; $j--) {
                                if ($line[$j] == ' ' || $line[$j] == ',' || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if (is_numeric($line[$j])) {
                                        $day = $line[$j] . $day;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                    }
                }
                if(str_contains($line, 'XXXXX')) {
                    $isContainNumber = true;
                }

                if(str_contains($line, '%')) {
                    $len = strlen($line);
                    for($i = 0; $i < $len; $i++) {
                        if($line[$i] == '%') {
                            for($j = $i - 1; $j >= 0; $j --) {
                                if($line[$j] == ' ' || $line[$j] == ','  || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if(is_numeric($line[$j])) {
                                        $percent = $line[$j].$percent;
                                    }
                                } else {
                                    break;
                                }
                            }

                            for($j = $i; $j < $len; $j++) {
                                if(is_numeric($line[$j])) {
                                    for($k = $j; $k < $len; $k ++) {
                                        if($line[$k] == ' ' || $line[$k] == ','  || $line[$k] == '.' || is_numeric($line[$k])) {
                                            if(is_numeric($line[$k])) {
                                                $total = $total.$line[$k];
                                            }
                                        } else {
                                            break;
                                        }
                                    }
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
            }
            $prevLine = $line;
            /*do something with the rest of the lines here...*/
        }
        //the bit that frees up memory
        strtok('', '');
        $data = new stdClass();
        $data -> name = $name;
        $data -> total = $total;
        $data -> percent = $percent;
        $data -> year = $year;
        $data -> month = $month;
        $data -> day = $day;
        return $data;
    }

    public function getListByDate(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,
            [
                'date' => ['required'],
            ]);

        $responseData = new ApiResponseData($request);
        try {
            if ($validator->fails()) {
                $responseData->status = self::ERROR;
                $errors = $validator->errors();
                if ($errors->has('date')) {
                    $responseData->message =  self::ERR_INVALID_DATE;
                }
                return response()->json($responseData);
            }
        }
        catch (Exception $e){
            Log::info('$e : ' . $e->getMessage());
        }
        $date = $request->date;
        $user_id = Auth::user()->id;
        $type_id = Auth::user()->account_type;
        $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " AND c.pay_date = '" . $date . "' ORDER BY c.created_at DESC";
        $data = DB::select($sql);
        $cost_data = json_decode(json_encode($data, true), true);
        //$cost_data = Cost::with('shop')->where('pay_date', $date)->where( 'user_id', Auth::user()->id)->get()->toArray();
        $total = Cost::where('pay_date', $date)->where( 'user_id', Auth::user()->id)->get()->sum('total');
        $data = [
            'cost_data' => $cost_data,
            'total' => $total
        ];
        $responseData->result = $data;
        $responseData->status = self::SUCCESS;
        $responseData->message = "success";
        return response()->json($responseData);
    }
    public function getListTotal(Request $request){
        $input = $request->all();
        $responseData = new ApiResponseData($request);
        $user_id = Auth::user()->id;
        $type_id = Auth::user()->account_type;
        $sql = "SELECT c.id, c.pay_date, c.content, c.total, c.percent, c.url, c.note, c.`status`, c.created_at, s.shop_name, ak.`subject`, ak.keyword_id FROM costs AS c
LEFT JOIN shops AS s ON s.id = c.shop_id LEFT JOIN (SELECT a.`subject`, a.keyword_id FROM accounts as a WHERE a.type_id = " . $type_id . ") AS ak ON ak.keyword_id = c.account_id
WHERE c.user_id = " . $user_id . " ORDER BY c.created_at DESC";
        $data = DB::select($sql);
        $cost_data = json_decode(json_encode($data, true), true);
        $page_start = $request->page_start;
        $page_end = $request->page_end;
        $offset = $page_end - $page_start;
        $cost_data = array_slice($cost_data, $page_start, $offset, false);
        $total = Cost::where( 'user_id', Auth::user()->id)->get()->count();
        $data = [
            'cost_data' => $cost_data,
            'total' => $total
        ];
        $responseData->result = $data;
        $responseData->status = self::SUCCESS;
        $responseData->message = "success";
        return response()->json($responseData);
    }
    public function getMonth(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,
            [
                'month' => ['required'],
            ]);

        $responseData = new ApiResponseData($request);
        try {
            if ($validator->fails()) {
                $responseData->status = self::ERROR;
                $errors = $validator->errors();
                if ($errors->has('month')) {
                    $responseData->message =  self::ERR_INVALID_MONTH;
                }
                return response()->json($responseData);
            }
        }
        catch (Exception $e){
            Log::info('$e : ' . $e->getMessage());
        }
        $month = $request->month;
        $firstD = date('Y-m-01', strtotime($month));
        $lastD = date('Y-m-t', strtotime($month));
        $total = Cost::where('pay_date', '>=', $firstD)->where('pay_date', '<=', $lastD)->where( 'user_id', Auth::user()->id)->get()->sum('total');
        $data = [
            'total' => $total
        ];
        $responseData->result = $data;
        $responseData->status = self::SUCCESS;
        $responseData->message = "success";
        return response()->json($responseData);
    }
}
