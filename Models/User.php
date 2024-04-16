<?php

class User {
    #[Sortable, Searchable, ValidationRules(dataType: "integer")]
    public int $id;

    #[Sortable, Searchable, ValidationRules(dataType: "string", maxLength: 50)]
    public string $firstName;

    #[Sortable, Searchable, ValidationRules(maxLength: 50)]
    public string $lastName;

    #[Sortable, ValidationRules(required: true, uniqueTable: "users", uniqueField: "email", regex: "/^\S+@\S+\.\S+$/")]
    public string $email;

    #[Sortable]
    public DateTime $dateAdded;

    #[Sortable, ValidationRules(greaterThanDate: "2024-01-01")]
    public ?DateTime $lastModified;

    #[ValidationRules(minLength: 8, maxLength: 20, regex: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z\\d]{8,}$/")]
    public string $password;

    #[ValidationRules(minValue: 18, maxValue: 120)]
    public int $age;

    #[ValidationRules(maxFileSize: 1048576, allowedFileTypes: ['jpg', 'png', 'gif'])]  // 1MB max file size
    public ?string $profilePicture;

    #[ValidationRules(required: true, notNull: true)]
    public string $username;
}
