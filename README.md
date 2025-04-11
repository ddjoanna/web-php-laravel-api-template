# web-php-laravel-api-template

## 專案目的

1. 建立一個基於 PHP 框架 Laravel API 應用程式開發模板
2. 統一專案開發架構和提高開發效率(提升可讀性、可維護、可移植、可測試)

## 專案內容

1.  定義一個基本的 API 應用程式結構

    -   Builder
    -   Entity
        -   Props
    -   Exception
    -   Factories
    -   Http
        -   Controllers
        -   Middleware
    -   Interfaces
    -   Models
    -   Providers
    -   Repositories
    -   Service
    -   UseCase
    -   ValueObject

2.  依據結構 自定義 Console 指令，快速創建物件模板

    > 模板在 `stubs` 資料夾中

    -   MakeEntity
        -   創建 Entity Props, Entity, Entity Factory
    -   MakeRepository
        -   CRUD
    -   MakeService
        -   CRUD
    -   MakeUseCase
        -   Request, UseCase, Response
    -   MakeUseCaseFactory
        -   CRUD UseCase Factory
    -   MakeValueObject

3.  實作產品 CRUD API 範例以及相關單元測試
