<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\GameRespinTemplate;
use DB;
use Illuminate\Support\Facades\Cache;

class Gameslist extends Eloquent  {

    protected $table = 'wainwright_gameslist';
    protected $timestamp = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'gid',
        'gid_extra',
        'batch',
        'slug',
        'name',
        'provider',
        'type',
        'typeRating',
        'popularity',
        'bonusbuy',
        'jackpot',
        'demoplay',
        'demolink',
        'origin_demolink',
        'source',
        'source_schema',
        'realmoney',
        'method',
        'image',
    ];

    protected $casts = [
        'active' => 'boolean',
        'realmoney' => 'json',
        'rawobject' => 'json',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function short_list() {
        if(config('casinodog.data_caching')) {

            $value = Cache::remember('gameslist:shortlist', 180, function () {
                $list = self::short_list_function();
                if($list === '[]') {
                    Cache::pull('gameslist:shortlist');
                    return $list;
                }
            });
            return $value;
        } else {
            return self::short_list_function();
        }
    }

    public static function short_list_function()
    {
        if(Gameslist::count() < 1) {
            return '[]';
        }        

        $query = Gameslist::all();
        $provider = collect(self::provider_list());
        foreach($query as $game) {
            $provider_info = $provider->where('pid', $game['provider'])->first();
            $game_array = array(
                'name' => $game['name'],
                'gid' => $game['gid'],
                'gid_extra' => $game['gid_extra'],
                'slug' => $game['slug'],
                'demolink' => $game['demolink'],
                'origin_demolink' => $game['origin_demolink'],
                'provider' => $game['provider'],
                'cached_at' => now_nice(),
                'respin_templates' => GameRespinTemplate::count_game_template_gid($game['gid']),
                'active' => $game['active'],
            );
            if($provider_info['fake_iframe_url']) {
                $fake_iframe_prefix = array('fake_iframe_url' => gameclass($game['provider'])->fake_iframe_url($game['slug'], 'USD'));
                array_push($fake_iframe_prefix, $game_array);
            }

            $shortlist_array[] = $game_array; 

        }
        return $shortlist_array;
    }

    public static function provider_list()
    {
        if(config('casinodog.data_caching')) {
            $value = Cache::remember('providerlist:shortlist', 15, function () {
                return self::provider_list_function();
            });
            return $value;
        } else {
            return self::provider_list_function();
        }
    }

    public static function provider_list_function()
    {
        $query = collect(Gameslist::distinct()->get('provider'));

        foreach($query as $provider) {
                if(config('casinodog.games.'.$provider['provider']) !== NULL) {
                    $provider_array[] = array(
                        'pid' => $provider['provider'],
                        'name' => config('casinodog.games.'.$provider['provider'].'.name'),
                        'new_api_endpoint' => config('casinodog.games.'.$provider['provider'].'.name'),
                        'fake_iframe_url' => (boolean) config('casinodog.games.'.$provider['provider'].'.fake_iframe_url'),
                        'launcher_behaviour' => config('casinodog.games.'.$provider['provider'].'.launcher_behaviour'),
                        'cached_at' => now_nice(),
                        'active' => (boolean) config('casinodog.games.'.$provider['provider'].'.active'),
                    );
                } else {
                    $provider_array[] = array(
                        'pid' => $provider['provider'],
                        'name' => ucfirst($provider['provider']),
                        'new_api_endpoint' => NULL,
                        'fake_iframe_url' => false,
                        'launcher_behaviour' => NULL,
                        'cached_at' => now_nice(),
                        'active' => false,
                    );
                }
        }
        return $provider_array;
    }    
}

