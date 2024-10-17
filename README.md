# SoftCRM System in Laravel 11 with PHP [>8.2]
<p align="center">
  <img src="https://i.ibb.co/z8ssKdN/Przechwytywanie.jpg">
</p>

SoftCRM is a comprehensive database system designed to streamline B2B company management. By analyzing customer interactions and history, it helps businesses enhance client relationships and improve customer retention. With a focus on driving sustainable sales growth, SoftCRM provides essential tools for managing customer data, tracking sales, and planning strategies, ensuring efficient and profitable operations.

# Project Overview
This repository marks the beginning of an exciting journey, with its first commit made on July 25, 2017. Since then, it has evolved significantly, reflecting countless hours of dedication, hard work, and passion for crafting a valuable tool.

I invite you to explore the project and appreciate the effort that has gone into its development. Your feedback and contributions are highly valued as we continue to enhance and grow this project together.


<img src="https://i.imgur.com/6LLw8MX.png">

## Functionality:
#### Core Features:
- **Customer management**: Efficiently manage customer data, track interactions, and maintain detailed customer profiles to enhance relationships and improve customer retention.
- **Employee management**: Organize employee information, assign tasks, and monitor performance to optimize workforce productivity and collaboration.
- **Business management**: Oversee the overall business operations, manage company data, and streamline communication between departments.
- **Contract management between companies**: Handle contracts with partner companies, track agreement statuses, and ensure compliance with legal requirements.

#### Marketing:
- **Product management**: Maintain a detailed inventory of products, track availability, and manage pricing to align with market demands.
- **Task management for employees**: Assign and monitor tasks related to marketing campaigns, ensuring that employees stay on top of their responsibilities.

#### Sales:
- **Finance management**: Keep track of all financial transactions, manage budgets, and ensure that financial resources are used efficiently.
- **Sales management**: Oversee the entire sales process, from lead generation to closing deals, and track performance metrics to drive growth.

#### Statistics:
- **Detailed statistics for every day, including yesterday, weekly, and yearly summaries**: Generate comprehensive reports showing key performance indicators (KPIs) to help you analyze trends and make informed business decisions.
- **Total count of all operations within the system**: Get a complete overview of all activities happening within the system to monitor efficiency and operational output.


####  Keep in mind that this is not the end of the functionality of this system because I am constantly developing it!

## Installation

#### 1. To install run the following commands in a working directory: 
```
git clone https://github.com/KamilGrzechulski/SoftCRM.git
```
#### 2. Now run and make sure you have the composer installed on your machine:
```
composer install 
```

#### 3. In the next step, open the .env.example file. Change the data of this file to .env and the details of the site, database and email settings.
```
cp .env.example .env 
```

#### 4. Run the command from the main project folder to create database tables. This is our custom command to process all missing functions.
```
php artisan process-softcrm
```

#### 5. that's all ! Now start the laravel server using the command:
```
php artisan serve
```

#### 6. Login to SoftCRM by using this account:
```
user: admin@admin.com
password: admin
```


# Now you should then be able to access SoftCRM easily!

I appreciate you taking the time to explore my work on <strong>SoftCRM</strong>. If you found it valuable, consider supporting me with a small donation for a beer via PayPal! Thank you!

<img src="https://i.ibb.co/NmFYNfx/beer-1.png">


[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=KVZEXQKGZU2ZN&currency_code=USD&source=url)
