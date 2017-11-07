<?php
namespace vgrigoryev\models;

/**
 * Class ProductB
 * @package vgrigoryev\models
 */
class ProductB extends AbstractProduct
{
    protected const DENSITY = 0.36;
    protected const PRICE_BASE = 82;
    protected const SIZE_MIN = 10;
    protected const SIZE_MAX = 200;

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return 'b';
    }

    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        if (parent::validate()) {
            return ($this->width * 2 / 3 == $this->height) || ($this->width == $this->height * 2 / 3);
        }

        return false;
    }
}