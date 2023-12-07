sudo make - для запуска проекта
контейнеры:
    localenv-app-1
    localenv-nginx-1
    localenv-postgres-1

В БД автоматически будут добавлены сущности. Увидеть их можно в migrations/Version20231207110338.php

Запросы к api доступны в коллекции Postman (New Collection.postman_collection)

Описание методов cURL

резервирование товаров:
    Запрос:
        curl --location 'http://localhost:8080/warehouse/manager/reserve-products' \
        --header 'Content-Type: application/json' \
        --data '{
        "listOfProducts": ["dfjshsdfsdffsjh13123", "dfjshfsdfsdfjh13123sd"],
        "warehouseId":2
        }'
    
    Ответ:
        {"status":"success"}

подсчет количества товаров:
    Запрос:
        curl --location 'http://localhost:8080/warehouse/manager/remaining-products/' \
        --header 'Content-Type: application/json' \
        --data '{
        "warehouseId":2
        }'

    Ответ:
        {"status":"success","count_remaining_products":2}

освобождение резерва
    Запрос:
        curl --location 'http://localhost:8080/warehouse/manager/release-reserved-products' \
        --header 'Content-Type: application/json' \
        --data '{
        "listOfProducts": ["dfjshfsdfsdfjh13123sd"]
        }'
    
    Ответ:
        {"status":"success"}

