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
    AND orders.created_at >= '2023-05-01'
    AND orders.created_at < '2023-06-01'
GROUP BY
    bnbs.id, bnbs.name
ORDER BY
    may_amount DESC
LIMIT 10;
```

### 題目二答案

## API 實作測驗
