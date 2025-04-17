# Project: Museum


# Commands:

- php artisan make:migration add_avatar_to_users_table --table=users
- php artisan migrate

- php artisan make:controller UserController --resource
- php artisan make:controller UserController

- php artisan make:component Breadcrumb
- php artisan make:component ui/Button
- Trong component nên khởi tạo biết trong constructor sẽ được truyền xuống blade

# Create model

- php artisan make:model Exhibition
- php artisan make:model Exhibition -mfc
  + -m: Tạo migration
  + -f: Tạo factory (Factory trong Laravel được dùng để tạo dữ liệu giả lập)
  + -c: Tạo controller

# Explains

- painting: Tranh vẽ
- Sculptures – Tác phẩm điêu khắc
- statues: Tượng
- Fossils – Hóa thạch
- Handicrafts – Đồ thủ công mỹ nghệ