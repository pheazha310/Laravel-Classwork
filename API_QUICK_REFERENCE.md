# Product CRUD API - Quick Reference

## 📌 Base URL
```
http://127.0.0.1:8000/api
```

## 🔌 Endpoints

### 1️⃣ Get All Products
```
GET /products
```
- Returns all products with embedded category data
- **Status**: 200
- **Body**: None

### 2️⃣ Get Single Product
```
GET /products/{id}
```
- Returns single product with category
- **Status**: 200
- **Params**: id (path)

### 3️⃣ Create Product
```
POST /products
```
- Create new product with optional image
- **Status**: 201
- **Content-Type**: multipart/form-data
- **Fields**:
  - `category_id` (required, integer) - must exist in categories
  - `name` (required, string, max 255)
  - `price` (required, float) - min: 0
  - `stock` (required, integer) - min: 0
  - `is_active` (optional, boolean)
  - `image` (optional, file) - jpeg|png|jpg|gif, max 2MB

### 4️⃣ Update Product
```
PUT /products/{id}
```
- Update product fields (partial updates allowed)
- **Status**: 200
- **Content-Type**: multipart/form-data
- **Params**: id (path)
- **Fields**: All optional, same as create

### 5️⃣ Delete Product
```
DELETE /products/{id}
```
- Delete product and remove image file
- **Status**: 200
- **Params**: id (path)

---

## ✅ Validation Rules

| Field | Required | Type | Max | Min | Notes |
|-------|----------|------|-----|-----|-------|
| category_id | Yes | Integer | - | - | Must exist in categories table |
| name | Yes | String | 255 | - | Product name |
| image | No | File | 2MB | - | jpeg, png, jpg, gif |
| price | Yes | Decimal | - | 0 | Product price |
| stock | Yes | Integer | - | 0 | Quantity available |
| is_active | No | Boolean | - | - | Default: true |

---

## 📤 Example Requests

### Create with Image
```bash
curl -X POST http://127.0.0.1:8000/api/products \
  -F "category_id=1" \
  -F "name=MacBook Pro M3" \
  -F "price=1999.99" \
  -F "stock=14" \
  -F "is_active=1" \
  -F "image=@/path/to/image.jpg"
```

### Update Product
```bash
curl -X PUT http://127.0.0.1:8000/api/products/1 \
  -F "name=Updated Name" \
  -F "stock=20"
```

### Get All Products
```bash
curl http://127.0.0.1:8000/api/products
```

---

## 📋 Response Formats

### Success (Create/Update/Show)
```json
{
  "success": true,
  "data": {
    "id": 1,
    "category_id": 2,
    "name": "Product Name",
    "image": "products/filename.png",
    "image_url": "http://127.0.0.1:8000/storage/products/filename.png",
    "price": 1999.99,
    "stock": 14,
    "is_active": true,
    "created_at": "2026-06-12T08:07:11.000000Z",
    "updated_at": "2026-06-12T08:07:11.000000Z",
    "category": {
      "id": 2,
      "name": "Laptop",
      "description": "Description",
      "is_active": true
    }
  }
}
```

### Success (List)
```json
{
  "success": true,
  "data": [
    { /* product 1 */ },
    { /* product 2 */ }
  ]
}
```

### Success (Delete)
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

### Error (Validation - 422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "price": ["The price field is required."],
    "category_id": ["The category_id field must exist in the categories table."]
  }
}
```

---

## 🚀 Quick Test Commands

```bash
# Get all products
curl http://127.0.0.1:8000/api/products | jq

# Get product #1
curl http://127.0.0.1:8000/api/products/1 | jq

# Create product (will fail - missing fields)
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{"name":"Test"}' | jq

# Test validation error
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "category_id": 1,
    "name": "Test",
    "price": -10,
    "stock": 5
  }' | jq
```

---

## 📦 Type Casting

Products are returned with proper JSON types:
- `price`: **float** (e.g., 1999.99)
- `stock`: **integer** (e.g., 14)
- `is_active`: **boolean** (e.g., true)
- `id`: **integer**
- `category_id`: **integer**

---

## 🔗 Related Files

- **Postman Collection**: `Product_CRUD_API.postman_collection.json`
- **Implementation Guide**: `IMPLEMENTATION_GUIDE.md`
- **Full README**: `README_PRODUCT_API.md`
- **Test Suite**: `comprehensive_test.php`

---

## ⚡ Key Points

✅ Returns 422 for validation errors
✅ Images stored in public/storage/products/
✅ Category relationship always embedded
✅ File upload/deletion handled automatically
✅ Proper HTTP status codes (200, 201, 422, 404, 500)
✅ All responses have "success" flag
✅ Virtual image_url field for absolute URLs

---

**Last Updated**: 2026-06-12
