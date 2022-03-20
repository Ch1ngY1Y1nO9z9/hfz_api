<?php

namespace App\Http\Controllers\api;

use PDO;
use stdClass;
use Carbon\Carbon;
use App\Models\News;
use App\Models\Poll;
use App\Models\Roll;
use App\Models\User;
use App\Models\Banners;
use App\Models\Betting;
use App\Models\Matches;
use App\Models\Outfits;
use App\Models\Fanbases;
use App\Models\Profiles;
use App\Models\ContactUs;
use App\Models\SongsLists;
use App\Models\Generations;
use App\Models\WrestlerData;
use Illuminate\Http\Request;
use App\Models\MatchesRecords;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    public function getBackground()
    {
        $cache = $this->checkCache('banners');

        if (!$cache) {
            $data = Banners::find(1);
            $this->setCache('banners', $data);
        } else {
            $data = $cache;
        }

        return json_encode($data);
    }

    public function getIndexArts()
    {
        $data = News::where('type','fan_arts')->orderBy('sort', 'desc')->orderBy('id', 'desc')->take(3)->get();

        return $data;
    }

    public function getIndexRank()
    {
        $data = [];
        $toprank = Profiles::where('rank', '1')->first();
        $topindex = Profiles::where('toindex', '1')->first();

        array_push($data, $toprank);
        array_push($data, $topindex);

        return $data;
    }

    public function getIndexPrev()
    {
        $data = Matches::orderBy('id', 'desc')->take(3)->get();

        return $data;
    }

    public function getWrestlers()
    {
        $cache = $this->checkCache('profiles');

        if (!$cache) {
            $data = Profiles::with('gens')->get();
            $this->setCache('profiles', $data);
        } else {
            $data = $cache;
        }

        return $data;
    }

    public function getDetail($name)
    {
        $cache = $this->checkCache('profile_' . $name);

        if (!$cache) {
            $data = Profiles::where('name_short', $name)->with('gens')->with('detail')->with('clips')->first();
            $data['outfits'] = Outfits::where('name_short', $data['name_short'])->get();

            $this->setCache('profile_' . $name, $data);
        } else {
            $data = $cache;
        }

        return json_encode($data);
    }

    public function getFanbase($name)
    {
        $cache = $this->checkCache('profile_' . $name);

        if (!$cache) {
            $data = [];
            $data['data'] = Fanbases::where('fan_name', $name)->first();

            $this->setCache('profile_' . $name, $data);
        } else {
            $data = $cache;
        }

        return $data;
    }

    public function getMatches($name)
    {
        $data = MatchesRecords::where(function ($q) use ($name) {
            $q->orWhere('participants', 'like', "%{$name}%");
        })->orderBy('id', 'desc')->get();

        return $data;
    }

    public function getWinLoseRate($name)
    {
        $cache = $this->checkCache($name . '_rate');

        if (!$cache) {
            $wreslter_records = MatchesRecords::where(function ($q) use ($name) {
                $q->orWhere('participants', 'like', "%{$name}%");
            })->orderBy('id', 'desc')->get();

            $total = count($wreslter_records);
            $single_total = 0;
            $single_win = 0;
            $tag_total = 0;
            $tag_win = 0;
            $multi_total = 0;
            $multi_win = 0;

            $single_draw = 0;
            $tag_draw = 0;
            $multi_draw = 0;

            foreach ($wreslter_records as $record) {
                $winners = explode(',', $record->result);
                $check_multi_winners = count($winners);

                if ($record->rule == 'Royal Rumble') {

                    if ($record->result == $name) {
                        $multi_total += 1;
                        $multi_win += 1;

                        continue;
                    } else {
                        $total = $total - 1;

                        continue;
                    }
                }

                if ($record->type == '1v1') {
                    $single_total += 1;
                } elseif ($record->type == '2v2') {
                    $tag_total += 1;
                } else {
                    $multi_total += 1;
                }

                foreach ($winners as $key => $winer) {
                    if ($winer == $name) {
                        if ($record->type == '1v1') {
                            $single_win += 1;
                        } elseif ($record->type == '2v2') {
                            $tag_win += 1;
                        } else {
                            $multi_win += 1;
                        }
                    } elseif ($winer == 'Draw') {
                        if ($record->type == '1v1') {
                            $single_draw += 1;
                        } elseif ($record->type == '2v2') {
                            $tag_draw += 1;
                        } else {
                            $multi_draw += 1;
                        }
                    }
                }
            }

            $single_lose = $single_total - $single_win - $single_draw;
            $tag_lose = $tag_total - $tag_win - $tag_draw;
            $multi_lose = $multi_total - $multi_win - $multi_draw;

            $total_win = $single_win + $tag_win + $multi_win;
            $total_draw = $single_draw + $tag_draw + $multi_draw;
            $total_lose = $single_lose + $tag_lose  + $multi_lose;

            if ($single_win == 0 && $single_total == 0) {
                $single_win_rate = 0;
            } else {
                $single_win_rate = round($single_win / $single_total * 100);
            }

            if ($tag_win == 0 && $tag_total == 0) {
                $tag_win_rate = 0;
            } else {
                $tag_win_rate = round($tag_win / $tag_total * 100);
            }

            if ($multi_win == 0 && $multi_total == 0) {
                $multi_win_rate = 0;
            } else {
                $multi_win_rate = round($multi_win / $multi_total * 100);
            }

            if ($total_win == 0 && $total == 0) {
                $total_win_rate = 0;
            } else {
                $total_win_rate = round($total_win / $total * 100);
            }


            $data = (object)[];
            $data->total = $total;
            $data->total_win = $total_win;
            $data->total_draw = $total_draw;
            $data->total_lose = $total_lose;
            $data->single_total = $single_total;
            $data->single_win = $single_win;
            $data->single_lose = $single_lose;
            $data->single_draw = $single_draw;
            $data->tag_total = $tag_total;
            $data->tag_win = $tag_win;
            $data->tag_lose = $tag_lose;
            $data->tag_draw = $tag_draw;
            $data->multi_total = $multi_total;
            $data->multi_win = $multi_win;
            $data->multi_lose = $multi_lose;
            $data->multi_draw = $multi_draw;
            $data->single_win_rate = $single_win_rate;
            $data->tag_win_rate = $tag_win_rate;
            $data->multi_win_rate = $multi_win_rate;
            $data->total_win_rate = $total_win_rate;

            $this->setCache($name . '_rate', $data);
        } else {
            $data = $cache;
        }


        return $data;
    }

    public function Profiles($gen)
    {
        $cache = $this->checkCache('profiles_' . $gen);

        if (!$cache) {
            if ($gen == 'all')
                $data = Profiles::all();
            else {
                $data = Profiles::where('generations_id', $gen)->get();
            }

            $this->setCache('prfiles_' . $gen, $data);
        } else {
            $data = $cache;
        }

        return json_encode($data);
    }

    public function getArts($type)
    {
        if ($type == 'All') $data = News::where('type', 'fan_arts')->orWhere('type', 'promote')->orderBy('created_at','desc')->get();
        else {
            $data = News::where('type', $type);
        }
        return $data;
    }

    public function getNewsContent($id)
    {
        $data = News::find($id);

        return $data;
    }

    public function getPrevious()
    {
        $cache = $this->checkCache('previousMatch');

        if (!$cache) {
            $data = Matches::all();

            $this->setCache('previousMatch', $data);
        } else {
            $data = $cache;
        }

        return $data;
    }

    public function getMatchResult($id)
    {
        $cache = $this->checkCache('stream_' . $id);

        if (!$cache) {
            $data = MatchesRecords::where('stream_id', $id)->get();

            $this->setCache('stream_' . $id, $data);
        } else {
            $data = $cache;
        }

        return $data;
    }

    public function getSongList($id, $game)
    {
        $data = SongsLists::where('stream_id', $id)
            ->where('played_at', $game)
            ->get();

        return $data;
    }

    public function rollCards($user, $yubis)
    {

        // 後台確認數字是否正確
        if ($yubis != 5 && $yubis != 50) {
            return json_encode('error');
        }

        // 後台確認是否有足夠手指
        $user = User::where('name', $user)->first();

        if ($user['yubis'] - $yubis < 0) {
            return json_encode('not enough');
        }

        $times = $yubis / 5;

        // 記錄新的結果
        $result['cards'] = $this->getResult($times);

        // 解開舊卡json
        $package = json_decode($user['cards']);

        // 儲存舊卡的紀錄
        $result['old_cards'] = $package;

        // 將舊卡和新卡結果合併
        $new_cards = json_encode(array_merge($package, $result['cards']['id']));

        // 將新結果儲存
        $user['cards'] = $new_cards;

        // 結果計算完畢
        $user['yubis'] -= $yubis;

        // 儲存紀錄
        $user->save();

        // 新舊結果送回前端處理
        return $result;
    }

    public function checkYubis($name)
    {
        $user = User::where('name', $name)->first();

        // 確認每日登入獎勵
        if ($user->remember_token != date("Y/m/d")) {
            $user['yubis'] += 11;
            $res['daily'] = $user->remember_token;
        }
        $user->remember_token = date("Y/m/d");
        $user->save();

        $res['yubis'] = $user['yubis'];
        $res['cards'] = $user['cards'];

        return json_encode($res);
    }

    public function collectYubis($name, $matchId)
    {
        // 抓出使用者與賭局數據
        $user = User::where('name', $name)->first();
        $bet_match = Betting::where('match_id', $matchId)->first();
        $match = MatchesRecords::find($matchId);

        // 防錯, 若沒找到則回覆稍後再試
        if (empty($bet_match)) {
            return 'error';
        }

        $userStake = [];

        // 先找出使用者在賭局中的賭注
        foreach (json_decode($bet_match['users']) as $userRecord) {
            if ($userRecord->id == $user['id']) {
                $userStake['stake'] = $userRecord->bet;
            }
        }


        $betYubis = 0;
        // 找出賭贏的賭注
        foreach ($userStake['stake'] as $stake) {
            if ($match['result'] == $stake->name) {
                $betYubis = $stake->stake * 1;
            }
        }

        // 計算獲得賭金(投注人數 / 總投注人數 *100)


        // dd($betYubis);
    }

    public function colllectionBook($name)
    {
        $user = User::where('name', $name)->first();

        $cards = array_unique(json_decode($user['cards']));

        $book = ['rare' => [], 'SR' => [], 'SSR' => [], 'LEGEND' => []];
        foreach ($cards as $index => $card_id) {
            $card = Roll::find($card_id);

            if ($card) {
                array_push($book[$card['rare']], $card);
            }
        }

        return json_encode($book);
    }

    public function getResult($times)
    {
        $result = ['id' => [], 'detail' => []];
        for ($i = 0; $i < $times; $i++) {
            // rare 90% SR 8% SSR 1.9% UR 0.1%
            $roll_number = rand(1, 1000);

            if ($roll_number >= 100) {
                $rare = Roll::where('rare', '!=', 'SR')->where('rare', '!=', 'LEGEND')->where('rare', '!=', 'SSR')->inRandomOrder()->first();
            } elseif ($roll_number < 80 && $roll_number >= 1) {
                $rare = Roll::where('rare', 'SR')->inRandomOrder()->first();
            } elseif ($roll_number <= 100 && $roll_number <= 81) {
                $rare = Roll::where('rare', 'SSR')->inRandomOrder()->first();
            } else {
                $rare = Roll::where('rare', 'LEGEND')->inRandomOrder()->first();

                $another_roll = rand(1, 1000);

                if ($another_roll == 666) {
                    $rare = Roll::find(666);

                    array_push($result['id'], $rare['id']);
                    array_push($result['detail'], $rare);
                }
            }

            if ($roll_number == 666) {
                $rare = Roll::find(665);
            }

            array_push($result['id'], $rare['id']);
            array_push($result['detail'], $rare);
        }

        return $result;
    }

    public function Betting(Request $request, $name)
    {
        // 將data解析後分別儲存進user並減去yubis的數量, 這邊要再做一次驗證

        // 解析傳入的資料與取得所需資料
        $stake = $request->all();
        $user = User::where('name', $name)->first();

        // 取得賭注總數進行判斷
        $yubis = 0;

        foreach ($stake as $bet) {
            $yubis += (int)$bet['stake'];
        }

        // 驗證手指數
        if ($user['yubis'] - $yubis < 0) {
            return 'not enough';
        }

        // 確認沒問題, 開始尋找當前正在開的賭局進行記錄儲存
        $betting_match = Betting::where('visible', '1')->where('open', '1')->with('match_detail')->first();

        // 防找不到或太慢提交
        if (empty($betting_match)) {
            return 'the betting is closed, please wait for next match';
        }

        // 修改使用者內容
        $user['yubis'] -= $yubis; //改手指
        $user_bet_match = json_decode($user['bet_match']);
        $user_bet_match[count($user_bet_match)] = $betting_match['id']; //紀錄場次json轉回陣列
        $user['bet_match'] = json_encode($user_bet_match); //轉回json後儲存

        // 修改betting資料表中的紀錄
        $bettingData = []; //空物件紀錄所有使用者的賭注紀錄
        $bettingData['id'] = $user['id'];
        $bettingData['bet'] = $stake;
        $usersStake = json_decode($betting_match['users']);
        $usersStake[count($usersStake)] = $bettingData; //json轉回陣列
        $betting_match['users'] = json_encode($usersStake); //使用者賭注紀錄後轉回json儲存
        $betting_match['total_bet'] += $yubis;

        // 作業完成後再儲存
        $user->save();
        $betting_match->save();

        $result = [];
        $result['status'] = 'done';
        $result['yubis'] = $user['yubis'];

        // 剩餘: 將使用者記錄進正常的betting_data, 等完成後台的資料建立後再回來

        return $result;
    }

    public function getBettingRecord($name)
    {
        $user = User::where('name', $name)->first();

        $match_records = [];

        $matches_id = json_decode($user['bet_match']);

        if ($matches_id) {
            foreach ($matches_id as $match_id) {
                $match = Betting::find($match_id)->with('match_detail')->first();

                array_push($match_records, $match['match_detail']);
            }
        } else {
            $match_records = 'none';
        }


        return json_encode($match_records);
    }

    public function ContactUs(Request $request)
    {
        ContactUs::create($request->all());
        return json_encode("thank you! we will check it as soon as posible!");
    }

    public function addSong($stream_id, $game_id, $link)
    {
        $new_song = new SongsLists();
        $new_song->stream_id = $stream_id;
        $new_song->played_at = $game_id;
        $new_song->link = $link;
        $new_song->save();

        return 'succes, please refresh your page!';
    }


    public function checkCache($key)
    {
        if (Cache::has($key)) {
            $data = Cache::get($key);
        } else {
            $data = null;
        }

        return $data;
    }

    public function setCache($key, $value)
    {
        $data = Cache::forever($key, $value);

        return $data;
    }

    public function getPollResult()
    {
        $list = Poll::orderBy('point', 'desc')->get();

        return $list;
    }

    public function changeDB(){
        $matches = MatchesRecords::get();

        // dd($matches);
        foreach($matches as $match){
            // 抓取參賽者, 清除空白, 檢查是否有斜線, 若有則先炸掉斜線再存入
            $participants = $match->participants;

            $cleared = preg_replace('/\s(?=)/', '', $participants);

            if(strpos($cleared,'/') !== false){
                $ary = [];
                $tagTeamAry = explode('/',$cleared);
                foreach($tagTeamAry as $key => $participant){
                    array_push($ary, $participant);
                    $match['participants'] = $ary;
                }
                $match->save();
            }else{
                $ary = [$cleared];
                $match['participants'] = $ary;
                $match->save();
            }
        }
    }
}
