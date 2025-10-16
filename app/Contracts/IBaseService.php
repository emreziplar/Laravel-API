<?php

namespace App\Contracts;


use App\DTO\Contracts\IDTO;

/**
 * @template TDTO of \App\DTO\IDTO
 */
interface IBaseService
{

    /**
     * @param array $data
     * @return TDTO
     */
    public function create(array $data): IDTO;

    /**
     * @param array $fields
     * @return TDTO
     */
    public function get(array $fields): IDTO;

    /**
     * @param int $id
     * @param array $data
     * @return TDTO
     */
    public function update(int $id, array $data): IDTO;

    /**
     * @param int $id
     * @return TDTO
     */
    public function delete(int $id): IDTO;
}
