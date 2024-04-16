<?php

#[Attribute]
class Sortable {
    public function __construct(public bool $enabled = true) {}
}

#[Attribute]
class Searchable {
    public function __construct(public bool $enabled = true) {}
}

#[Attribute]
class ValidationRules {
    public function __construct(
        public ?int $maxLength = null,
        public ?int $minLength = null,
        public ?string $regex = null,
        public ?array $allowedValues = null,
        public bool $required = false,
        public ?string $uniqueTable = null,
        public ?string $uniqueField = null,
        public ?int $minValue = null,
        public ?int $maxValue = null,
        public ?bool $notNull = false,
        public ?int $maxFileSize = null,
        public ?array $allowedFileTypes = null,
        public ?string $lessThan = null,
        public ?string $greaterThan = null,
        public ?string $lessThanDate = null,
        public ?string $greaterThanDate = null,
        public ?string $dataType = null
    ) {} 
} 