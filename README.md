# first_zalora_project

## Start frontend

1. Install yarn - package manager (parallel install packages)
2. Start

```
npm install -g yarn
yarn
yarn start
```

Open [Dashboard](http://localhost:3000).

### Why use Yarn

<sub> Trong file package.json cả npm và yarn đều dựa vào file cấu hình này thực hiện theo vết các gói phụ thuộc trong dự án, phiên bản các gói không phải lúc nào cũng chính xác. Thay vào đó, thường xác định một khoảng các phiên bản cho phép, bằng cách này cho phép chọn một phiên bản cụ thể nhưng khi cài đặt npm thường chọn phiên bản mới nhất để khắc phục các lỗi phiên bản trước đó. Về lý thuyết, các phiên bản mới sẽ không phá vỡ các kiến trúc trong phiên bản cũ, nhưng thực tế không phải lúc nào cũng vậy. Sử dụng npm để quản lý gói phần mềm có thể dẫn đến trường hợp hai máy có cùng một file cấu hình package.json nhưng lại có các phiên bản của các gói khác nhau và nảy sinh các lỗi “bug on my machine”. Để tránh việc phiên bản không trùng khớp, một phiên bản chính xác sẽ được đưa vào trong file lock để quản lý. Mỗi khi một module được thêm vào, yarn sẽ tạo ra (nếu chưa có) hoặc cập nhật file lock. Bằngản cách này, yarn đảm bảo các máy khác nhau sẽ có cùng phiên bản chính xác trong khi vẫn có một loạt các phiên bản cho phép được định nghĩa trong file package.json </sub>
