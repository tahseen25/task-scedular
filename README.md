# 📧 Task Scheduler with Email Verification & GitHub Timeline Updates

This project is a **PHP-based task scheduler and email notification system** built as an assignment for **rtCamp**.  
It allows users to register their emails, receive verification codes, subscribe/unsubscribe, and get periodic **GitHub timeline updates** delivered via **cron jobs**.

---

## 🚀 Features
- ✅ Email registration with verification code  
- ✅ Unsubscribe via verification code  
- ✅ Fetches latest **GitHub public events API**  
- ✅ Cron job that runs every 5 minutes to send timeline updates  
- ✅ HTML formatted emails with unsubscribe link  
- ✅ Simple file-based storage (no database required)  

---

## 🛠️ Tech Stack
- **Language**: PHP 8+  
- **Storage**: Plain text files (`registered_emails.txt`, `verification_codes.txt`, `unsubscribe_codes.txt`)  
- **Scheduler**: Cron jobs (`setup_cron.sh`, `shell_cron.sh`)  
- **Email Delivery**: PHP `mail()` / SMTP  
- **Version Control**: Git & GitHub Actions  

---

## 📂 Project Structure
