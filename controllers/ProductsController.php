<?php
namespace vgrigoryev\controllers;

use Jacwright\RestServer\RestException;
use vgrigoryev\models\AbstractProduct;
use vgrigoryev\models\ProductMapper;
use vgrigoryev\models\ProductFactory;

/**
 * Class ProductsController
 * @package vgrigoryev\controllers
 */
class ProductsController
{
    private $pm;

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->pm = new ProductMapper();
    }

    /**
     * Возвращает товар по идентификатору
     *
     * @url GET /products/$id
     *
     * @param int $id
     * @return null|AbstractProduct
     * @throws RestException
     */
    public function getProduct(int $id)
    {
        $product = $this->pm->getById($id);

        if (!$product) {
            throw new RestException(404, 'Товар не найден.');
        }

        return $product;
    }

    /**
     * Возвращает список товаров
     *
     * @url GET /products
     */
    public function getProductList()
    {
        $products = $this->pm->getList();

        return $products;
    }

    /**
     * Сохраняет товар в базу данных
     *
     * @url POST /products
     * @url PUT /products/$id
     *
     * @param int|null $id
     * @param mixed $data
     * @return AbstractProduct
     * @throws RestException
     */
    public function saveProduct(int $id = null, $data)
    {
        if (isset($data->type)) {
            $product = ProductFactory::create($data->type, ['id' => $id]);
        } else {
            throw new RestException(422, 'Товар должен иметь тип `a`, `b` или `c`.');
        }

        $product->width = (float)$data->width;
        $product->height = (float)$data->height;

        if ($product->validate()) {
            if ($this->pm->save($product)) {
                return $product;
            } else {
                throw new RestException(422, 'Не удалось сохранить данные.');
            }
        } else {
            throw new RestException(422, 'Переданы некорректные данные.');
        }
    }
}