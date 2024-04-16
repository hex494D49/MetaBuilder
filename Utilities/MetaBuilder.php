<?php

class MetaBuilder {
    private array $classMetadata = [];

    public function __construct(string $className) {
        if (class_exists($className)) {
            $this->reflectClass(new ReflectionClass($className));
        } else {
            throw new Exception("Class {$className} not found.");
        }
    }

    private function reflectClass(ReflectionClass $reflectionClass) {
        $properties = $reflectionClass->getProperties();
        $columns = array_map([$this, 'extractPropertyMetadata'], $properties);

        // Storing class metadata under the class name key
        $this->classMetadata = [
            'properties' => $columns
        ];
    }

    private function extractPropertyMetadata(ReflectionProperty $property): array {
        $type = $property->getType();
        $dataType = $type ? match ($type->getName()) {
            'int' => 'int',
            'string' => 'string',
            'DateTime' => 'timestamp',
            default => 'string',
        } : 'mixed';

        $isSortable = !empty($property->getAttributes(Sortable::class));
        $isSearchable = !empty($property->getAttributes(Searchable::class));

        $validationAttributes = $property->getAttributes(ValidationRules::class);
        $validationInfo = $this->processValidationAttributes($validationAttributes);

        return [
            'name' => $property->getName(),
            'dataType' => $dataType,
            'isSortable' => $isSortable,
            'isSearchable' => $isSearchable,
            'validation' => $validationInfo
        ];
    }

    private function processValidationAttributes(array $validationAttributes): array {
        if (empty($validationAttributes)) {
            return [];
        }

        $attributeInstance = $validationAttributes[0]->newInstance();
        $validationInfo = [
            'maxLength' => $attributeInstance->maxLength ? [
                'value' => $attributeInstance->maxLength,
                'message' => "Maximum length of {$attributeInstance->maxLength} characters."
            ] : null,
            'minLength' => $attributeInstance->minLength ? [
                'value' => $attributeInstance->minLength,
                'message' => "Minimum length of {$attributeInstance->minLength} characters."
            ] : null,
            'minValue' => $attributeInstance->minValue ? [
                'value' => $attributeInstance->minValue,
                'message' => "Minimum value of {$attributeInstance->minValue}."
            ] : null,
            'maxValue' => $attributeInstance->maxValue ? [
                'value' => $attributeInstance->maxValue,
                'message' => "Maximum value of {$attributeInstance->maxValue}."
            ] : null,
            'required' => $attributeInstance->required ? [
                'value' => true,
                'message' => "This field is required."
            ] : null,
            'lessThan' => $attributeInstance->lessThan ? [
                'value' => $attributeInstance->lessThan,
                'message' => "Value must be less than {$attributeInstance->lessThan}."
            ] : null,
            'greaterThan' => $attributeInstance->greaterThan ? [
                'value' => $attributeInstance->greaterThan,
                'message' => "Value must be greater than {$attributeInstance->greaterThan}."
            ] : null,
            'lessThanDate' => $attributeInstance->lessThanDate ? [
                'value' => $attributeInstance->lessThanDate,
                'message' => "Date must be before {$attributeInstance->lessThanDate}."
            ] : null,
            'greaterThanDate' => $attributeInstance->greaterThanDate ? [
                'value' => $attributeInstance->greaterThanDate,
                'message' => "Date must be after {$attributeInstance->greaterThanDate}."
            ] : null,     
            'range' => $attributeInstance->minValue !== null && $attributeInstance->maxValue !== null ? [
                'min' => $attributeInstance->minValue,
                'max' => $attributeInstance->maxValue,
                'message' => "Value must be between {$attributeInstance->minValue} and {$attributeInstance->maxValue}."
            ] : null,                               
            'allowedFileTypes' => $attributeInstance->allowedFileTypes ? [
                'types' => $attributeInstance->allowedFileTypes,
                'message' => "Allowed file types are: " . implode(", ", $attributeInstance->allowedFileTypes) . "."
            ] : null,
            'maxFileSize' => $attributeInstance->maxFileSize ? [
                'value' => $attributeInstance->maxFileSize,
                'message' => "Maximum file size is {$attributeInstance->maxFileSize} bytes."
            ] : null,
            'dataType' => $attributeInstance->dataType ? [
                'type' => $attributeInstance->dataType,
                'message' => "Data type must be a valid {$attributeInstance->dataType}."
            ] : null,      
            'notNull' => $attributeInstance->notNull ? [
                'value' => true,
                'message' => "This field cannot be null."
            ] : null,
        ];

        return array_filter($validationInfo);
    }

    public function buildJsonStructure(): string {
        $json = json_encode($this->classMetadata, JSON_PRETTY_PRINT);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return json_last_error_msg();
        }
        return $json;
    }
}


