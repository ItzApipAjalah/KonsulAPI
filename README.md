# Panduan Penggunaan API di Postman

## 1. Login

`POST /api/login`

### Request Body
```json
{
  "email": "siswa@example.com", // ganti sesuai role nya
  "password": "password"
}
``` 

### Response
```json
{
    "message": "Login successful",
    "user": {
        "id": 3,
        "name": "Siswa User",
        "email": "siswa@example.com",
        "role": "siswa"
    },
    "access_token": "1|zZ0xaJs5O7G7WdNRnXsFCPzuIRKhHwSOJi2gSrZfbec067f8",
    "token_type": "Bearer",
    "expires_in": 10080
}
``` 

`copy access_token tersebut , lalu di postman buka Authorization , pilih auth type nya Bearer Token , paste field token nya`

## 2. Membuat Tiket Baru Sebagai Siswa

`POST /api/tickets`

### Request Body
```json
{
    "title": "Masalah Akademik",
    "description": "Saya mengalami kesulitan dalam memahami materi.",
    "priority": "low" //in:low,medium,high
}
``` 

### Response
```json
{
    "message": "Ticket created successfully",
    "ticket": {
        "title": "Masalah Akademik",
        "description": "Saya mengalami kesulitan dalam memahami materi.",
        "priority": "low",
        "siswa_id": 3,
        "updated_at": "2024-08-15T07:45:26.000000Z",
        "created_at": "2024-08-15T07:45:26.000000Z",
        "id": 3
    }
}
``` 

## 3. Accept Tiket Sebagai Guru

`POST /api/tickets/{ticket_id}/accept`

### Request Body
```json
{
    "scheduled_at": "2024-08-16 15:30:00" // date_format:Y-m-d H:i:s
}
``` 

### Response
```json
{
    "message": "Ticket accepted and scheduled",
    "ticket": {
        "id": 3,
        "title": "Masalah Akademik",
        "description": "Saya mengalami kesulitan dalam memahami materi.",
        "siswa_id": 3,
        "guru_id": 2,
        "scheduled_at": "2024-08-16 15:30:00",
        "status": "scheduled",
        "priority": "low",
        "created_at": "2024-08-15T07:45:26.000000Z",
        "updated_at": "2024-08-15T07:49:47.000000Z"
    }
}
```

## 4. Mengirim Pesan Sebagai Guru atau Siswa

`POST /tickets/{ticket_id}/messages`

### Request Body
```json
{
    "message": "Boleh Di perjelas"
}
``` 

### Response 
```json
{
    "message": "Message sent successfully",
    "data": {
        "ticket_id": 3,
        "sender_id": 2,
        "message": "Boleh Di perjelas",
        "updated_at": "2024-08-15T07:50:34.000000Z",
        "created_at": "2024-08-15T07:50:34.000000Z",
        "id": 1
    }
}
```

## 5. Menutup Tiket sebagai Guru

`POST /tickets/{ticket_id}/close`

### Response 
```json
{
    "message": "Ticket closed",
    "ticket": {
        "id": 3,
        "title": "Masalah Akademik",
        "description": "Saya mengalami kesulitan dalam memahami materi.",
        "siswa_id": 3,
        "guru_id": 2,
        "scheduled_at": "2024-08-16 15:30:00",
        "status": "closed",
        "priority": "low",
        "created_at": "2024-08-15T07:45:26.000000Z",
        "updated_at": "2024-08-15T07:54:27.000000Z"
    }
}
```

## Catatan

Pastikan sudah login dan menggunakan token autentikasi yang benar dalam setiap request yang membutuhkan autentikasi.
