1. import database từ thư mục gốc

api_test.sql

2. Cấu hình file ENV

3. Chạy lệnh 

php artisan serve 

4. Sử dụng Postman để kiểm tra API

https://www.getpostman.com/downloads/

5. Đăng nhập thông qua API

URL:

http://127.0.0.1:8000/oauth/token


form-data:

grant_type   => password
<br />
client_id	=> 2
<br />
client_secret => 8cSHo0UKIhUo7Nsvha66SthGnaDLZyANCBUbSUNR
<br />
username	=> hmurphy@example.com
<br />
password	=> password


Sau khi thực hiện xong thì sẽ lấy được thông tin access_token


6. Sử dụng access_token để lấy thông tin

- Cấu hình Headers

Accept	=> application/json
<br />
Content-Type	=> application/json
<br />
Authorization 	=> Bearer + access_token


- Vì chỉ là demo nên không có các phân quyền riêng cho user để GET,POST,PUT,DELETE
- Tất cả user đều có thể GET,POST,PUT,DELETE

a. Lấy thông tin danh sách người dùng
	
	GET		http://127.0.0.1:8000/api/users

b. Thêm thành viên
	
	POST 	http://127.0.0.1:8000/api/users

	form-data:

	name	=> Tên thành viên
	email	=> Email thành viên
	password	=> Password thành viên
	address		=> Địa chỉ thành viên
	tel		=> Sđt

c. Lấy thông tin người dùng 

	GET http://127.0.0.1:8000/api/users/{id}

d. Cập nhật thông tin người dùng
	
	PUT http://127.0.0.1:8000/api/users/{id}
	
	
	x-www-url-formurlencode:     //Lưu ý chọn  x-www-url-formurlencode trên postman

	name	=> Tên thành viên
	password	=> Password thành viên
	address		=> Địa chỉ thành viên
	tel		=> Sđt



	





