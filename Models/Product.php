<?php

class Product {
    #[Sortable, Searchable]
    #[ValidationRules(required: true)]
    public int $id;

    #[Sortable, Searchable]
    #[ValidationRules(maxLength: 100)]
    public string $name;

    #[Sortable, Searchable]
    #[ValidationRules(minValue: 0.01, maxValue: 10000.00)]
    public float $price;

    #[Sortable]
    #[ValidationRules(maxLength: 255, allowedFileTypes: ['jpg', 'png', 'gif'], maxFileSize: 1048576)] // 1MB max file size
    public string $image;
}