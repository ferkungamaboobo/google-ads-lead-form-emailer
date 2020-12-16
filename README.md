# google-ads-lead-form-emailer
Webhook for Google Ads Lead Form Extensions that emails arbitrary users using SMTP via PHPMailer.

Requires [PHPMailer](https://github.com/PHPMailer/PHPMailer) to work.

## Email Output format
```
Full Name: FirstName LastName
User Phone: +16505550123
User Email: test@example.com
Postal Code: 94043

Google Secret 

ID Hashes:
Lead ID: TeSter-123-ABCDEFGHIJKLMNOPQRSTUVWXYZ-abcdefghijklmnopqrstuvwxyz-0123456789-AaBbCcDdEeFfGgHhIiJjKkLl
Form ID: 12312312312
CLID: TeSter-123-ABCDEFGHIJKLMNOPQRSTUVWXYZ-abcdefghijklmnopqrstuvwxyz-0123456789-AaBbCcDdEeFfGgHhIiJjKkLl
```
