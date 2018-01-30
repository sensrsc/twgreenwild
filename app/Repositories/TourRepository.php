<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\CategoryLevel;
use App\Models\Album;
use App\Models\Area;
use App\Models\Tour;


class TourRepository
{
    protected $model;
    
    public function __construct(Tour $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $tour = new Tour;
        $tour->c_title = $datas['c_title'] ?? '';
        $tour->c_file = $datas['c_file'] ?? '';
        $tour->c_status = $datas['c_status'] ?? 1;
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
                if (strpos($field, 'title') !== false) {
                    $query->where($field, "LIKE", '%'.$search.'%');
                } else if ($search) {
                    $query->where($field, $search);
                }
            }
        }

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
    }

    // category
    public function getCategorys()
    {
        return Category::where('c_status', 1)
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
