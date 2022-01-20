<?php

namespace App\Http\Controllers\api;

use App\Models\News;
use App\Models\Banners;
use App\Models\Matches;
use App\Models\Profiles;
use App\Models\Generations;
use App\Models\WrestlerData;
use Illuminate\Http\Request;
use App\Models\MatchesRecords;
use App\Http\Controllers\Controller;
use App\Models\Fanbases;
use App\Models\Outfits;
use App\Models\SongsLists;
use stdClass;

class PagesController extends Controller
{
    public function getBackground()
    {
        $data = Banners::find(1);

        return $data;
    }

    public function getIndexNews()
    {
        $data = News::orderBy('sort', 'desc')->orderBy('id', 'desc')->take(3)->get();

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
        $data = Profiles::with('gens')->get();
        return $data;
    }

    public function getDetail($name)
    {
        $data = Profiles::where('name_short', $name)->with('gens')->with('detail')->with('clips')->first();
        $data['outfits'] = Outfits::where('name_short',$data['name_short'])->get();
        return $data;
    }

    public function getFanbase($name)
    {
        $data = [];
        $data['data'] = Fanbases::where('fan_name', $name)->first();

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

        return $data;
    }

    public function Profiles($gen)
    {
        if ($gen == 'all')
            $data = Profiles::all();
        else {
            $data = Profiles::where('generations_id', $gen)->get();
        }


        return json_encode($data);
    }

    public function getNews($type)
    {
        if ($type == 'All') $data = News::all();
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

        $data = Matches::all();

        return $data;
    }

    public function getMatchResult($id)
    {
        $data = MatchesRecords::where('stream_id', $id)->get();

        return $data;
    }

    public function getSongList($id,$game)
    {
        $data = SongsLists::where('stream_id', $id)
                            ->where('played_at', $game)
                            ->get();

        return $data;
    }

    public function addSong($stream_id, $game_id, $link)
    {
        $new_song = New SongsLists();
        $new_song->stream_id = $stream_id;
        $new_song->played_at = $game_id;
        $new_song->link = $link;
        $new_song->save();

        return 'succes, please refresh your page!';
    }

    // public function changeDB(){
    //     $matches = MatchesRecords::get();

    //     // dd($matches);
    //     foreach($matches as $match){
    //         // 抓取參賽者, 清除空白, 檢查是否有斜線, 若有則先炸掉斜線再存入
    //         $participants = $match->participants;

    //         $cleared = preg_replace('/\s(?=)/', '', $participants);

    //         if(strpos($cleared,'/') !== false){
    //             $ary = [];
    //             $tagTeamAry = explode('/',$cleared);
    //             foreach($tagTeamAry as $key => $participant){
    //                 array_push($ary, $participant);
    //                 $match['participants'] = $ary;
    //             }
    //             $match->save();
    //         }else{
    //             $ary = [$cleared];
    //             $match['participants'] = $ary;
    //             $match->save();
    //         }
    //     }
    // }
}
