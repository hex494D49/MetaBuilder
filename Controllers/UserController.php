<?php

class UserController {
    
    private MetaBuilder $metaBuilder;
    private array $userData;
    private int $totalRecords;
    private int $pageSize;
    private int $currentPage;

    public function __construct() {
        $this->metaBuilder = new MetaBuilder(['User']);
        $metadataJson = $this->metaBuilder->buildJsonStructure();
        echo "MetaBuilder Output: " . $metadataJson;  // Debug output
        $metadata = json_decode($metadataJson, true);

        // Make sure you are accessing the correct keys
        $this->propertiesMetadata = $metadata['User']['properties'] ?? [];
        $this->userData = $this->fetchUserData();
        $this->totalRecords = 498;  
        $this->pageSize = 5;
        $this->currentPage = 1;
    }

    private function fetchUserData(): array {
        // Simulated data fetch
        return [
            ['id' => 1, 'firstName' => 'Madilyn', 'lastName' => 'Fritsch', 'email' => 'madilyn.fritsch@hotmail.com', 'dateAdded' => '2024-03-17 09:09', 'lastModified' => '2024-04-02 22:36'],
            ['id' => 2, 'firstName' => 'Maximo', 'lastName' => 'Pouros', 'email' => 'maximo.pouros@yahoo.com', 'dateAdded' => '2024-03-17 09:10', 'lastModified' => '2024-03-24 21:28'],
            // Add more users as needed...
        ];

    }

    public function getUserJson(): string {
        $response = [
            "endpoint" => "api/users",
            "columns" => $this->propertiesMetadata,  
            "data" => $this->userData,
            "pager" => [
                "totalCount" => $this->totalRecords,
                "pageSize" => $this->pageSize,
                "currentPage" => $this->currentPage
            ]
        ];

        return json_encode($response, JSON_PRETTY_PRINT);
    }
}


