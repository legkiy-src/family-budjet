<?php


namespace App\Services;


class BaseService
{
    private int $userId;

    protected function getUserId(): int
    {
        if (empty($this->userId)) {
            $this->userId = auth()->user()->id;
        }

        return $this->userId;
    }
}
