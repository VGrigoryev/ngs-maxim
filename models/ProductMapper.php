<?php
namespace vgrigoryev\models;

use Jacwright\RestServer\RestException;
use PDO;
use PDOException;

/**
 * Class ProductMapper
 * @package vgrigoryev\models
 */
class ProductMapper
{
    private $db;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        try {
            $this->db = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            throw new RestException(500, 'Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return AbstractProduct
     */
    public function getById(int $id): ?AbstractProduct
    {
        $stmt = $this->db->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return ProductFactory::create($row['type'], $row);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $products = [];

        $rows = $this->db->query('SELECT * FROM product');
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $products[] = ProductFactory::create($row['type'], $row);
            }
        }

        return $products;
    }

    /**
     * @param AbstractProduct $product
     *
     * @return bool
     */
    public function save(AbstractProduct $product): bool
    {
        if (!$product->id) {
            $stmt = $this->db->prepare('INSERT INTO product (type, width, height) VALUES (:type, :width, :height)');
        } else {
            $stmt = $this->db->prepare('UPDATE product SET type = :type, width = :width, height = :height WHERE id = :id');
            $stmt->bindParam(':id', $product->id);
        }
        $stmt->bindParam(':type', $product->getType());
        $stmt->bindParam(':width', $product->width);
        $stmt->bindParam(':height', $product->height);
        $result = $stmt->execute();

        if (!$product->id && $result) {
            $product->id = (int)$this->db->lastInsertId();
        }

        return $result;
    }
}