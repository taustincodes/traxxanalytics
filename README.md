# Traxx Analytics

Traxx allows traders to track and visualise their trades, in order to improve trading strategies and performance.

## Screenshots
<div style="display: flex;">
  <img src="https://user-images.githubusercontent.com/87614942/232610987-807f52e1-7b4f-4cff-bbd7-b423c69a50bc.png" width="30%">
  <img src="https://user-images.githubusercontent.com/87614942/232610992-42ff670a-b04a-4e11-aa0e-faaf9674a7d5.png" width="30%">
  <img src="https://user-images.githubusercontent.com/87614942/232610999-317f46a8-14f9-4505-b0f0-0b694101ddea.png" width="30%">
</div>

## Basic Installation
### Requirements
- PHP 8.1
- MariaDB 15.5
- Composer 2
- NPM 9

### Commands
- run `php bin/console doctrine:database:create`
- run `php bin/console doctrine:migrations:migrate`
- run `composer i`
- run `npm i`
- run `npm run build`
- run `symfony server:start`

## Test User
The following test user is added to the database in the initial migration
- username: `admin@traxxanalytics.com`
- password: `password`

## Registration / Email Setup
Setting up account registration and reset password functionality requires several prerequisite and is therefore not included in the basic installation steps. Hence Test User details are provided in this file.
- Create a free API account with MailerSend at `https://www.mailersend.com/`
- Create the following email templates and assign the template IDs from within mailersend to the corresponding environment variables in your .env. Ensure that the corresponding template variables are present within the MailerSend template.
  - Verify Email Template
    - Template Parameters
      - `supportEmail`
      - `verificationURL`
    - Environment variable = `VERIFY_EMAIL_TEMPLATE_ID`
  - Reset Password Template
    - Template Parameters
      - `resetToken`
     - Environment variable = `RESET_PASSWORD_TEMPLATE_ID`
- Assign MailerSend API key to `MAILER_SEND_API_KEY` in .env
