<?php
namespace vgrigoryev\models;

/**
 * Class AbstractProduct
 * @package vgrigoryev\models
 */
abstract class AbstractProduct implements \JsonSerializable
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var float Ширина, в сантиметрах
     */
    public $width;

    /**
     * @var float Высота, в сантиметрах
     */
    public $height;

    /**
     * Плотность, кг/м2
     */
    protected const DENSITY = 0;

    /**
     * Цена за килограмм
     */
    protected const PRICE_BASE = 0;

    /**
     * Минимальный размер, в сантиметрах
     */
    protected const SIZE_MIN = 0;

    /**
     * Максимальный размер, в сантиметрах
     */
    protected const SIZE_MAX = 0;

    /**
     * Возвращает тип конкретного товара
     *
     * @return string
     */
    public abstract function getType(): string;

    /**
     * Расчитывает площаль в квадратных метрах
     *
     * @return float
     */
    public function getAreaSize(): float
    {
        return $this->width * $this->height / 10000;
    }

    /**
     * Расчитывает вес в киллограммах
     *
     * @return float
     */
    public function getWeight(): float
    {
        return static::DENSITY * $this->getAreaSize();

    }

    /**
     * Рассчитывает стоимость товара
     *
     * @return float
     */
    public function getPrice(): float
    {
        return round(static::PRICE_BASE * $this->getWeight(), 2);
    }

    /**
     * Проверяет, являются ли параметры товара валидными
     *
     * @return boolean
     */
    public function validate(): bool
    {
        $isNumeric = is_numeric($this->width) && is_numeric($this->height);
        $isSuitableWidth = $this->width >= static::SIZE_MIN && $this->width <= static::SIZE_MAX;
        $isSuitableHeight = $this->height >= static::SIZE_MIN && $this->height <= static::SIZE_MAX;

        return $isNumeric && $isSuitableWidth && $isSuitableHeight;
    }

    /**
     * @inheritDoc
     */
    public function __construct($data = null)
    {
        if (isset($data['id'])) {
            $this->id = (int)$data['id'];
        }
        if (isset($data['width'])) {
            $this->width = (float)$data['width'];
        }
        if (isset($data['height'])) {
            $this->height = (float)$data['height'];
        }
    }

    /**
     * @inheritDoc
     */
    function jsonSerialize()
    {
        return [
            'id' => (int)$this->id,
            'type' => $this->getType(),
            'width' => (float)$this->width,
            'height' => (float)$this->height,
            'price' => (float)$this->getPrice(),
        ];
    }


}