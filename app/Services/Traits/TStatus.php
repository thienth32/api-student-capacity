<?php

namespace App\Services\Traits;

use App\Services\Traits\TResponse;

trait TStatus
{
    use TResponse;

    public function un_status($id)
    {
        try {
            $data = $this->updateStatus($this->getModelDataById($id), 0);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            dump($th);
            return $this->responseApi(false, $th);
            return $this->responseApi(false, 'Không thể câp nhật trạng thái !');
        }
    }

    public function re_status($id)
    {
        try {
            $data = $this->updateStatus($this->getModelDataById($id), 1);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, 'Không thể câp nhật trạng thái !');
        }
    }

    private function updateStatus($data, $status)
    {
        $data->update([
            'status' => $status,
        ]);
        return $data;
    }

    public function un_hot($id)
    {
        try {
            $data = $this->updateHot($this->getModelDataById($id), 0);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, 'Không thể câp nhật trạng thái !');
        }
    }
    public function re_hot($id)
    {
        try {
            $data = $this->updateHot($this->getModelDataById($id), 1);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, 'Không thể câp nhật trạng thái !');
        }
    }
    private function updateHot($data, $status)
    {
        $data->update([
            'hot' => $status,
        ]);
        return $data;
    }

    public function un_full_recruitment($id)
    {
        try {
            $data = $this->updateFullRecruitment($this->getModelDataById($id), 0);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, 'Không thể câp nhật trạng thái !');
        }
    }
    public function re_full_recruitment($id)
    {
        try {
            $data = $this->updateFullRecruitment($this->getModelDataById($id), 1);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, 'Không thể câp nhật trạng thái !');
        }
    }
    private function updateFullRecruitment($data, $status)
    {
        if ($data->postable_type == \App\Models\Recruitment::class) {
            $data->update([
                'full_recruitment' => $status,
            ]);

            return $data;
        }

        return $this->responseApi(false, 'Loại bài viết không hợp lệ');
        
    }
}
