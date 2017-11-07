<?php
namespace vgrigoryev\models;

/**
 * Class ProductA
 * @package vgrigoryev\models
 */
class ProductA extends AbstractProduct
{
    protected const DENSITY = 0.23;
    protected const PRICE_BASE = 45;
    protected const SIZE_MIN = 60;
    protected const SIZE_MAX = 300;

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return 'a';
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