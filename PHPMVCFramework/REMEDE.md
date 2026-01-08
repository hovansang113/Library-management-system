# 📚 PHPMVCFramework - Hướng Dẫn Chi Tiết

## 🚀 Các Công Nghệ & Công Cụ Cần Thiết

- **Composer**: Dùng để tải và quản lý các thư viện, cũng như tự động nạp các class thông qua autoload mà không cần `require` thủ công.

---

## 🏗️ KIẾN TRÚC MVC FRAMEWORK

### Cấu trúc thư mục và vai trò:

```
PHPMVCFramework/
├── public/
│   └── index.php          ← ENTRY POINT (Điểm vào của ứng dụng)
├── core/                  ← NHÂN CỦA FRAMEWORK
│   ├── Application.php    ← Điều phối Request/Response
│   ├── Router.php         ← Xử lý routing & render view
│   ├── Request.php        ← Lấy dữ liệu từ HTTP request
│   ├── Response.php       ← Quản lý HTTP response
│   ├── Controller.php     ← Base Controller (cha của tất cả controllers)
│   └── Model.php          ← Base Model (cha của tất cả models)
├── controllers/           ← LOGIC ỨNG DỤNG
│   ├── AuthController.php ← Xử lý login, register
│   └── SiteController.php ← Xử lý home, contact
├── model/                 ← DỮ LIỆU & VALIDATION
│   └── RegisterModel.php  ← Model cho đăng ký
├── view/                  ← GIAO DIỆN NGƯỜI DÙNG
│   ├── home.php
│   ├── login.php
│   ├── register.php
│   ├── contact.php
│   └── layouts/           ← Các template chứa {{content}}
│       ├── main.php       ← Layout mặc định
│       └── auth.php       ← Layout cho trang auth
└── vendor/                ← Thư viện Composer
```

---

## 📖 CHI TIẾT CÁC THÀNH PHẦN

### 1. **core/Application.php** - Điều Phối Toàn Bộ Hệ Thống
- **Vai trò**: Liên kết tất cả các thành phần (Router, Request, Response, Controller)
- **Constructor**: Khởi động toàn bộ hệ thống MVC ngay khi tạo đối tượng Application
- **Thuộc tính chính**:
  - `$ROOT_DIR`: Lưu đường dẫn gốc của ứng dụng
  - `$router`: Đối tượng Router để quản lý routes
  - `$request`: Đối tượng Request để lấy dữ liệu HTTP
  - `$response`: Đối tượng Response để quản lý response
  - `$controller`: Controller hiện tại đang được sử dụng
- **Phương thức chính**: `run()` - Gọi `$router->resolve()` để xử lý request

### 2. **core/Request.php** - Lấy Dữ Liệu HTTP
- **Vai trò**: Xác định URL, HTTP method, lấy dữ liệu từ form
- **Phương thức chính**:
  - `getPath()`: Lấy URI từ `$_SERVER['REQUEST_URI']`
  - `method()`: Lấy HTTP method (GET/POST/...)
  - `isGet()`: Kiểm tra xem có phải là GET request
  - `isPost()`: Kiểm tra xem có phải là POST request
  - `getBody()`: Lấy dữ liệu POST

### 3. **core/Response.php** - Quản Lý HTTP Response
- **Vai trò**: Đặt HTTP status code
- **Phương thức chính**:
  - `setStatusCode(int $code)`: Đặt status code (200, 404, 500, ...)

### 4. **core/Router.php** - Xử Lý Routing & Render View
- **Vai trò**: Tìm route tương ứng, gọi controller action, render view
- **Phương thức chính**:
  - `get($path, $callback)`: Đăng ký route GET
  - `post($path, $callback)`: Đăng ký route POST
  - `resolve()`: Tìm route tương ứng với request hiện tại
  - `renderView($view, $params)`: Ghép layout + view content
  - `renderOnlyView($view, $params)`: Render chỉ view (không layout)
  - `layoutContent()`: Lấy nội dung layout
- **Quy trình resolve()**:
  1. Lấy path từ Request
  2. Lấy HTTP method từ Request
  3. Tìm callback trong mảng routes
  4. Nếu không tìm thấy → trả về 404
  5. Nếu là string → render view trực tiếp
  6. Nếu là array → khởi tạo Controller và gọi action

### 5. **core/Controller.php** - Base Controller
- **Vai trò**: Base class cho tất cả controllers
- **Thuộc tính**:
  - `$layout`: Tên layout mặc định (main hoặc auth)
- **Phương thức**:
  - `render($view, $params)`: Render view với layout
  - `setLayout($layout)`: Thay đổi layout

### 6. **core/Model.php** - Base Model & Validation
- **Vai trò**: Base class cho tất cả models, xử lý validation
- **Hằng số Validation Rules**:
  - `RULE_REQUIRED`: Trường không được rỗng
  - `RULE_EMAIL`: Kiểm tra email hợp lệ
  - `RULE_MIN`: Độ dài tối thiểu
  - `RULE_MAX`: Độ dài tối đa
  - `RULE_MATCH`: Giá trị phải khớp với trường khác
- **Phương thức chính**:
  - `loadData($data)`: Nạp dữ liệu từ form vào model
  - `validate()`: Kiểm tra dữ liệu theo rules
  - `rules()`: Định nghĩa validation rules (phải override)
  - `addError($attribute, $rule)`: Thêm lỗi
  - `errorMessages()`: Định nghĩa thông báo lỗi

### 7. **controllers/** - Logic Ứng Dụng
- **Vai trò**: Xử lý logic, gọi model, render view
- **AuthController.php**:
  - `login()`: Hiển thị form login
  - `register(Request $request)`: Xử lý đăng ký
- **SiteController.php**:
  - `home()`: Hiển thị trang home
  - `contact()`: Hiển thị form liên hệ
  - `handleContact()`: Xử lý submit form liên hệ

### 8. **model/** - Dữ Liệu & Validation
- **RegisterModel.php**: 
  - Định nghĩa các thuộc tính: firstname, lastName, email, password, ...
  - Định nghĩa `rules()`: Validation rules
  - Phương thức `register()`: Logic đăng ký tài khoản

### 9. **view/** - Giao Diện Người Dùng
- **Tệp view**: Chứa HTML, có thể sử dụng biến được truyền từ controller
- **Tệp layout**: Chứa HTML chung (header, footer, navigation), placeholder `{{content}}`

---

##  LUỒNG HOẠT ĐỘNG CHI TIẾT

### Ví dụ 1: Truy Cập Trang Home (GET /)

```
1. USER TRUY CẬP TRÌNH DUYỆT
   └─> GET / (hoặc http://localhost/PHPMVCFramework/)

2. public/index.php ĐƯỢC CHẠY
   ├─> require autoload.php (Nạp Composer autoloader)
   ├─> new Application(dirname(__DIR__))  ← Khởi tạo ứng dụng
   ├─> $app->router->get('/', [SiteController::class, 'home'])
   │   (Đăng ký: GET / sẽ gọi SiteController->home())
   └─> $app->run()  ← Chạy ứng dụng

3. Application->run() GỌI Router->resolve()

4. Router->resolve() XỬ LÝ
   ├─> $path = Request->getPath()  ← Lấy path: /
   ├─> $method = Request->method()  ← Lấy method: GET
   ├─> Tìm callback: router['GET']['/'] = [SiteController::class, 'home']
   ├─> Phát hiện callback là array → Khởi tạo Controller
   │   new SiteController()
   └─> Gọi: SiteController->home()

5. SiteController->home() XỬ HIỆN
   ├─> $params = ['name' => 'thecodeholic']  ← Chuẩn bị dữ liệu
   └─> return $this->render('home', $params)
       └─> Router->renderView('home', $params)

6. Router->renderView('home', $params) XỬ LÝ
   ├─> layoutContent = layoutContent()
   │   ├─> ob_start()  ← Bắt đầu capture HTML
   │   ├─> include view/layouts/main.php
   │   └─> ob_get_clean()  ← Lấy HTML đã capture
   │       → <html>...<nav>..</nav>{{content}}</html>
   │
   ├─> viewContent = renderOnlyView('home', $params)
   │   ├─> foreach ($params): $$key = $value
   │   │   ← Tạo biến: $name = 'thecodeholic'
   │   ├─> ob_start()
   │   ├─> include view/home.php
   │   │   → Render: <h1>home</h1>
   │   │           <h3>Welcomne thecodeholic</h3>
   │   └─> ob_get_clean()
   │
   └─> str_replace('{{content}}', viewContent, layoutContent)
       → Thay thế {{content}} bằng nội dung view vào layout

7. TRẢ VỀ HTML ĐẦY ĐỦ
   <html>
     <nav>..navbar..</nav>
     <h1>home</h1>
     <h3>Welcomne thecodeholic</h3>
   </html>

8. HIỂN THỊ TRÊN TRÌNH DUYỆT 
```

### Ví dụ 2: POST /register (Đăng Ký Tài Khoản)

```
1. USER SUBMIT FORM ĐĂNG KÝ
   └─> POST /register (firstname=John&email=john@example.com...)

2. index.php XỬ LÝ
   └─> router->post('/register', [AuthController::class, 'register'])
       └─> $app->run()

3. Router->resolve() TÌM ROUTE
   ├─> $method = POST, $path = /register
   ├─> Tìm: router['POST']['/register'] = [AuthController::class, 'register']
   └─> Gọi: AuthController->register(Request $request)

4. AuthController->register(Request $request) XỬ LÝ
   ├─> if ($request->isPost())  ✅ TRUE
   │
   ├─> $registerModel = new RegisterModel()  ← Khởi tạo Model
   │
   ├─> $registerModel->loadData($request->getBody())  ← Nạp dữ liệu form
   │   ├─> foreach ($data): $this->$key = $value
   │   └─> Gán: $registerModel->firstname = 'John'
   │              $registerModel->email = 'john@example.com'
   │
   ├─> if ($registerModel->validate())  ← Kiểm tra validation
   │   ├─> RegisterModel->validate() CHECK RULES
   │   │   ├─> foreach($this->rules() as $attribute => $rules)
   │   │   ├─> Kiểm tra từng rule:
   │   │   │   - firstname trống? → addError()
   │   │   │   - email là valid email? → kiểm tra
   │   │   │   - password trống? → addError()
   │   │   │
   │   │   └─> return empty($this->errors)
   │   │
   │   └─> Nếu validate() = TRUE
   │       ├─> registerModel->register()  ← Thực hiện đăng ký
   │       └─> return 'success'
   │
   └─> Nếu validate() = FALSE
       └─> return $this->render('register', ['model' => $registerModel])
           (Hiển thị lại form + hiển thị error messages)
```

---

## 📊 FLOW DIAGRAM TỔNG QUAN

```
┌────────────────────────────────────┐
│      USER REQUEST                  │
│    (GET / POST / ...)              │
└────────────┬───────────────────────┘
             │
             ▼
┌────────────────────────────────────┐
│  public/index.php (ENTRY POINT)    │
│  • require autoload.php            │
│  • new Application()               │
│  • register routes                 │
│  • $app->run()                     │
└────────────┬───────────────────────┘
             │
             ▼
┌────────────────────────────────────┐
│ core/Application.php (ĐIỀU PHỐI)   │
│ • Khởi tạo Request/Response        │
│ • Khởi tạo Router                  │
│ • run() → resolve()                │
└────────────┬───────────────────────┘
             │
             ▼
┌────────────────────────────────────┐
│  core/Request.php (LẤY DỮ LIỆU)    │
│  • getPath()                       │
│  • method()                        │
│  • getBody()                       │
└────────────────────────────────────┘
             │
             ▼
┌────────────────────────────────────┐
│ core/Router.php (TÌM ROUTE)        │
│ • resolve()                        │
│ • Gọi callback (controller action) │
└────────┬──────────────┬────────────┘
         │              │
         ▼              ▼
    ┌─────────┐   ┌──────────────┐
    │Controller│   │    Model     │
    │Logic    │   │Validation    │
    └────┬────┘   └──────────────┘
         │
         ▼
┌────────────────────────────────────┐
│ Router->renderView() (RENDER HTML) │
│ • layoutContent()                  │
│ • renderOnlyView()                 │
│ • str_replace({{content}})         │
└────────────┬───────────────────────┘
             │
             ▼
┌────────────────────────────────────┐
│ core/Response.php (RESPONSE)       │
│ • setStatusCode()                  │
└────────────┬───────────────────────┘
             │
             ▼
┌────────────────────────────────────┐
│  TRÌNH DUYỆT NHẬN HTML & HIỂN THỊ  │
└────────────────────────────────────┘
```

---

## 📝 BẢNG TÓCHỢP SỬ DỤNG

| **Folder** | **Tệp** | **Chức Năng** |
|---|---|---|
| **public/** | index.php | Entry point - nơi bắt đầu ứng dụng |
| **core/** | Application.php | Điều phối request/response, khởi tạo thành phần |
| | Router.php | Quản lý routes, tìm controller, render view |
| | Request.php | Lấy dữ liệu từ HTTP request |
| | Response.php | Quản lý HTTP response status code |
| | Controller.php | Base class cho tất cả controllers |
| | Model.php | Base class cho models, xử lý validation |
| **controllers/** | AuthController.php | Xử lý login, register |
| | SiteController.php | Xử lý home page, contact |
| **model/** | RegisterModel.php | Định nghĩa data, rules, logic đăng ký |
| **view/** | *.php | HTML template hiển thị cho người dùng |
| | layouts/ | Layout chính (main.php, auth.php) |

---

## 🎯 QUY TRÌNH REQUEST-RESPONSE CHI TIẾT

1. **Người dùng** gửi request (GET/POST) → `public/index.php`
2. **Application** tạo Request/Response, khởi tạo Router
3. **Router** giải quyết route → tìm Controller & Action
4. **Request** lấy dữ liệu (path, method, form data)
5. **Controller** xử lý logic, gọi Model nếu cần
6. **Model** validate data, thực hiện business logic
7. **Controller** gọi `render('view', $params)`
8. **Router** render view + layout → HTML hoàn chỉnh
9. **Response** đặt status code
10. **Browser** nhận HTML và hiển thị

---

## 💡 CÁC ĐIỂM QUAN TRỌNG

- **Application.php**: Trung tâm điều phối, liên kết tất cả thành phần
- **Router.php**: Cầu nối giữa request và controller
- **Request.php**: Nắm bắt thông tin người dùng gửi
- **Model.php**: Nơi xử lý validation và business logic
- **Controller.php**: Nơi xử lý logic, render view
- **View + Layout**: Sử dụng `ob_start()` & `ob_get_clean()` để capture HTML
- **Placeholder {{content}}**: Thay thế nội dung view vào layout 
 