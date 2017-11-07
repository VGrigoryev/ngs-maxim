<?php
namespace vgrigoryev\models;

/**
 * Class ProductC
 * @package vgrigoryev\models
 */
class ProductC extends AbstractProduct
{
    protected const DENSITY = 0.65;
    protected const PRICE_BASE = 64;
    protected const SIZE_MIN = 10;
    protected const SIZE_MAX = 300;

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return 'c';
    }

    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        if (parent::validate()) {
            return $this->width == $this->height;
        }

        return false;
    }
}