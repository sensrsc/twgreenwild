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
        $tour                = new Tour;
        $tour->t_title       = $datas['t_title'] ?? '';
        $tour->t_description = $datas['t_description'] ?? '';
        $tour->t_status      = ($datas['t_status'] && $datas['t_price'] <= 1) ? 0 : 1;
        $tour->t_price       = $datas['t_price'] ?? 1;
        $tour->min_people    = $datas['min_people'] ?? 1;
        $tour->full_people   = $datas['full_people'] ?? 1;
        $tour->days_apply    = $datas['days_apply'] ?? 1;
        $tour->c_id          = $datas['c_id'];
        $tour->area_id       = $datas['area_id'];
        $tour->cl_id         = $datas['cl_id'];
        $tour->a_id          = $datas['a_id'];
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

}
