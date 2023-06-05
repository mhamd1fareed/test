# Project Cost Management System ( Matrix Company Technical Test) 

This project is part of the technical test for Matrix Company. It is a simple system designed to manage project costs. The system allows for the definition of projects, different currencies, and the addition of cost executions for each project using various currency units.

## Features

- Project management: Define projects with names and descriptions.
- Currency management: Define different currencies within the system.
- Cost execution management: Add cost executions for each project using different currency units.
- Database integration: The project includes setting up a database to store project and cost information.

## Requirements

To run the project, you need to have the following:

- Laravel framework: The project is built using the Laravel framework, so make sure you have it installed.
- PHP: The project requires PHP to run. Install the appropriate version for Laravel.
- Database: Set up a database (MySQL, PostgreSQL, SQLite, etc.) and update the configuration accordingly.

## Installation

Follow these steps to get the project up and running:

1. Clone the repository:

git clone https://github.com/mhamd1fareed/test.git


2. Change directory to the project:

cd Project-Cost-Management-System

3. Install dependencies using Composer:

composer instal

4. Configure the database:

- Create a new database for the project.
- Copy the `.env.example` file and rename it to `.env`.
- Update the database configuration in the `.env` file with your database credentials.

5. Run database migrations :
_to get the database, download it from this link: https://drive.google.com/file/d/1gf3Ha_0-4EAF2YKlq162P-qnXnN6Icn-/view?usp=sharing 
_php artisan migrate


6. Start the development server:

php artisan serve


7. Visit `http://localhost:8000` in your web browser to access the project.

## Contributing

If you would like to contribute to this project, you can follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes and commit them.
4. Push your changes to your forked repository.
5. Submit a pull request to the original repository.







