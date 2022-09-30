<?php

namespace App\Services\Traits;

use App\Services\Traits\TResponse;

trait TStatus
{
    use TResponse;

    /**
     * Note
     * public function getModelDataStatus($id)
     * {
     *      return $this->model->find($id);
     * }
     */

    public function un_status($id)
    {
        try {
            $data = $this->updateStatus($this->getModelDataStatus($id), 0);
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
            $data = $this->updateStatus($this->getModelDataStatus($id), 1);
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

    /**
     * Note
     * dùng cho recruitment và post hoặc có trạng thái nổi bật .
     * public function getModelDataHot($id)
     * {
     *      return $this->model->find($id);
     * }
     */

    public function un_hot($id)
    {
        try {
            $data = $this->updateHot($this->getModelDataHot($id), 0);
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, 'Không thể câp nhật trạng thái !');
        }
    }
    public function re_hot($id)
    {
        try {
            $data = $this->updateHot($this->getModelDataHot($id), 1);
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
}
