<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Area;
use App\Models\Category;
use App\Models\CategoryLevel;
use App\Models\Tour;
use App\Models\TourDescription;
use Schema;

class TourRepository
{
    protected $model;

    public function __construct(Tour $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $tour                   = new Tour;
        $tour->t_title          = $datas['t_title'] ?? '';
        $tour->t_description    = $datas['t_description'] ?? '';
        $tour->t_status         = ($datas['t_status'] && $datas['t_price'] <= 1) ? 0 : $datas['t_status'];
        $tour->t_price          = $datas['t_price'] ?? 1;
        $tour->t_weekday_price  = $datas['t_weekday_price'] ?? 1;
        $tour->t_discount_price = $datas['t_discount_price'] ?? 1;
        $tour->min_people       = $datas['min_people'] ?? 1;
        $tour->full_people      = $datas['full_people'] ?? 1;
        $tour->days_apply       = $datas['days_apply'] ?? 1;
        $tour->c_id             = $datas['c_id'];
        $tour->area_id          = $datas['area_id'];
        $tour->cl_id            = $datas['cl_id'];
        $tour->a_id             = $datas['a_id'];
        $tour->save();

        return $tour->t_id;
    }

    public function update($id, $datas)
    {
        $data = $this->getByID($id);
        if ($data) {
            $data->fill($datas);
            return $data->save();
        }
        return false;
    }

    public function getByID($id)
    {
        return $this->model->find($id);
    }

    public function pages($rows, $queryData)
    {
        $query = $this->model->query();

        if ($queryData) {
            foreach ($queryData as $field => $search) {
                $isHave = Schema::hasColumn($this->model->getTable(), $field);
                if ($isHave) {
                    if (strpos($field, 'title') !== false) {
                        $query->where($field, "LIKE", '%' . $search . '%');
                    } else if ($search) {
                        $query->where($field, $search);
                    }
                }
            }
        }

        $query->where('t_status', '=', 1);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }

    public function processTourDescriptions($tId, $posts)
    {
        if ($tId) {
            TourDescription::where('t_id', $tId)
                ->update(['td_status' => 2]);
            foreach ($posts['td_id'] as $index => $tdId) {
                if ($tdId > 0) {
                    $tourDescription = TourDescription::find($tdId);
                } else {
                    $tourDescription = new TourDescription;
                }
                $tourDescription->t_id       = $tId;
                $tourDescription->cd_id      = $posts['cd_id'][$index];
                $tourDescription->td_content = $posts['td_content'][$index];
                $tourDescription->td_status  = 1;
                $tourDescription->save();
            }
            return true;
        }

        return false;
    }

    // category
    public function getCategorys()
    {
        return Category::where('c_status', 1)
            ->get();
    }

    // category level
    public function getLevelByCategory($cId)
    {
        return CategoryLevel::where('c_id', $cId)
            ->where('cl_status', 1)
            ->get();
    }

    // album
    public function getAlbumByCategory($cId)
    {
        return Album::where('c_id', $cId)
            ->where('a_status', 1)
            ->get();
    }

    // area
    public function getAreas()
    {
        return Area::get(['area_id', 'area_name']);
    }

    public function countRecommend($type)
    {
        $column = ($type == 'hot')? 'hot_flag' : 'season_flag';
        return Tour::where($column, 1)->where('t_status', 1)->count();
    }

    public function getByRecommend($type)
    {
        $column = ($type == 'hot')? 'hot_flag' : 'season_flag';
        return Tour::where($column, 1)->where('t_status', 1)
                // ->with(['area', 'album.cover', 'category'])
                ->get();
    }

    public function getByRecommendJoin($type)
    {
        $column = ($type == 'hot')? 'tour.hot_flag' : 'tour.season_flag';
        $sectionTitle = ($type == 'hot')? '熱門活動' : '季節推薦';
        $tours = $this->model->where($column, 1)
                    ->where('tour.t_status', 1)
                    ->join('category', 'tour.c_id', '=', 'category.c_id')
                    ->join('album', 'tour.a_id', '=', 'album.a_id')
                    ->join('area', 'tour.area_id', '=', 'area.area_id')
                    ->join('album_picture', 'album.a_cover', '=', 'album_picture.ap_id')
                    ->select(['tour.t_id as id', 'tour.t_title as title', 'category.c_title as type', 'album_picture.a_id', 'album_picture.ap_image as cover', 'tour.t_price as price', 'area.area_name as region'])->get();
        $tours = $tours->map(function($tour){
            $tour->cover = '/upload/picture/' . $tour->a_id . '/' . $tour->cover;
            $tour->price = number_format($tour->price);
            return $tour;
        });

        return ['section_title' => '季節推薦', 'activities' => $tours->toArray()];
    }

}
