<?php

namespace App\Repositories;

use App\Models\CategoryDescription;

class CategoryDescriptionRepository
{
    protected $model;

    public function __construct(CategoryDescription $model)
    {
        $this->model = $model;
    }

    public function processCategoryDescription($cId, $posts)
    {
        if ($cId) {
            CategoryDescription::where('c_id', $cId)
                ->update(['cd_status' => 2]);
            foreach ($posts['cd_id'] as $index => $cdId) {
                if ($cdId > 0) {
                    $categoryDescription = CategoryDescription::find($cdId);
                } else {
                    $categoryDescription = new CategoryDescription;
                }
                $categoryDescription->c_id      = $cId;
                $categoryDescription->cd_status = 1;
                $categoryDescription->cd_title  = $posts['cd_title'][$index];
                $categoryDescription->cd_type   = $posts['cd_type'][$index];
                $categoryDescription->save();
            }
            return true;
        }

        return false;
    }

    public function getCategoryDescriptions($cId)
    {
    	return CategoryDescription::where('c_id', $cId)
    								->where('cd_status', 1)
    								->get();
    }

    public function getByCategory($cId)
    {
        return $this->model->where('c_id', $cId)
                            ->where('cd_status', 1)
                            ->get(['cd_id', 'cd_title', 'cd_type']);
    }

}
