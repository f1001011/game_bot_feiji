<?php

namespace app\model;

class UserDataModel extends BaseModel
{
    public $table = 'tg_user_data';



    public function setUpdate($map = [], $data = [])
    {
        //$data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if (empty($data)){
            $this->update($data);
        }
        return $this->where($map)->update($data);
    }

    public function setInsert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->insertGetId($data);
    }

}
