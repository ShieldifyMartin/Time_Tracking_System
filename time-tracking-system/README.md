# Time Tracking System Documentation

## Overview
This **Time Tracking System** is a PHP application designed to help in managing teams from different sizes through tracking working hours and other data of every employee.

The system is designed to help companies streamline their employee management operations effectively. Each company manages employees, projects and workloads. Each workload is defined by key details such as the employee, date, amount of hours worked, description of the performed tasks and the date the workload was added.

Users can register and login and there are different roles - regular employee and admin(manager). The managers has full access to the system and can operate with all employees, projects and workloads.

The **SOLID** principles are mostly strictly followed, with an exception of the Interface Segregation Principle (ISP).

## Technology Stack

##### Programming Language: PHP
##### Web Framework: Laravel
##### ORM: Eloquent
##### Testing Framework: PHPUnit

## Local Setup

1. `npm run dev`
2. `php artisan serve`

## Key Features

### Authentication

The system uses Laravel's standard authentication for secure user registration, login, password resets, and logout. Routes are protected using the auth middleware, and passwords are hashed with bcrypt.

### Employee Operations 
Load, create, edit, and delete employee records. Each employee profile includes key details such as names, email, hired since date, salary hours worked etc.

### Project Operations
Load, create, edit, and delete project records. Each customer profile captures key details such as name, description, starting and completion date, status, and more.

### Workload Operations
Load, create, edit, and delete workload records. Each workload profile captures key details such as coresponding employee and project, date, hours worked, description of the completed task and the workload creator.

### Report Generation
The Report Generation feature allows managers to generate a PDF report that includes detailed information about employees, projects and workloads. It lists employee data (name, salary, hours worked) and associated workload details (projects, tasks, hours). It also includes project data (description, status) and associated employee workloads. The report is generated in HTML and converted to PDF for download.

### Working Hours Charts Showcase
The Working Hours Charts Showcase feature displays charts visualizing employees' working hours. It retrieves data on employee workloads for the past month and generates a comprehensive view of work distribution across projects. The data is presented using charts for easy analysis.

## Roadmap
- Real-Time Notifications for exceeding or insufficient working hours, salary payments, project start and completion dates, and other important updates
- Development of a mobile application to enhance user experience (UX)