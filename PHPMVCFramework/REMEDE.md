cần tải và sử dụng composer để khi gọi các class thì không cần pahri dùng requie

-       !! file Application troing folder core dùng dùng để kết nối gọi ra các class như router Contrller Model  dùng để liên kết các file với nhau
        Constructor trong file Application.php được tạo ra để khởi động toàn bộ hệ thống MVC ngay khi bạn tạo đối tượng Application.

-       file request dùng để xác định url mà người dùng vào và method họ dùng là gì  dữ liệu trong form header cookies IP user 


- sử dụng hàm get và post chỉ để lây thông tin đường dẫn 
- hàm resolve dùng để hiển thị thông tin giao diện ra màn hình display
- các chạy thì $app->router->get('/login', [AuthController::class, 'login']); 
nó sẻ gọi tới router xử lý đường dẫn và lưu đường dẫn sau đó kiểm tra có hopwk lệ hay không thì hàm renderView chay
xong rồi qua file Application gọi hàm resolve để chạy và hiển thị ra màn hình 
 