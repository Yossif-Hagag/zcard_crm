# Laravel CRM System [Z-Card]

## Prerequisites
> This Project Required Composer To Be Installed And PHP 8.1 Or Above
- PHP 8.1 Or Above 
- [Composer](https://getcomposer.org/)


## Installation

### Clone The Project

```bash
git clone https://github.com/Yossif-Hagag/zcard_crm
cd zcard_crm
```

### Install Composer Dependencies 

```bash
composer install

```

### Create .env Then Edit It

```bash
cp .env.example .env
```

### Generate Laravel Key 

```bash
php artisan key:generate
```

### Migrate The DB With Seed

```bash
php artisan migrate --seed
```

### Link Storage

```bash
php artisan storage:link
```

### Run The Server

```bash
php artisan serve
```
