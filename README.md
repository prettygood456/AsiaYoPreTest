## 資料庫測驗
### 題目一答案

```SQL
SELECT
    bnbs.id AS bnb_id,
    bnbs.name AS bnb_name,
    SUM(orders.amount) AS may_amount
FROM
    bnbs
JOIN
    orders ON bnbs.id = orders.bnb_id
WHERE
    orders.currency = 'TWD'
    AND orders.created_at BETWEEN '2023-05-01' AND '2023-05-31' 
GROUP BY
    bnbs.id, bnbs.name
ORDER BY
    may_amount DESC
LIMIT 10;
```

### 題目二答案
遇到 SQL 的性能瓶頸，我們需要先確認問題所在，可以用 `EXPLAIN` 去分析目前的語句有哪些淺在的問題。
根據 `EXPLAIN` 的結果我們可以不斷優化已確保有達到我們的期望目標。

這邊列出我的優化想法：
1. **優化 index**
   
   執行完 `EXPLAIN` 後可以顯示資料庫如何執行查詢，包括使用了哪些 index 、資料表的讀取順序等訊息。
   根據結果去優化 index 來減少查詢時間。

2. **其他優化方案**

   在優化 index 後，如果效能還是不如預期；可以在根據需求去嘗試以下的解決方案
   - 建立 View
     - 查詢語法中有使用 Sum 的聚合語法，如果這段語法是經常執行的；可以考慮將每個月的訂單金額做成 View 來降低查詢時間。
   - 建立分區表
     - 如果資料表非常大，可以考慮使用分區表，根據 created_at 進行分區，這樣可以提高查詢性能，特別是涉及範圍查詢時。
     
## API 實作測驗

這個測驗的功能主要由 Controller、Requests、Rules 完成，底下說明分別對應的 SOLID 原則：

- Controller (OrderController.php) : 

  - 單一職責原則（Single Responsibility Principle, SRP）：

    Controller 負責處理 HTTP 請求和回應，將業務邏輯委派給其他層，保持自身的職責單一
    
  - 開放封閉原則（Open/Closed Principle, OCP）：
    
    Controller 可以通過擴展或委派來支持更多功能，而不需要修改現有的代碼
    
  - 依賴反轉原則（Dependency Inversion Principle, DIP）：
 
    Controller 依賴於抽象（如 StoreOrderRequest 和模型），而不是具體實現，增加了靈活性和可測試性


- Requests (StoreOrderRequest.php) : 

  - 單一職責原則（Single Responsibility Principle, SRP）：
    
    請求驗證類別專注於驗證輸入數據，不涉及其他業務邏輯
    
  - 接口隔離原則（Interface Segregation Principle, ISP）：

    請求驗證類別只實現必要的驗證方法，避免依賴不需要的接口


- Rules (NameRule.php) : 

  - 單一職責原則（Single Responsibility Principle, SRP）：
    
    驗證規則類別專注於特定的驗證邏輯，保持職責單一
    
  - 開放封閉原則（The Open/Closed Principle, OCP）：

    可以通過新增更多驗證規則來擴展功能，而不需要修改現有的規則類別
    
___

### 補充 API 實作測驗的執行指令供作參考

- 運行測驗的 container
```bash
# Build image from dockerfile
docker build -t laravel-app .

# run container
docker run -d -p 8000:8000 --name laravel-app laravel-app
```

- curl 指令執行 Request
```bash
curl --location 'localhost:8000/api/orders' \
--header 'Content-Type: application/json' \
--data '{
    "id": "A0000001",
    "name": "Melody Holiday Inn",
    "address": {
        "city": "taipei-city",
        "district": "da-an-district",
        "street": "fuxing-south-road"
    },
    "price": 200,
    "currency": "TWD"
}'
```

- 執行單元測試
```bash
# 單元測試使用 Table driven testing
# OrderApiTest.php 包含了成功與失敗案例
docker exec -it laravel-app ./vendor/bin/pest
```



