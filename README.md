# 🌱 GreenPlot — ระบบจัดการแปลงเพาะปลูก (ฉบับแสดงผลงาน)

> 💡 **โครงงานจบการศึกษา (Capstone Project)**  
> สาขาเทคโนโลยีสารสนเทศ — มหาวิทยาลัยราชภัฏรำไพพรรณี (RBRU)  
> พัฒนาโดย **ภูริพัฒนชัย รัตนาธรรม (ctrlfaith)** 

---

## 🌱 GreenPlot — ระบบจัดการแปลงเพาะปลูก

**GreenPlot** คือระบบจัดการแปลงเพาะปลูก เพื่อช่วยเกษตรกรหรือผู้ดูแลฟาร์มให้สามารถบริหารจัดการข้อมูลต่าง ๆ ได้อย่างเป็นระบบ  
ครอบคลุมทั้งข้อมูลผู้ใช้ ข้อมูลแปลงเพาะปลูก ข้อมูลพืช บันทึกรอบการปลูก ต้นทุนการผลิต ข้อมูลผู้ซื้อ รายงานผลผลิต  
รวมไปถึงระบบแจ้งเตือนอัตโนมัติผ่าน **LINE Messaging API** เพื่อช่วยให้ผู้ใช้งานไม่พลาดกิจกรรมสำคัญตามตารางการดูแลพืช

ในปัจจุบัน เกษตรกรรายย่อยและผู้ปลูกพืชสวนครัวมักประสบปัญหาในการจัดการแปลงเพาะปลูกอย่างเป็นระบบ  
เนื่องจากต้องอาศัยความจำเป็นหลักในการติดตามกิจกรรมต่าง ๆ ทำให้เสี่ยงต่อความผิดพลาดได้ง่าย  
กิจกรรมสำคัญ เช่น การรดน้ำ การใส่ปุ๋ย หรือการเก็บเกี่ยว มักถูกลืมหรือทำไม่ตรงเวลา  
จึงอาจส่งผลกระทบต่อประสิทธิภาพการผลิตและคุณภาพของผลผลิต  

นอกจากนี้ การขาดการบันทึกข้อมูลอย่างเป็นระบบยังทำให้เกษตรกรไม่สามารถวิเคราะห์  
หรือปรับปรุงแนวทางการเพาะปลูกได้อย่างมีประสิทธิภาพ โดยเฉพาะด้านการเงิน  
เกษตรกรส่วนใหญ่ไม่สามารถเห็นภาพรวมได้ชัดเจนว่าในแต่ละรอบการเพาะปลูกมีต้นทุน รายรับ และกำไรเท่าใด  
ทำให้ขาดข้อมูลสำหรับการวางแผนการเพาะปลูกในครั้งถัดไปอย่างเหมาะสม

เพื่อแก้ไขปัญหาดังกล่าว จึงได้พัฒนา **GreenPlot** เว็บแอปพลิเคชันสำหรับจัดการแปลงเพาะปลูกที่ช่วยให้เกษตรกรสามารถ:
- บันทึกและติดตามกิจกรรมการเพาะปลูกอย่างเป็นระบบ  
- จัดเก็บข้อมูลทางการเงิน ทั้งต้นทุน รายรับ และผลผลิตอย่างต่อเนื่อง  
- วิเคราะห์ภาพรวมเศรษฐกิจของแต่ละรอบการเพาะปลูก เช่น ต้นทุนรวม รายได้ และกำไร  
- รับการแจ้งเตือนอัตโนมัติผ่าน LINE Messaging API เพื่อไม่พลาดกิจกรรมสำคัญ  

ระบบนี้ช่วยให้เกษตรกรสามารถนำข้อมูลไปใช้ในการวิเคราะห์ วางแผน และปรับปรุงแนวทางการเพาะปลูกได้อย่างมีประสิทธิภาพและยั่งยืน  

> 🔒 *หมายเหตุ (ด้านเทคนิค)*  
> โปรเจกต์นี้เป็นเวอร์ชัน **แสดงผลงาน (Showcase)**  
> มีการแสดงเฉพาะบางส่วนของโค้ดจริงจากระบบ เพื่อใช้ในการสาธิตแนวทางการพัฒนา  
> ไม่มีการเชื่อมต่อฐานข้อมูลจริง และไม่มีการเปิดเผยโค้ดหรือข้อมูลสำคัญทั้งหมดที่เกี่ยวข้องกับระบบจริง

---

## 🎯 วัตถุประสงค์ของโครงการ

- ลดความผิดพลาดในการจัดการรอบการเพาะปลูกให้เป็นระบบและแม่นยำยิ่งขึ้น  
- ช่วยให้เกษตรกรสามารถติดตามต้นทุน รายรับ และผลกำไรได้อย่างชัดเจนและต่อเนื่อง  
- พัฒนาเครื่องมือแจ้งเตือนกิจกรรมสำคัญ เช่น การรดน้ำ การใส่ปุ๋ย และการเก็บเกี่ยว  
  รวมถึงการแจ้งเตือนเมื่อมีการบันทึกผลผลิตใหม่ หรือเมื่อสถานะการชำระเงินจากผู้ซื้อมีการเปลี่ยนแปลง (เช่น จาก “ค้างชำระ” เป็น “ชำระแล้ว”)  
- วิเคราะห์ประสิทธิภาพของแต่ละแปลงเพาะปลูกและชนิดพืช พร้อมรายงานสรุปผลในรูปแบบกราฟและสถิติ เพื่อสนับสนุนการวางแผนเพาะปลูกอย่างยั่งยืน  

---

## 🛠 Tech Stack

- **Laravel / PHP** – สำหรับพัฒนา Backend และ RESTful API  
- **HTML, CSS (Custom + Tailwind CSS)** – ออกแบบโครงสร้างและส่วนติดต่อผู้ใช้ (UI)  
- **JavaScript / Alpine.js** – เพิ่มความโต้ตอบและการทำงานแบบ Dynamic ในหน้าเว็บ  
- **MySQL** – ระบบจัดการฐานข้อมูลหลักของระบบ  
- **Chart.js** – แสดงกราฟและสถิติในแดชบอร์ด  
- **Laravel DomPDF** – สร้างและส่งออกรายงานในรูปแบบ PDF  
- **LINE Messaging API** – ใช้ส่งข้อความแจ้งเตือนอัตโนมัติถึงผู้ใช้ผ่าน LINE Official Account  


---

## ✨ ฟีเจอร์หลักของระบบ

| ฟีเจอร์ | รายละเอียด |
|-----------|--------------|
| 👤 **ระบบผู้ใช้งาน (User System)** | สมัครสมาชิก, เข้าสู่ระบบ, จัดการโปรไฟล์, เปลี่ยนรหัสผ่าน, ลบบัญชีผู้ใช้ และตั้งค่าการเชื่อมต่อ LINE สำหรับรับการแจ้งเตือนอัตโนมัติ |
| 🏡 **หน้าแรก (Landing Page)** | แสดงจุดเด่นของระบบ พร้อมปุ่มเริ่มต้นใช้งานและคำอธิบายฟีเจอร์หลักอย่างชัดเจน |
| 🌾 **การจัดการแปลงเพาะปลูก (Garden Management)** | **เพิ่ม / ดู / แก้ไข / ลบ** ข้อมูลแปลงเพาะปลูก (ชื่อแปลง พื้นที่ สถานที่ตั้ง การผูกกับผู้ใช้) |
| 🌱 **การจัดการข้อมูลพืช (Plant Management)** | **เพิ่ม / ดู / แก้ไข / ลบ** ข้อมูลพืช เช่น รอบรดน้ำ–ใส่ปุ๋ย ระยะเก็บเกี่ยว ข้อมูลโรคพืช แนวทางป้องกัน และสารเคมีที่ใช้ |
| 📅 **บันทึกการปลูก (Planting Records)** | **เพิ่ม / ดู / แก้ไข / ลบ** บันทึกการปลูกในแต่ละแปลง เช่น วันที่เริ่มปลูก คาดการณ์วันเก็บเกี่ยว สถานะรอบปลูก |
| 💰 **ระบบบันทึกต้นทุน (Cost Management)** | **เพิ่ม / ดู / แก้ไข / ลบ** รายการค่าใช้จ่าย พร้อมระบบ Keyword Matching สำหรับจัดหมวดหมู่ต้นทุนอัตโนมัติ (เช่น ปุ๋ย น้ำ ค่าแรง และวัสดุอุปกรณ์) เพื่อสนับสนุนการวิเคราะห์ต้นทุนและกำไร |
| 🧾 **ระบบจัดการผู้ซื้อ (Buyer Management)** | **เพิ่ม / ดู / แก้ไข / ลบ** ข้อมูลผู้ซื้อ เช่น ประเภทผู้ซื้อ ช่องทางติดต่อ สถิติการซื้อสะสม |
| 🌾 **บันทึกผลผลิต (Yield Records)** | **เพิ่ม / ดู / แก้ไข / ลบ** ข้อมูลผลผลิต เช่น ปริมาณผลผลิต รายได้ ผู้ซื้อ สถานะการชำระเงิน และวันที่เก็บเกี่ยว |
| 📈 **แดชบอร์ดภาพรวม (Overview Dashboard)** | แสดงข้อมูลสรุป เช่น จำนวนแปลง พื้นที่ปลูก ผลผลิตรวม รายได้ ต้นทุน กำไร ROI พร้อมกราฟเปรียบเทียบรายเดือน |
| 📊 **รายงานและสรุปผล (Reports & Analytics Overview)** | หน้ารวมรายงาน แสดงหมวดรายงาน “กำไร–ขาดทุน” และ “สรุปผลผลิต” พร้อมคำอธิบายฟีเจอร์และปุ่มเข้าสู่รายงานแต่ละประเภท |
| 💵 **รายงานกำไร–ขาดทุน (Profit & Loss Report)** | วิเคราะห์รายได้ ต้นทุน และกำไรสุทธิของแต่ละรอบปลูก พร้อมฟังก์ชัน: <br>• ROI (Return on Investment) <br>• Break-even Analysis (จุดคุ้มทุน) <br>• Cost Breakdown (แยกต้นทุนตามหมวด) <br>• Trend Graph (กราฟแนวโน้มรายได้–ต้นทุน) <br>• Export PDF รายงานสรุป |
| 🪴 **รายงานผลผลิต (Harvest Summary Report)** | วิเคราะห์ข้อมูลผลผลิตรวมในแต่ละช่วงเวลา พร้อมสถิติสำคัญ: <br>• จำนวนรอบเก็บเกี่ยว <br>• ปริมาณผลผลิตรวม <br>• รายได้รวม <br>• KPI ด้านผลผลิต <br>• Top Performance (พืช/ผู้ซื้อที่มีผลผลิตดีที่สุด) <br>• Leaderboard Top 5 <br>• Heatmap ปฏิทินผลผลิตตามเวลา <br>• Export PDF รายงานผลผลิต |
| 👥 **โปรไฟล์และการเชื่อมต่อ (Profile Management)** | จัดการข้อมูลผู้ใช้, เชื่อมต่อ/ยืนยัน **LINE User ID**, ตั้งค่าการแจ้งเตือน, เปลี่ยนรหัสผ่าน และลบบัญชีผู้ใช้ |
| 🔔 **การแจ้งเตือนผ่าน LINE (LINE Messaging API)** | ส่งข้อความอัตโนมัติผ่าน LINE Official เช่น <br>• แจ้งเตือนรดน้ำ/ใส่ปุ๋ย/เก็บเกี่ยว <br>• แจ้งเตือนสถานะการชำระเงิน <br>• ยืนยันการเชื่อมต่อบัญชี LINE <br>• ข้อความต้อนรับเมื่อเพิ่มเพื่อน |
| 📄 **ส่งออกรายงาน (Export Reports)** | ดาวน์โหลดรายงานได้ทั้งแบบ **สรุปผลผลิต (Harvest)** และ **กำไร–ขาดทุน (Profit & Loss)** ในรูปแบบ **PDF** |


---

## 📸 ตัวอย่างภาพหน้าจอ

ภาพหน้าจอของระบบทั้งหมดสามารถดูได้ในโฟลเดอร์ [`/screenshot`](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/tree/main/screenshot)


ภาพหน้าจอบางส่วนจากระบบ GreenPlot:

### 🏠 Landing Page
![Landing Page](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Landing%20Page/GreenPlot-Landing-Page.png?raw=true)

### 🔐 หน้าลงทะเบียนและเข้าสู่ระบบ (Authentication)
![Register Page](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Authentication/Register-Page.png?raw=true)
![Login Page](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Authentication/Login-Page.png?raw=true)

### 📊 Dashboard
![Dashboard Overview](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Dashboard/Overview-Dashboard.png?raw=true)

### 🌾 การจัดการแปลงเพาะปลูก
![Garden Management](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Garden%20Management/Garden-Management.png?raw=true)

### 🌱 การจัดการข้อมูลพืช
![Plant Management](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Plant%20Management/Plant-Management.png?raw=true)

### 📘 บันทึกการปลูก
![Planting Records](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Planting%20Records/Planting-Records-Management.png?raw=true)

### 🛒 ระบบจัดการผู้ซื้อ
![Buyer Management](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Buyer%20Management/Buyer-Management.png?raw=true)

### 💰 ระบบบันทึกต้นทุน
![Cost Management](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Cost%20Management/Cost-Management.png?raw=true)

### 🧾 ระบบบันทึกผลผลิต
![Yield Records](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Yield%20Records/Yield-Records-Management.png?raw=true)

### 📈 รายงานสรุปผลผลิต
![Harvest Summary Report](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Reports/Harvest-Summary-Detailed.png?raw=true)

### 💹 รายงานกำไร–ขาดทุน
![Profit & Loss Report](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Reports/ProfitLoss-Report-Detailed.png?raw=true)

### 🧩 หน้ารายงานภาพรวม
![Reports Overview](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Reports/Reports-Overview.png?raw=true)

### 👤 การจัดการโปรไฟล์และตั้งค่า LINE Notify
![Profile Management](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/Profile%20Management/Profile-Management.png?raw=true)

### 💬 การแจ้งเตือนผ่าน LINE Messaging API
![LINE Notifications](https://github.com/ctrlfaith/Greenplot-Manager-Showcase/blob/main/screenshot/LINE%20Notifications/line-notifications-events.jpg?raw=true)

---

## 🧩 ตัวอย่างโค้ดจริงจากระบบ

โฟลเดอร์ [`/sample-code`](./sample-code)  
เก็บตัวอย่างไฟล์โค้ดจากระบบจริง เพื่อแสดงแนวทางการออกแบบและพัฒนาโครงสร้างภายในของระบบ GreenPlot

| ไฟล์ | รายละเอียด |
|-------|-------------|
| `PlantController.php` | จัดการข้อมูลพืช — เพิ่ม / แก้ไข / ลบ / แสดงข้อมูลพืช |
| `ReportController.php` | จัดการการสร้างรายงานสรุปผลผลิตและคำนวณกำไร–ขาดทุน |
| `api.php` / `web.php` | เส้นทาง API และเส้นทางเว็บเพจหลักของระบบ |
| `dashboard.blade.php` | หน้าแดชบอร์ดภาพรวมของระบบ |
| `profit-loss.blade.php` | หน้ารายงานกำไร–ขาดทุนแบบกราฟและตาราง |
| `harvest-summary.blade.php` | หน้ารายงานสรุปผลผลิตประจำรอบการเพาะปลูก |
| `index.blade.php` | หน้าภาพรวมของหมวดรายงานสรุปผล |

> ⚙️ *หมายเหตุ:* โค้ดในส่วนนี้เป็นเพียงตัวอย่างบางส่วนจากระบบจริง  
> จัดทำขึ้นเพื่อสาธิตแนวทางการพัฒนาและโครงสร้างของระบบเท่านั้น

---

## 📘 ข้อมูลโครงการ

**ชื่อโครงการ:** GreenPlot – ระบบจัดการแปลงเพาะปลูก  
**ประเภทโครงงาน:** โครงงานจบการศึกษา (Capstone Project)  
**สาขา:** เทคโนโลยีสารสนเทศ (Information Technology)  
**สังกัด:** มหาวิทยาลัยราชภัฏรำไพพรรณี (RBRU)  
**ภาษาที่ใช้พัฒนา:** PHP (Laravel), HTML, CSS (Tailwind CSS), JavaScript (Alpine.js)

---

## 👨‍💻 ผู้จัดทำ

**ภูริพัฒนชัย รัตนาธรรม**  
นักศึกษาชั้นปีที่ 4 สาขาเทคโนโลยีสารสนเทศ  
มหาวิทยาลัยราชภัฏรำไพพรรณี (RBRU)

📎 GitHub: [ctrlfaith](https://github.com/ctrlfaith)  
📧 Email: [bhm.rattanatham@gmail.com](mailto:bhm.rattanatham@gmail.com)

---

## ⚖️ เงื่อนไขการเผยแพร่และเจตนาของโครงการ

โปรเจกต์นี้จัดทำและเผยแพร่เพื่อแสดงผลงานเท่านั้น  
**ห้ามคัดลอก แก้ไข หรือเผยแพร่ซ้ำโดยไม่ได้รับอนุญาตจากเจ้าของผลงาน**

> “GreenPlot เป็นผลงานที่เกิดจากความตั้งใจ  
> ที่จะใช้เทคโนโลยีช่วยให้การเกษตรในชีวิตจริงมีประสิทธิภาพมากขึ้น  
> ทั้งในการบันทึกข้อมูล การวางแผน และการจัดการผลผลิตอย่างยั่งยืน”
