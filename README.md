# My Vacation Planner

This is a personal Laravel project I created to plan my vacations, considering Portuguese national holidays/rules, company-provided days off, and other relevant dates.

---

## Required Software
- PHP
- Composer
- Laravel
- MySQL (or any preferred database)

---

## Running

1. **Clone the Repository:**
```bash
git clone <repository-url>
cd <project-folder>
```

2. **Environment Setup:**
Copy the `.env.example` file and generate the application key:
 
```bash
cp .env.example .env
php artisan key:generate
```

3. **Database Configuration:** 
Update the .env file with your database credentials:

```bash
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Seed Relevant Dates:** 
Adjust or add holidays and company days in the seeders located in ./database/seeders.

5. **Migrate and Seed the Database:**
`php artisan migrate:refresh --seed`

6. **Start the Development Server:**   
`php artisan serve`


# Features
- Auto bridge filler
- Portuguese holliday rules
- Consider company-provided days off
- Optional holidays selection
