<?php
namespace vgrigoryev\models;

use Jacwright\RestServer\RestException;

/**
 * Class ProductFactory
 * @package vgrigoryev\models
 */
class ProductFactory
{
    /**
     * @param string $type
     * @param array|null $data
     * @return AbstractProduct
     * @throws RestException
     */
    static public function create(string $type, array $data = null): AbstractProduct
    {
        switch ($type) {
            case 'a':
                return new ProductA($data);
                break;
            case 'b':
                return new ProductB($data);
                break;
            case 'c':
                return new ProductC($data);
                break;
            default:
                throw new RestException(500, 'Неизвестный тип товара.');
        }
    }
}